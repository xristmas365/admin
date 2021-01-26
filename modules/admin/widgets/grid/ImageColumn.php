<?php
/**
 * ImageColumn.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
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
    
    public $imageWidth     = '30px';
    
    public $width          = '35px';
    
    public function getDataCellValue($model, $key, $index)
    {
        if(!$model->hasProperty($this->imageAttribute)) {
            throw new InvalidConfigException('Please, define ' . $this->imageAttribute . ' property in ' . $model->formName() . ' Model');
        }
        
        return Html::img($model->{$this->imageAttribute}, ['width' => $this->imageWidth]);
    }
}
