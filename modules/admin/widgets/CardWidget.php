<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class CardWidget extends Widget
{
    
    public $items       = [];
    
    public $columnClass = 'col-3';
    
    public function run()
    {
        parent::run();
        echo $this->renderItems();
    }
    
    public function renderItems()
    {
        $html = '';
        foreach($this->items as $rows) {
            $html .= Html::tag('div', $this->renderRow($rows), ['class' => 'row mb-4']);
        }
        
        return $html;
    }
    
    public function renderRow($items)
    {
        $html = '';
        foreach($items as $item) {
            $html .= Html::tag('div', $this->renderCard($item), ['class' => $this->columnClass]);
        }
        
        return $html;
    }
    
    public function renderCard($item)
    {
        $header = Html::tag('h6', $item['label'], ['class' => 'tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold mg-b-8']);
        $title = Html::tag('h3', $item['value'], ['class' => 'tx-normal tx-rubik mg-b-0 mg-r-5 lh-1']);
        if(isset($item['percent'])) {
            $span = Html::tag('span', $item['percent'], ['class' => 'tx-medium tx-success']);
            $title .= Html::tag('p', $span . ' ' . $item['percentOf'], ['class' => 'tx-11 tx-color-03 mg-b-0']);
        }
        $body = Html::tag('div', $title, ['class' => 'd-flex d-lg-block d-xl-flex align-items-end']);
        
        return Html::tag('div', $header . $body, ['class' => 'card card-body']);
    }
}

?>



