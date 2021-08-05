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
use app\modules\store\models\Product;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\store\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'shopping-bag'
?>

<?= Html::a('<i class="fas fa-plus"></i> Create New Product', ['create'], ['class' => 'btn btn-primary']) ?>

<?= AdminGrid::widget([
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
        AdminGrid::COLUMN_ACTION,
    ],
]) ?>
