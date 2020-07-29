<?php
/**
 * AdminGrid.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\admin\widgets\grid;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

class AdminGrid extends GridView
{
    
    const COLUMN_ACTION   = ['class' => 'app\modules\admin\widgets\grid\ActionColumn'];
    const COLUMN_CHECKBOX = ['class' => 'kartik\grid\CheckboxColumn'];
    const COLUMN_SERIAL   = ['class' => 'kartik\grid\SerialColumn'];
    const COLUMN_BOOL     = ['class' => 'app\modules\admin\widgets\grid\BooleanColumn'];
    
    public $title;
    
    public $createButton;
    
    public $extraSearch;
    
    public $pjax                 = true;
    
    public $pjaxSettings         = [
        'neverTimeout'    => true,
        'loadingCssClass' => false,
    ];
    
    public $bordered             = false;
    
    public $export               = false;
    
    public $striped              = false;
    
    public $hover                = true;
    
    public $toolbar              = false;
    
    public $panel                = [
        'before' => false,
        'after'  => false,
    ];
    
    public $tableOptions         = [
        'class' => 'text-nowrap table-sm',
    ];
    
    public $dataColumnClass      = DataColumn::class;
    
    public $resizableColumns     = false;
    
    public $panelHeadingTemplate = <<< HTML
<div class="d-flex justify-content-between align-items-center">
     {createButton}{gridTitle}{extraSearch}
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
            case '{createButton}':
                return $this->renderCreateButton();
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
        $title = $this->title ?? $this->view->title;
        
        return Html::tag('div', Html::encode($title), ['class' => 'text-heading']);
    }
    
    public function renderExtraSearch()
    {
        return $this->extraSearch;
    }
    
    public function renderCreateButton()
    {
        return $this->createButton ?? Html::a('<div class="fas fa-plus"></div> New', ['create'], ['class' => 'btn btn-white', 'data-pjax' => 0]);
    }
    
}
