<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\store\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yz\shoppingcart\ShoppingCart;
use app\modules\store\models\Coupon;
use app\modules\store\models\Product;
use app\modules\store\models\Billing;

/**
 * CartController implements Shopping Bag
 *
 * @property ShoppingCart $cart
 *
 */
class CartController extends Controller
{
    
    public $enableCsrfValidation = false;
    
    /**
     * @var ShoppingCart
     */
    public $cart;
    
    public $coupon;
    
    public function init()
    {
        $this->cart = Yii::$app->cart;
        $couponDiscountId = Yii::$app->session->get('coupon-discount');
        $this->coupon = Coupon::findOne(['id' => $couponDiscountId]);
        parent::init();
    }
    
    /**
     * User's Shopping Bag
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->cart->positions,
            'sort'      => false,
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'cart'         => $this->cart,
            'coupon'       => $this->coupon,
        ]);
    }
    
    public function actionBilling()
    {
        $billing = new Billing;
        
        if($billing->load(Yii::$app->request->post()) && $billing->proceed()) {
            return $this->redirect(['invoice']);
        }
        
        return $this->render('billing', [
            'cart'    => $this->cart,
            'billing' => $billing,
            'coupon'  => $this->coupon,
        ]);
    }
    
    public function actionInvoice()
    {
        return $this->render('invoice');
    }
    
    public function actionAdd($slug)
    {
        Yii::$app->response->format = 'json';
        
        $product = Product::find()
                          ->select(['id', 'slug', 'price', 'title'])
                          ->where([
                              'slug'   => $slug,
                              'active' => true,
                          ])->one();
        
        if($product) {
            $qty = Yii::$app->request->post('qty', 1);
            $productExist = $this->cart->getPositionById($product->id);
            if($productExist) {
                $this->cart->update($product, $productExist->quantity + $qty);
            } else {
                $this->cart->put($product, $qty);
            }
            
            return true;
        }
        
        return false;
    }
    
    public function actionRemove($slug)
    {
        Yii::$app->response->format = 'json';
        
        $product = Product::find()
                          ->select(['id', 'slug', 'price', 'title'])
                          ->where([
                              'slug'   => $slug,
                              'active' => true,
                          ])->one();
        
        if($product) {
            $qty = Yii::$app->request->post('qty', 1);
            $productExist = $this->cart->getPositionById($product->id);
            if($productExist) {
                $this->cart->update($product, $productExist->quantity - $qty);
            } else {
                $this->cart->put($product, $qty);
            }
            
            return true;
        }
        
        return false;
    }
    
    public function actionCoupon()
    {
        Yii::$app->response->format = 'json';
        
        $couponName = Yii::$app->request->post('coupon');
        
        $coupon = Coupon::find()
                        ->andWhere(['name' => $couponName])
                        ->andWhere(['active' => true])
                        ->andWhere(['deleted' => false])
                        ->andWhere(['<', 'start_date', time()])
                        ->andWhere(['>', 'end_date', time()])
                        ->one();
        
        if(!$coupon) {
            return false;
        }
        
        if(Yii::$app->session->has('coupon-discount')) {
            Yii::$app->session->remove('coupon-discount');
        }
        
        Yii::$app->session->set('coupon-discount', $coupon->id);
        
        return true;
        
    }
    
    public function actionCouponDelete()
    {
        Yii::$app->response->format = 'json';
        
        if(Yii::$app->session->has('coupon-discount')) {
            Yii::$app->session->remove('coupon-discount');
        }
    }
    
    public function actionDelete($slug)
    {
        Yii::$app->response->format = 'json';
        
        $product = Product::findone([
            'slug'   => $slug,
            'active' => true,
        ]);
        
        if($product) {
            $this->cart->remove($product);
            
            return true;
        }
        
        return false;
    }
    
    
}
