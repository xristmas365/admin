<?php
/**
 * DefaultController.php
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
use yii\helpers\Json;
use yii\base\DynamicModel;
use yii\helpers\FileHelper;
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
    
    public function actionSettings()
    {
        $file = Yii::getAlias('@app/config/settings.json');
        $content = Json::decode(file_get_contents($file));
        
        $settings = new DynamicModel($content);
        $settings->addRule(array_keys($content), 'safe');
        
        if($settings->load(Yii::$app->request->post())) {
            file_put_contents($file, Json::encode($settings->attributes, JSON_PRETTY_PRINT));
            Yii::$app->session->setFlash('success', 'Settings Saved');
        }
        
        return $this->render('settings', ['settings' => $settings]);
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
