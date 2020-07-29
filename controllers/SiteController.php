<?php
/**
 * SiteController.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\modules\page\models\Page;

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
     * Displays Privacy Page.
     *
     * @return string
     */
    public function actionPrivacy()
    {
        return $this->render('privacy');
    }
    
    /**
     * Displays Terms and Conditions Page.
     *
     * @return string
     */
    public function actionTerms()
    {
        $page = Page::findOne(1);
        
        return $this->render('terms', ['page'=> $page]);
    }
    
    /**
     * Displays an Error page or Yii Error Handler.
     *
     * @return string
     */
    public function actionError()
    {
        $this->layout = YII_ENV_DEV ? false : 'main';
        $path = YII_ENV_DEV ? '@yii/views/errorHandler/exception.php' : '404';
        
        return $this->render($path, [
            'handler'   => Yii::$app->errorHandler,
            'exception' => Yii::$app->errorHandler->exception,
        ]);
    }
}
