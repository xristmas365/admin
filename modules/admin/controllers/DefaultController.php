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

namespace app\modules\admin\controllers;

use Yii;

class DefaultController extends BackendController
{
    
    /**
     * Administration index page
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    /**
     * Administration index page size
     */
    public function actionPageSize($size)
    {
        Yii::$app->session->set('page-size', $size);
    }
    
    
}
