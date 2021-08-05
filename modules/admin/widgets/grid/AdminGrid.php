<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets\grid;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

class AdminGrid extends GridView
{
    
    const COLUMN_ACTION   = ['class' => 'app\modules\admin\widgets\grid\ActionColumn'];
    const COLUMN_IMAGE    = ['class' => 'app\modules\admin\widgets\grid\ImageColumn'];
    const COLUMN_SERIAL   = ['class' => 'kartik\grid\SerialColumn'];
    const COLUMN_CHECKBOX = ['class' => 'app\modules\admin\widgets\grid\CheckboxColumn'];
    
    public $title;
    
    public $pjax             = true;
    
    public $emptyText        = '<i class="fas fa-dice"></i> Empty';
    
    public $emptyTextOptions = [
        'class' => 'text-center tx-color-03 my-3',
    ];
    
    
    public $pjaxSettings    = [
        'neverTimeout'    => true,
        'loadingCssClass' => 'grid-loading',
    ];
    
    public $bordered        = false;
    
    public $responsive      = true;
    
    public $responsiveWrap  = false;
    
    public $export          = false;
    
    public $striped         = false;
    
    public $hover           = false;
    
    public $toolbar         = false;
    
    public $condensed       = true;
    
    public $panel           = [
        'options'        => [
            'class' => 'shadow mt-3',
        ],
        'headingOptions' => [
            'class' => 'card-header',
        ],
        'before'         => false,
        'after'          => false,
    ];
    
    public $tableOptions    = [
        'class' => 'text-nowrap',
    ];
    
    public $dataColumnClass = DataColumn::class;
    
    
    public $panelHeadingTemplate = <<< HTML
<div class="d-flex justify-content-between">
     <div class="d-flex justify-content-start align-items-center">{summary}</div>
     <div class="d-flex justify-content-start align-items-center">{gridTitle}</div>
     {sizer}
</div>
HTML;
    
    public $panelFooterTemplate  = <<< HTML
<div class="d-flex justify-content-center">
     <div class="d-flex justify-content-start align-items-center">{pager}</div>
</div>
HTML;
    
    public $pager                = [
        'options'        => [
            'class' => 'pagination pagination-sm pagination-space mt-1 mb-1',
        ],
        'pageCssClass'   => 'page-item',
        'maxButtonCount' => 5,
    ];
    
    public function init()
    {
        if($this->dataProvider->getTotalCount() === 0) {
            $this->showHeader = false;
        }
        
        return parent::init();
    }
    
    public function renderSection($name)
    {
        switch($name) {
            case '{sizer}':
                return $this->renderSizer();
            case '{gridTitle}':
                return $this->renderGridTitle();
            default:
                return parent::renderSection($name);
        }
    }
    
    public function renderSizer()
    {
        if($this->dataProvider->getTotalCount() === 0) {
            return '<div></div>';
        }
        $value = Yii::$app->session->get('page-size', 20);
        
        $items = [
            1   => 1,
            5   => 5,
            10  => 10,
            20  => 20,
            50  => 50,
            100 => 100,
            200 => 200,
            500 => 500,
        ];
        
        $sizer = Html::dropDownList('grid-sizer', $value, $items, [
            'class'     => 'form-control form-control-sm page-sizer',
            'data-url'  => Url::toRoute(['/admin/default/page-size']),
            'data-pjax' => $this->pjaxSettings['options']['id'],
        ]);
        
        return '<div class="d-flex justify-content-end align-items-center"><span class="text-nowrap mr-2">Items:</span>' . $sizer . '</div>';
        
    }
    
    public function renderGridTitle()
    {
        $title = $this->title ?? Html::encode($this->view->title);
        
        return Html::tag('div', $title, ['class' => 'text-uppercase font-weight-bold', 'style' => 'color:#596882']);
    }
}
