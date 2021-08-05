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
use yz\shoppingcart\ShoppingCart;
use app\modules\store\models\Product;

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
    
    public function init()
    {
        $this->cart = Yii::$app->cart;
        parent::init();
    }
    
    /**
     * User's Shopping Bag
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
