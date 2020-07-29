<?php
/**
 * DefaultController.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\user\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\modules\admin\controllers\BackendController;
use app\modules\user\models\{User, UserSearch, ChangePassword};

/**
 * UserController implements the CRUD actions for User model.
 */
class DefaultController extends BackendController
{
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
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
    public function actionUpdate($id = null)
    {
        $id = $id ?? Yii::$app->user->id;
        
        $model = $this->findModel($id);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAccount()
    {
        $model = Yii::$app->user->identity;
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goAdmin();
        }
        
        return $this->render('account', ['model' => $model]);
    }
    
    public function actionPassword()
    {
        $model = new ChangePassword;
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['account']);
        }
        
        return $this->render('password', ['model' => $model]);
        
    }
    
    /**
     * Deletes an existing User model.
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
    
    /**
     * Deactivates an existing User.
     * If deactivation is successful, the browser will be redirected to the 'index' page.
     *
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeactivate()
    {
        $this->findModel(Yii::$app->user->id)->updateAttributes(['blocked' => true]);
        
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
}
