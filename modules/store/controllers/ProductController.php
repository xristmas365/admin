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
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\modules\store\models\Product;
use app\modules\store\models\Catalog;
use app\modules\warehouse\models\Warehouse;
use app\modules\store\models\search\ProductSearch;
use app\modules\warehouse\models\ProductWarehouse;
use app\modules\admin\controllers\BackendController;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackendController
{
    
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        //for($i = 1; $i < 1000; $i++) {
        //    $model = new Product([
        //        'title' => 'Product ' . $i,
        //        'price' => rand(5, 1000),
        //    ]);
        //    $model->save();
        //}
        
        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'warehouseList' => Warehouse::getWarehouseList(Yii::$app->user->id),
        
        ]);
    }
    
    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product;
        $model->active = Product::ACTIVE;
        
        $rootCatalogs = ArrayHelper::map(Catalog::find()->roots()->asArray()->all(), 'id', 'name');
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('form', ['model' => $model, 'rootCatalogs' => $rootCatalogs]);
    }
    
    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Product::findOne(['id' => $id]);
        
        $rootCatalogs = ArrayHelper::map(Catalog::find()->roots()->asArray()->all(), 'id', 'name');
        
        if(!$model) {
            return $this->redirect(['index']);
        }
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('form', ['model' => $model, 'rootCatalogs' => $rootCatalogs]);
    }
    
    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $product = Product::findOne(['id' => $id]);
        
        if($product) {
            return $product->delete();
        }
        
        return false;
    }
    
    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionReceive()
    {
        $warehouseId = Yii::$app->request->post('warehouse_id');
        
        $warehouse = Warehouse::findOne(['id' => $warehouseId, 'active' => true]);
        
        if(!$warehouse) {
            throw new NotFoundHttpException('Warehouse not found');
        }
        
        $productIds = Yii::$app->request->post('products_ids');
        
        $products = Product::find()
                           ->select(['id', 'title', 'price'])
                           ->andWhere(['id' => explode(',', $productIds)])
                           ->asArray()
                           ->all();
        
        return $this->render('receive', [
            'warehouse' => $warehouse,
            'products'  => $products,
        ]);
    }
    
    /**
     *
     *
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionReceiveProducts($id)
    {
        $productReceive = Yii::$app->request->post('Receive');
        
        foreach($productReceive as $value) {
            $model = new ProductWarehouse([
                    'product_id'   => $value['id'],
                    'warehouse_id' => $id,
                    'quantity'     => $value['quantity'],
                    'status'       => ProductWarehouse::STATUS_INBOUND,
                    'price'        => $value['price'],
                    'total'        => $value['price'] * $value['quantity'],
                
                ]
            );
            $model->save();
        }
        
        Yii::$app->session->setFlash('success', 'Products have been successfully transferred to the warehouse');
        
        return $this->redirect(["/warehouse/default/view?id=$id"]);
    }
    
}
