<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets\grid;

use yii\helpers\Html;
use yii\base\InvalidConfigException;

class ImageColumn extends \kartik\grid\DataColumn
{
    
    public $imageAttribute = 'image';
    
    public $format         = 'raw';
    
    public $filter         = false;
    
    public $header         = false;
    
    public $imageWidth     = '40px';
    
    public $width          = '45px';
    
    public $mergeHeader    = true;
    
    public function getDataCellValue($model, $key, $index)
    {
        if(!$model->hasProperty($this->imageAttribute)) {
            throw new InvalidConfigException('Please, define ' . $this->imageAttribute . ' property in ' . $model->formName() . ' Model');
        }
        
        return Html::img($model->{$this->imageAttribute}, ['width' => 'auto', 'height'=> '20px']);
    }
}
