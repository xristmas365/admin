<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
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
    
    const COLUMN_ACTION = ['class' => 'app\modules\admin\widgets\grid\ActionColumn'];
    const COLUMN_IMAGE  = ['class' => 'app\modules\admin\widgets\grid\ImageColumn'];
    const COLUMN_SERIAL = ['class' => 'kartik\grid\SerialColumn'];
    
    public $title;
    
    public $leftButtons      = [
        [
            'url'   => ['create'],
            'label' => '<div class="fas fa-plus"></div> New',
        ],
    ];
    
    public $rightButtons     = [
        [
            'url'   => ['index'],
            'label' => '<i class="fas fa-filter"></i> Clear Filters',
        ],
    ];
    
    public $extraSearch;
    
    public $pjax             = true;
    
    public $emptyText        = '<i class="fas fa-dice"></i> Empty';
    
    public $emptyTextOptions = [
        'class' => 'text-uppercase text-center font-weight-bold mt-3 mb-3',
        'style' => 'color:#596882',
    ];
    
    
    public $pjaxSettings         = [
        'neverTimeout'    => true,
        'loadingCssClass' => 'grid-loading',
    ];
    
    public $bordered             = false;
    
    public $export               = false;
    
    public $striped              = false;
    
    public $hover                = true;
    
    public $toolbar              = false;
    
    public $panel                = [
        'options'        => [
            'class' => 'shadow',
        ],
        'headingOptions' => [
            'class' => 'card-header',
        ],
        'before'         => false,
        'after'          => false,
    ];
    
    public $tableOptions         = [
        'class' => 'text-nowrap table-sm',
    ];
    
    public $dataColumnClass      = DataColumn::class;
    
    public $resizableColumns     = false;
    
    public $panelHeadingTemplate = <<< HTML
<div class="position-relative text-center">
     <div class="grid-left-buttons">
        {leftButtons}
     </div>
     <div class="grid-title">
     {gridTitle}
     </div>
     <div class="grid-right-buttons">
        {rightButtons}
    </div>
</div>
HTML;
    
    public $panelFooterTemplate  = <<< HTML
<div class="d-flex justify-content-between">
     <div class="d-flex justify-content-start align-items-center">{summary}</div>
     <div class="d-flex justify-content-start align-items-center">{pager}</div>
    <div class="d-flex justify-content-end align-items-center"><span class="text-nowrap mr-2">Page size:</span>{sizer}</div>
</div>
HTML;
    
    public $pager                = [
        'options'        => [
            'class' => 'pagination pagination-space my-0',
        ],
        'pageCssClass'   => 'page-item',
        'maxButtonCount' => 5,
    ];
    
    public function init()
    {
        parent::init();
        $this->extraSearch = $this->extraSearch ?? $this->view->render('@app/modules/admin/widgets/grid/_search', ['model' => $this->filterModel]);
        $this->rowOptions = function($model, $key, $index, $grid)
        {
            return ['id' => $model['id'], 'ondblclick' => 'location.href="' . Url::toRoute(['update', 'id' => $model->id]) . '"'];
        };
    }
    
    public function renderSection($name)
    {
        switch($name) {
            case '{sizer}':
                return $this->renderSizer();
            case '{gridTitle}':
                return $this->renderGridTitle();
            case '{extraSearch}':
                return $this->renderExtraSearch();
            case '{leftButtons}':
                return $this->renderLeftButtons();
            case '{rightButtons}':
                return $this->renderRightButtons();
            default:
                return parent::renderSection($name);
        }
    }
    
    public function renderSizer()
    {
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
        
        return Html::dropDownList('grid-sizer', $value, $items, [
            'class'     => 'form-control form-control-sm page-sizer',
            'data-url'  => Url::toRoute(['/admin/default/page-size']),
            'data-pjax' => $this->pjaxSettings['options']['id'],
        ]);
    }
    
    public function renderGridTitle()
    {
        $title = $this->title ?? Html::encode($this->view->title);
        
        return Html::tag('div', $title, ['class' => 'text-uppercase font-weight-bold', 'style' => 'color:#596882']);
    }
    
    public function renderExtraSearch()
    {
        return $this->extraSearch;
    }
    
    public function renderLeftButtons()
    {
        $html = Html::button('<i class="fas fa-trash-alt"></i> Delete <span id="' . $this->id . '-selected-counter"></span>', [
            'id'        => $this->id . '-delete-btn',
            'class'     => 'btn btn-sm btn-danger grid-delete-btn mr-1',
            'style'     => 'display:none',
            'data-grid' => $this->id,
            'data-url'  => Url::toRoute(['delete']),
        ]);
        foreach($this->leftButtons as $leftButton) {
            $html .= Html::a($leftButton['label'], $leftButton['url'], ['class' => 'btn btn-sm btn-white mr-1', 'data-pjax' => 0]);
        }
        
        return $html;
    }
    
    public function renderRightButtons()
    {
        $html = '';
        foreach($this->rightButtons as $rightButton) {
            $html .= Html::a($rightButton['label'], $rightButton['url'], ['class' => 'btn btn-sm btn-white']);
        }
        
        return $html;
    }
    
}
