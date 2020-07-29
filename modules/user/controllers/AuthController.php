<?php
/**
 * AuthController.php
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
use yii\web\Response;
use yii\web\Controller;
use app\modules\user\models\Login;
use app\modules\user\models\Reset;
use app\modules\user\form\ResetForm;
use app\modules\user\models\Password;
use app\modules\user\components\AuthHandler;

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
        if(Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        return $this->render('register');
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
    
}
