<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\user\controllers;

use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\modules\admin\controllers\BackendController;
use app\modules\user\models\{User, ChangePassword, search\UserSearch};

/**
 * UserController implements the CRUD actions for User model.
 */
class DefaultController extends BackendController
{
    
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User;
        $model->confirmed = true;
        
        if($model->load(Yii::$app->request->post())) {
            $model->save();
            
            return $this->redirect(['index']);
        }
        
        return $this->render('form', ['model' => $model]);
    }
    
    /**
     * Updates an existing User model.
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
            Yii::$app->session->setFlash('success', "User <strong>{$model->name}</strong> Saved Successfully");
            
            return $this->redirect(['index']);
        }
        
        return $this->render('form', ['model' => $model]);
    }
    
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(($model = User::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /**
     * Form for Current User
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAccount()
    {
        $model = $this->findModel(Yii::$app->user->id);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Account Successfully Saved ');
            
            return $this->redirect(['/admin/default/index']);
        }
        
        return $this->render('account', ['model' => $model]);
    }
    
    /**
     * Changes Password for Current User
     *
     * @param null $id
     *
     * @return string|Response
     */
    public function actionPassword($id = null)
    {
        $id = $id ?? Yii::$app->user->id;
        
        $user = User::findOne($id);
        
        $model = new ChangePassword(['user' => $user]);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Password Successfully Changed');
            
            return $this->redirect(['/admin/default/index']);
        }
        
        return $this->render('password', ['model' => $model]);
        
    }
    
    /**
     * Changes password for Given User (access only for Admin Role)
     *
     * @param $id
     *
     * @return string|Response
     */
    public function actionNewPassword($id)
    {
        $user = User::findOne($id);
        
        $model = new ChangePassword(['user' => $user]);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $user->id]);
        }
        
        return $this->render('new-password', ['model' => $model]);
        
    }
    
    /**
     * Deletes User by given ID
     *
     * @param $id
     *
     * @return bool|false|int
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        return $this->findModel($id)->delete();
    }
    
    public function actionAllUsers($q = null, $id = null)
    {
        Yii::$app->response->format = 'json';
        
        $out = ['results' => ['id' => '', 'text' => '']];
        if(!is_null($q)) {
            $users = User::find()->select(['id', 'name as text'])->where(['ilike', 'name', $q])->limit(10)->asArray()->all();
            $out['results'] = $users;
        }
        
        return $out;
    }
}
