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
use kartik\form\ActiveForm;
use app\modules\user\components\AuthHandler;
use yii\web\{Response, Controller, NotFoundHttpException};
use app\modules\user\models\{User, Login, Reset, Password, Register};

class AuthController extends Controller
{
    
    public $layout = 'auth';
    
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
            $url = Yii::$app->session->get('__returnUrl', ['/admin/default/index']);
            
            if(Yii::$app->session->has('__returnUrl')) {
                Yii::$app->session->remove('__returnUrl');
            }
            
            return $this->redirect($url);
        }
        
        return $this->render('login', ['model' => $model]);
    }
    
    /**
     * @return array|string|Response
     */
    public function actionRegister()
    {
        if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new Register;
        
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            
            return ActiveForm::validate($model);
        }
        
        if($model->load(Yii::$app->request->post()) && $model->up()) {
            return $this->render('register-verify', ['model' => $model]);
        }
        
        return $this->render('register', ['model' => $model]);
    }
    
    public function actionVerify($auth)
    {
        $user = User::findOne(['auth_key' => $auth]);
        
        if(!$user) {
            throw new NotFoundHttpException('Auth Token is Invalid');
        }
        
        $user->updateAttributes([
            'confirmed' => true,
            'auth_key'  => Yii::$app->security->generateRandomString(),
        ]);
        
        return $this->render('register-complete');
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
        if(!User::findOne(['auth_key' => $auth])) {
            throw new NotFoundHttpException('Page Not Found');
        }
        
        $model = new Password(['auth' => $auth]);
        
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('password-complete');
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
