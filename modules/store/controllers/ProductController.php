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
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use app\modules\store\models\Product;
use app\modules\store\models\Catalog;
use app\modules\store\models\search\ProductSearch;
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
        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
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
}
