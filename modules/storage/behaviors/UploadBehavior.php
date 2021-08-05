<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\storage\behaviors;

use Yii;
use yii\db\ActiveRecord;

class UploadBehavior extends \trntv\filekit\behaviors\UploadBehavior
{
    
    public $customKey;
    
    public $attribute  = 'files';
    
    public $thumbnails = false;
    
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
                $this->safeThumbnail($model);
            }
        }
        
    }
    
    protected function safeThumbnail($imageModel)
    {
        $modelClass = $this->getUploadModelClass();
        
        $model = new $modelClass;
        $model->setScenario($this->uploadModelScenario);
        $imageModel->id = null;
        $model->attributes = $imageModel->attributes;
        $thumbnail = $this->makeThumbnail($imageModel->path);
        if($thumbnail) {
            $model->path = $thumbnail;
            $model->model_name = $model->model_name . 'T';
            $model->save();
        }
        
    }
    
    protected function makeThumbnail($path)
    {
        $dir = Yii::getAlias('@app/web/upload/');
        
        $filename = $dir . $path;
        $percent = 0.1;
        
        // Get new dimensions
        [$width, $height] = getimagesize($filename);
        $new_width = $width * $percent;
        $new_height = $height * $percent;
        
        // Resample
        $image_p = imagecreatetruecolor($new_width, $new_height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        $pathArr = explode('.', $path);
        $pathArr[0] = $pathArr[0] . '-t';
        $pathResult = implode('.', $pathArr);
        
        if(imagejpeg($image_p, $dir . $pathResult, 100)) {
            return $pathResult;
        }
        
        return false;
        
    }
}
