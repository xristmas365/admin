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
use yii\helpers\ArrayHelper;
use app\modules\store\models\Product;
use app\modules\store\models\Catalog;
use app\modules\store\models\search\ProductSearch;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class FrontController extends Controller
{
    
    public function actionIndex()
    {
        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->frontSearch(Yii::$app->request->queryParams);
        $catalogs = ArrayHelper::map(Catalog::find()->roots()->all(), 'id', 'name');
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'catalogs'     => $catalogs,
        ]);
    }
    
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
