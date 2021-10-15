<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\store\models;

use Yii;
use Stripe\Charge;
use yii\base\Model;
use Stripe\StripeClient;
use Stripe\StripeObject;
use app\modules\user\models\User;
use app\modules\user\models\Role;
use app\modules\user\models\Card;
use yz\shoppingcart\ShoppingCart;
use yii\base\InvalidCallException;
use app\modules\user\models\Charge as UserCharge;

/**
 * Class Billing
 *
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $token
 * @property  User  $user
 * @property  Order $order
 *
 * @package app\modules\store\models
 */
class Billing extends Model
{
    
    public  $name;
    
    public  $email;
    
    public  $phone;
    
    public  $token;
    
    private $user;
    
    private $order;
    
    public function rules()
    {
        $rules = [
            [['name', 'email'], 'required'],
            [['name', 'phone'], 'string'],
            [['email'], 'email'],
            [['token'], 'safe'],
        ];
        
        if(Yii::$app->user->isGuest) {
            $rules[] = [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Account Already Exists'];
        }
        
        return $rules;
    }
    
    public function attributeLabels()
    {
        return [
            'token' => 'Payment Method',
        ];
    }
    
    public function init()
    {
        if(!Yii::$app->user->isGuest) {
            $this->user = Yii::$app->user->identity;
            $this->attributes = $this->user->attributes;
        }
        parent::init();
    }
    
    public function proceed()
    {
        if(!$this->validate()) {
            return false;
        }
        
        try {
            $charge = $this->charge();
            
            if(!$charge) {
                $this->addError('token', 'Invalid Card Payment');
                
                return false;
            }
            
        } catch(\Exception $e) {
            $this->addError('token', $e->getMessage());
        }
        
        if($this->hasErrors()) {
            return false;
        }
        
        return Yii::$app->user->isGuest ? Yii::$app->user->login($this->user) : true;
        
    }
    
    protected function charge()
    {
        if(!$this->user) {
            $this->createUser();
        }
        
        $this->order = $this->createOrder();
        
        if(!$this->order) {
            $this->addError('token', 'Something went wrong with order. Try Later');
            
            return false;
        }
        
        $stripe = new StripeClient(getenv('STRIPE_SK'));
        
        if(!$this->user->stripe_id) {
            $customer = $stripe->customers->create([
                'email' => $this->email,
                'name'  => $this->name,
                'phone' => $this->phone,
            ]);
        } else {
            $customer = $stripe->customers->retrieve($this->user->stripe_id);
        }
       
        
        $charge = $stripe->charges->create([
            'amount'   => round($this->order->total * 100),
            'currency' => 'usd',
            'source'   => $this->token,
        ]);
        
        return $this->createUserCharge($charge);
    }
    
    protected function createUser()
    {
        $user = new User([
            'email'     => $this->email,
            'role'      => Role::CUSTOMER,
            'password'  => $this->email,
            'name'      => $this->name,
            'phone'     => $this->phone,
            'confirmed' => true,
        ]);
        
        if(!$user->save()) {
            throw new InvalidCallException();
        }
        
        $this->user = $user;
    }
    
    public function createOrder()
    {
        /**
         * @var ShoppingCart $cart
         */
        $cart = Yii::$app->cart;
        
        /**
         * Order
         */
        $orderSum = $cart->cost;
        
        /**
         * Discount
         */
        $discount = Coupon::getDiscount();
        $discountSum = $orderSum * ($discount / 100);
        
        /**
         * Subtotal
         */
        $orderSubTotal = $orderSum - $discountSum;
        
        /**
         * Sale Taxes
         */
        $tax = Yii::$app->getModule('store')->tax;
        $taxSum = $tax * $orderSubTotal;
        
        $order = new Order([
            'coupon_id'       => Yii::$app->session->get('coupon-discount'),
            'created_by'      => $this->user->id,
            'sum'             => $orderSum,
            'coupon_discount' => $discountSum,
            'tax'             => $taxSum,
            'total'           => $orderSubTotal + $taxSum,
        ]);
        
        if(!$order->save()) {
            return null;
        }
        
        foreach($cart->positions as $position) {
            $productPrice = $position->getPrice();
            $productQuantity = $position->getQuantity();
            
            $productSubTotal = $productPrice * $productQuantity;
            $productDiscount = ($discount / 100) * $productSubTotal;
            $productTax = $tax * $productSubTotal;
            $productTotal = $productSubTotal - $productDiscount + $productTax;
            
            $orderProduct = new OrderProduct([
                'order_id'        => $order->id,
                'product_id'      => $position->getId(),
                'price'           => $productPrice,
                'quantity'        => $productQuantity,
                'coupon_discount' => $productDiscount,
                'tax'             => $productTax,
                'sum'             => $productTotal,
            ]);
            $orderProduct->save();
        }
        
        /**
         * Clear Store Session
         */
        Yii::$app->session->remove('coupon-discount');
        $cart->removeAll();
        
        return $order;
        
    }
    
    /**
     * @param Charge $charge
     *
     * @return bool
     */
    public function createUserCharge(Charge $charge)
    {
        if(Yii::$app->user->isGuest) {
            $userCard = $this->createUserCard($charge);
        } else {
            $userCard = Card::findOne(['source' => $this->token]);
        }
        
        if(!$userCard) {
            return false;
        }
        
        $userCharge = new UserCharge([
            'order_id'  => $this->order->id,
            'user_id'   => $this->user->id,
            'card_id'   => $userCard->id,
            'stripe_id' => $charge->id,
            'amount'    => $this->order->total,
            'paid'      => $charge->paid,
        ]);
        
        return $userCharge->save();
    }
    
    /**
     * Saves Users Card into DB
     *
     * @param Charge $charge
     *
     * @return Card|null
     */
    protected function createUserCard(Charge $charge)
    {
        /**
         * @var $payment StripeObject
         */
        $payment = $charge->payment_method_details;
        
        $userCard = new Card([
            'user_id' => $this->user->id,
            'source'  => $charge->payment_method,
            'brand'   => $payment->card->brand,
            'country' => $payment->card->country,
            'number'  => $payment->card->last4,
        ]);
        
        return $userCard->save() ? $userCard : null;
        
    }
    
    
}
