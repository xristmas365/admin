<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use yii\helpers\Html;
use richardfan\widget\JSRegister;
use app\modules\store\models\Product;
use kartik\bs4dropdown\ButtonDropdown;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\store\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $warehouseList array */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'shopping-bag';

$items = [];
foreach($warehouseList as $warehouse) {
    $items[] = [
        'label'       => $warehouse['name'],
        'linkOptions' => [
            'class'   => 'product-receive-action',
            'data-id' => $warehouse['id'],
        ],
        'url'         => ['#'],
        'disabled'    => !$warehouse['active'],
    ];
}
?>

<?= Html::beginForm(['receive'], 'POST', ['id' => 'receive-form']) ?>
<?= Html::hiddenInput('warehouse_id', null, ['id' => 'warehouse_id']) ?>
<?= Html::hiddenInput('products_ids', null, ['id' => 'products_ids']) ?>
<?= Html::endForm() ?>

<?= Html::a('<i class="fas fa-plus"></i> Create New Product', ['create'], ['class' => 'btn btn-primary']) ?>

<?= ButtonDropdown::widget([
    'label'         => 'Receive Products',
    'dropdown'      => [
        'items' => $items,
    
    ],
    'buttonOptions' => ['class' => 'btn-primary ml-2'],
]);
?>

<?= AdminGrid::widget([
    'id'           => 'products',
    'dataProvider' => $dataProvider,
    'emptyText'    => '<i data-feather="shopping-bag"></i><hr>' . Html::a('Create', ['create'], ['data-pjax' => 0]) . ' Your First Product',
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        [
            'attribute' => 'title',
            'width'     => '35%',
        ],
        [
            'attribute' => 'catalog_id',
            'value'     => 'catalog.name',
        ],
        //[
        //    'label'  => 'Warehouse',
        //    'format' => 'raw',
        //    'value'  => function($model)
        //    {
        //        $names = [];
        //
        //        foreach($model->warehouses as $warehouse) {
        //            $names[] = '<span class="badge badge-secondary">' . $warehouse->name . '</span>';
        //        }
        //
        //        return implode('<span class="ml-1"></span>', $names);
        //    },
        //],
        [
            'attribute' => 'slug',
            'label'     => 'Link',
            'format'    => 'raw',
            'value'     => function(Product $model)
            {
                $link = Url::toRoute(['/store/front/index', 'slug' => $model->slug], true);
                
                return Html::a('<i class="fas fa-external-link-alt"></i>&nbsp' . $link, $link, ['data-pjax' => 0, 'target' => '_blank']);
            },
        ],
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'active',
        ],
        
        'price:currency',
        'quantity',
        AdminGrid::COLUMN_ACTION,
    ],
]) ?>

<?php JSRegister::begin() ?>
<script>
$(document).on('click', '.product-receive-action', function (e) {
  e.preventDefault()
  const id = $(this).data('id')
  const products = $('#products').yiiGridView('getSelectedRows')
  if (products.length === 0) {
    krajeeDialog.alert('ghghg')
  } else {
    $('#warehouse_id').val(id)
    $('#products_ids').val(products.join(','))
    $('#receive-form').submit()
  }
})
</script>
<?php JSRegister::end() ?>
