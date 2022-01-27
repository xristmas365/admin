<?php

namespace app\modules\file\components;

use Yii;
use yii\base\Component;
use yii\db\ActiveRecord;
use app\modules\file\models\File;
use League\Flysystem\FileNotFoundException;

/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */
class CsvParser extends Component
{
    
    protected $file;
    
    public function preview($rows = 10) : array
    {
        $content = [];
        $row = 1;
        if(($handle = fopen($this->file->src, "r")) !== false) {
            while(($data = fgetcsv($handle, 1000, ',')) !== false) {
                if($row === $rows) {
                    break;
                }
                $content[] = $data;
                ++$row;
            }
            fclose($handle);
        }
        
        $headers = array_shift($content);
        
        /**
         * @var ActiveRecord $model
         */
        $model = Yii::createObject($this->file->model);
        
        return ['content' => $content, 'headers' => $headers, 'attributes' => $model->fillable(), 'file' => $this->file->id];
    }
    
    public function loadFile(File $model)
    {
        if(!file_exists($model->src)) {
            throw new FileNotFoundException('File Not Uploaded');
        }
        $this->file = $model;
        
    }
}
