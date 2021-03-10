<?php
/**
 * AuthController.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\user\controllers;

use Yii;
use yii\web\{Response, Controller};
use app\modules\user\components\AuthHandler;
use app\modules\user\models\{User, Login, Reset, Password, Register};

class AuthController extends Controller
{
    
    public function actions()
    {
        return [
            'client' => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
    
    public function onAuthSuccess($client)
    {
        $login = new AuthHandler($client);
        if($login->handle()) {
            return $this->redirect(['/admin/dashboard/index']);
        }
    }
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new Login;
        
        if($model->load(Yii::$app->request->post()) && $model->in()) {
            return $this->redirect(['/admin/default/index']);
        }
        
        return $this->render('login', ['model' => $model]);
    }
    
    /**
     * Register action.
     *
     * @return Response|string
     */
    public function actionRegister()
    {
        if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new Register;
        
        if($model->load(Yii::$app->request->post()) && $model->up()) {
            return $this->redirect(['/admin/default/index']);
        }
        
        return $this->render('register', ['model' => $model]);
    }
    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() : Response
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
    
    public function actionReset()
    {
        $model = new Reset;
        
        if($model->load(Yii::$app->request->post()) && $model->reset()) {
            return $this->render('reset-complete', ['model' => $model]);
        }
        
        return $this->render('reset', ['model' => $model]);
    }
    
    
    public function actionPassword($auth)
    {
        $model = new Password(['auth' => $auth]);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goHome();
        }
        
        return $this->render('password', ['model' => $model]);
    }
    
    public function actionSwitch($id)
    {
        $currentUser = Yii::$app->user->identity;
        $user = User::findOne($id);
        if($user) {
            Yii::$app->user->switchIdentity($user);
            
            Yii::$app->session->set('admin_id', $currentUser->id);
            Yii::$app->session->set('admin_name', $currentUser->name);
            
            Yii::$app->session->setFlash('success', 'Welcome to ' . $user->name . ' Dashboard');
            
            return $this->redirect(['/admin/default/index']);
        }
        
    }
    
    public function actionSwitchBack($id)
    {
        $user = User::findOne($id);
        if($user) {
            Yii::$app->session->remove('admin_id');
            Yii::$app->session->remove('admin_name');
            
            Yii::$app->user->switchIdentity($user);
            
            Yii::$app->session->setFlash('success', 'Welcome back to ' . $user->name . ' Dashboard');
            
            return $this->redirect(['/user/default/index']);
        }
    }
    
}
