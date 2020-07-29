<?php
/**
 * index.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use kartik\tree\TreeView;
use app\modules\store\models\Catalog;

/* @var $this yii\web\View */

$this->title = 'Catalogs';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'server'
?>
<div class="row">
    <div class="col-md-12">
        <?= TreeView::widget([
            'query'                => Catalog::find()->addOrderBy('root, lft'),
            'headingOptions'       => ['label' => 'Store'],
            'rootOptions'          => ['label' => '<span class="text-primary">' . Yii::$app->name . '</span>'],
            'topRootAsHeading'     => true,
            'fontAwesome'          => true,
            'softDelete'           => false,
            'emptyNodeMsg'         => 'Click Create or Select to Update',
            'showIDAttribute'      => false,
            'cacheSettings'        => ['enableCache' => true],
            'childNodeIconOptions' => ['class' => 'text-primary'],
            'parentNodeIconOptions' => ['class' => 'text-secondary'],
            'mainTemplate'         => <<< HTML
<div class="row">
    <div class="col-sm-12">
        {wrapper}
    </div>
    <div class="col-sm-12 mt-2">
        {detail}
    </div>
</div>
HTML
            ,
            'headerTemplate'       => <<< HTML
<div class="row">
    <div class="col-sm-8 pt-1 pl-4">
        {toolbar}
    </div>
    <div class="col-sm-4">
        {search}
    </div>
</div>
HTML,
            'wrapperTemplate'      => "{header}\n{tree}",
            'headerOptions'        => [
                'class' => 'bg-light',
            ],
            'toolbar'              => [
                TreeView::BTN_CREATE_ROOT => [
                    'label'   => 'Create',
                    'icon'    => 'server',
                    'options' => ['title' => 'Create Top Level Catalog', 'class' => 'btn btn-white'],
                ],
                TreeView::BTN_SEPARATOR,
                TreeView::BTN_CREATE      => [
                    'label'          => 'Append',
                    'icon'           => 'plus',
                    'alwaysDisabled' => false, // set this property to `true` to force disable the button always
                    'options'        => ['title' => 'Append New Catalog', 'disabled' => true, 'class' => 'btn btn-white'],
                ],
                TreeView::BTN_REMOVE      => [
                    'label'   => 'Delete',
                    'icon'    => 'trash',
                    'options' => ['title' => 'Delete', 'disabled' => true, 'class' => 'btn btn-white'],
                ],
                TreeView::BTN_MOVE_UP     => false,
                TreeView::BTN_MOVE_DOWN   => false,
                TreeView::BTN_MOVE_LEFT   => false,
                TreeView::BTN_MOVE_RIGHT  => false,
                TreeView::BTN_REFRESH     => false,
            ],
            'toolbarOrder'         => [
                TreeView::BTN_CREATE_ROOT,
                TreeView::BTN_SEPARATOR,
                TreeView::BTN_CREATE,
                TreeView::BTN_REMOVE,
            ],
        ]) ?>
    </div>
</div>



