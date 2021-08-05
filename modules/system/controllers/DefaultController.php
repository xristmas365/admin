<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\system\controllers;

use yii\rest\Controller;
use app\modules\system\models\Zip;

class DefaultController extends Controller
{
    
    public function actionIndex($zip)
    {
        return Zip::find()->select(['zip', 'city', 'state'])->where(['zip' => $zip])->asArray()->one();
    }
    
    protected function verbs()
    {
        return [
            'index' => ['GET'],
        ];
    }
}
