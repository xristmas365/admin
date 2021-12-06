<?php

namespace app\modules\warehouse\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Role;
use yii\web\NotFoundHttpException;
use app\modules\warehouse\models\Warehouse;
use app\modules\admin\controllers\BackendController;
use app\modules\warehouse\models\search\ProductSearch;
use app\modules\warehouse\models\search\WarehouseSearch;

/**
 * DefaultController implements the CRUD actions for Warehouse model.
 */
class DefaultController extends BackendController
{
    
    
    /**
     * Lists all Warehouse models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new WarehouseSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Warehouse model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $searchModel = new ProductSearch;
        $dataProvider = $searchModel->search($model->id, Yii::$app->request->queryParams);
        
        return $this->render('view', [
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        
        ]);
    }
    
    /**
     * Finds the Warehouse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Warehouse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = Warehouse::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * Creates a new Warehouse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Warehouse();
        
        if(!Yii::$app->user->can(Role::ADMIN)) {
            $model->user_id = Yii::$app->user->id;
        }
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('form', [
            'model'    => $model,
            'userList' => User::getUserList([Role::USER, Role::CUSTOMER]),
        ]);
    }
    
    /**
     * Updates an existing Warehouse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        
        return $this->render('form', [
            'model'    => $model,
            'userList' => User::getUserList([Role::USER, Role::CUSTOMER]),
        ]);
    }
    
    /**
     * Deletes an existing Warehouse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }
}
