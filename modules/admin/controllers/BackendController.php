<?php
/**
 * BackendController.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\web\{Response, Controller};

class BackendController extends Controller
{
    
    public $layout = '@app/modules/admin/views/layouts/main';
    
    public function init()
    {
        parent::init();
        Yii::$app->assetManager->bundles['yii\bootstrap4\BootstrapAsset'] = ['css' => ['css/bootstrap.min.css']];
        
    }
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                
                ],
            ],
        ];
    }
    
    /**
     * @return Response
     */
    public function goAdmin()
    {
        return $this->redirect(['/admin/default/index']);
    }
    
}
