<?php

/**
 * SiteController.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\modules\user\models\User;

class SiteController extends Controller
{
    
    /**
     * Displays Index Page.
     *
     * @return string
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }
    
    /**
     * Displays an Error page or Yii Error Handler.
     *
     * @return string
     */
    public function actionError()
    {
        $this->layout = YII_ENV_DEV ? false : '@app/modules/user/views/layouts/auth';
        $path = YII_ENV_DEV ? '@yii/views/errorHandler/exception.php' : '404';
        
        return $this->render($path, [
            'handler'   => Yii::$app->errorHandler,
            'exception' => Yii::$app->errorHandler->exception,
        ]);
    }
}
