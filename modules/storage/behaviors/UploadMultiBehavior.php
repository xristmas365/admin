<?php
/**
 * UploadMultiBehavior.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\storage\behaviors;

use yii\db\ActiveRecord;

class UploadMultiBehavior extends \trntv\filekit\behaviors\UploadBehavior
{
    
    public $customKey;
    
    /**
     * @return array
     */
    public function events()
    {
        $multipleEvents = [
            ActiveRecord::EVENT_AFTER_INSERT  => 'afterInsertMultiple',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'afterUpdateMultiple',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDeleteMultiple',
            ActiveRecord::EVENT_AFTER_DELETE  => 'afterDelete',
        ];
        
        $singleEvents = [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidateSingle',
            ActiveRecord::EVENT_BEFORE_UPDATE  => 'beforeUpdateSingle',
            ActiveRecord::EVENT_AFTER_UPDATE   => 'afterUpdateSingle',
            ActiveRecord::EVENT_BEFORE_DELETE  => 'beforeDeleteSingle',
            ActiveRecord::EVENT_AFTER_DELETE   => 'afterDelete',
        ];
        
        return $this->multiple ? $multipleEvents : $singleEvents;
    }
    
    /**
     * @param array $files
     *
     * @throws \yii\base\InvalidConfigException
     */
    protected function saveFilesToRelation($files)
    {
        $modelClass = $this->getUploadModelClass();
        
        if(isset($files['path'])) {
            $model = new $modelClass;
            $model->setScenario($this->uploadModelScenario);
            $model = $this->loadModel($model, $files);
            $model->model_name = $this->customKey ?? $this->owner->formName();
            
            if($this->getUploadRelation()->via !== null) {
                $model->save(false);
            }
            $this->owner->link($this->uploadRelation, $model);
        } else {
            foreach($files as $file) {
                $model = new $modelClass;
                $model->setScenario($this->uploadModelScenario);
                $model = $this->loadModel($model, $file);
                $model->model_name = $this->customKey ?? $this->owner->formName();
                
                if($this->getUploadRelation()->via !== null) {
                    $model->save(false);
                }
                $this->owner->link($this->uploadRelation, $model);
            }
        }
        
    }
}
