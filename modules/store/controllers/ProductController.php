<?php
/**
 * ProductController.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\store\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\modules\store\models\Product;
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
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('form', ['model' => $model]);
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
        
        if(!$model) {
            return $this->redirect(['index']);
        }
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('form', ['model' => $model]);
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
            $product->delete();
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
