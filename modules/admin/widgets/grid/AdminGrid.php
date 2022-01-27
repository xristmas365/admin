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
use yii\base\Model;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQueryInterface;

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
        
        parent::init();
        $this->panel['before'] = $this->renderHelpers();
        
    }
    
    public function renderHelpers()
    {
        $default = Html::tag('div', 'Filters and Sorting', ['class' => 'text-muted']);
        $filters = Html::tag('div', $this->renderFilterHelper());
        $sorting = Html::tag('div', $this->renderSortingHelper());
        if($this->renderFilterHelper() != '' || $this->renderSortingHelper() != '') {
            $clearAllBtn = Html::a('Clear All', array_merge([Yii::$app->controller->action->id], Yii::$app->controller->actionParams), ['class' => 'text-muted ml-2']);
        } else {
            $clearAllBtn = '';
        }
        $clearAllBtn = Html::tag('div', $clearAllBtn);
        $leftContainer = Html::tag('div', $default . $sorting . $filters . $clearAllBtn, ['class' => 'd-flex']);
        $rightContainer = Html::tag('div', "{import}{export}");
        
        return Html::tag('div', $leftContainer . $rightContainer, ['class' => 'd-flex justify-content-between']);
    }
    
    protected function renderFilterHelper()
    {
        $content = '';
        $queryParams = Yii::$app->request->queryParams;
        if(!$this->filterModel) {
            return $content;
        }
        $modelName = $this->filterModel->formName();
        $params = ArrayHelper::getValue($queryParams, $modelName);
        if(!$params) {
            return $content;
        }
        $result = array_filter($params, 'strlen');
        foreach($result as $attr => $value) {
            $v = $this->filterModel->getAttributeLabel($attr);
            $queryParams[$modelName][$attr] = '';
            $url = array_merge([Yii::$app->controller->action->id], $queryParams);
            $content .= Html::a('<span class="fas fa-filter"></span> ' . "$v: $value ×", $url, ['class' => 'badge badge-light ml-1']);
        }
        
        return $content;
    }
    
    protected function renderSortingHelper()
    {
        $content = '';
        $queryParams = Yii::$app->request->queryParams;
        $provider = $this->dataProvider;
        $sort = Yii::$app->request->get('sort');
        if(!$sort) {
            return $content;
        }
        $desc = str_contains($sort, '-');
        if($desc) {
            $sort = str_replace('-', '', $sort);
        }
        
        $sortName = $sort;
        $direction = $desc ? 'DESC' : 'ASC';
        
        if($provider instanceof ActiveDataProvider && $provider->query instanceof ActiveQueryInterface) {
            $modelClass = $provider->query->modelClass;
            /* @var $modelClass Model */
            $model = $modelClass::instance();
            $sortName = $model->getAttributeLabel($sort);
        }
        
        ArrayHelper::remove($queryParams, 'sort');
        
        return Html::a('<span class="fas fa-sort"></span> ' . " $sortName $direction ×", array_merge([Yii::$app->controller->action->id], $queryParams), ['class' => 'badge badge-dark ml-1']);
        
    }
    
    public function renderSection($name)
    {
        switch($name) {
            case '{import}':
                return $this->renderImport();
            case '{sizer}':
                return $this->renderSizer();
            case '{gridTitle}':
                return $this->renderGridTitle();
            default:
                return parent::renderSection($name);
        }
    }
    
    public function renderImport()
    {
        Modal::begin([
            'id'             => $this->id . '-modal-import',
            'scrollable'     => true,
            'size'           => Modal::SIZE_EXTRA_LARGE,
            'centerVertical' => true,
            'title'          => '',
        ]);
        
        echo '<div class="row" style="height: 600px">';
        echo '<div class="col-md-12">';
        
        echo FileInput::widget([
            'id'            => $this->id . '-file-input',
            'options'       => [
                'class'      => 'grid-file-input',
                'data-modal' => $this->id . '-modal-import-content',
            ],
            'name'          => 'file',
            'pluginOptions' => [
                'showPreview' => false,
                'uploadUrl'   => Url::toRoute(['/file/default/create']),
            ],
        ]);
        
        echo Html::tag('div', null, ['id' => $this->id . '-modal-import-content']);
        echo '</div>';
        echo '</div>';
        
        Modal::end();
        
        return Html::button('Import', [
            'class' => 'btn btn-outline-secondary mr-1',
            'data'  => [
                'toggle' => 'modal',
                'target' => '#' . $this->id . '-modal-import',
            ],
        ]);
        
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
