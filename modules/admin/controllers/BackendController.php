<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\controllers;

use Yii;
use yii\web\{Response, Controller};

class BackendController extends Controller
{
    
    public $layout = '@app/modules/admin/views/layouts/main';
    
    
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
