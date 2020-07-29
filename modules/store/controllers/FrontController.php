<?php
/**
 * FrontController.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\store\controllers;

use yii\web\Controller;
use app\modules\store\models\Product;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class FrontController extends Controller
{
    
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionProduct($slug)
    {
        $product = Product::find()->with(['attachments'])->where(['slug' => $slug])->one();
        
        return $this->render('product', ['product' => $product]);
    }
    
    
}
