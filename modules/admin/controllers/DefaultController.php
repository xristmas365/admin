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
use yii\helpers\ArrayHelper;
use yii\web\MethodNotAllowedHttpException;

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
    
    /**
     * Switch column Ajax action
     *
     * @return mixed
     * @throws \Exception
     */
    public function actionSwitch()
    {
        if(!Yii::$app->request->isAjax) {
            throw new MethodNotAllowedHttpException('Page Not Found');
        }
        Yii::$app->response->format = 'json';
        $data = json_decode(base64_decode(Yii::$app->request->post('data')));
        $class = ArrayHelper::getValue($data, 'c');
        $value = ArrayHelper::getValue($data, 'v');
        $key = ArrayHelper::getValue($data, 'k');
        $attribute = ArrayHelper::getValue($data, 'a');
        $model = $class::find()->where([$key => $value])->one();
        $model->{$attribute} = !$model->{$attribute};
        
        return $model->save();
    }
    
    
}
