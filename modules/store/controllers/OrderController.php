<?php

namespace app\modules\store\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use app\modules\store\models\Order;
use app\modules\store\models\OrderProduct;
use app\modules\store\models\search\OrderSearch;
use app\modules\admin\controllers\BackendController;
use app\modules\store\models\search\OrderProductSearch;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends BackendController
{
    
    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Order model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new OrderProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        
        return $this->render('view', [
            'model'        => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = Order::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = 'json';
        
        return $this->findModel($id)->delete();
    }
}
