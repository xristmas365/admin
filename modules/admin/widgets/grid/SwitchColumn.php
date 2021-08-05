<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets\grid;

use yii\helpers\Html;
use yii\helpers\Json;

class SwitchColumn extends \kartik\grid\BooleanColumn
{
    
    public $key      = 'id';
    
    public $readonly = false;
    
    /**
     * @inheritdoc
     */
    public function getDataCellValue($model, $key, $index)
    {
        if($this->readonly) {
            return parent::getDataCellValue($model, $key, $index);
        }
        $id = 'switch_' . strtolower($model->formName()) . '_' . $this->attribute . '_' . $model->id;
        
        $input = Html::checkbox(null, $model->{$this->attribute}, [
            'class'  => 'custom-control-input grid-switch-control',
            'id'     => $id,
            'data-s' => base64_encode(Json::encode([
                'c' => $model::className(),
                'v' => $model->{$this->key} ?? false,
                'k' => $this->key,
                'a' => $this->attribute,
            ])),
        ]);
        
        $label = Html::label(null, $id, ['class' => 'custom-control-label']);
        
        return Html::tag('div', $input . $label, ['class' => 'custom-control custom-switch mt-1 text-center']);
    }
}
