<?php

use yii\helpers\Html;
use kartik\field\FieldRange;
use app\modules\user\models\Role;
use app\modules\warehouse\models\Warehouse;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;

/* @var $model Warehouse */
/* @var $this yii\web\View */
/* @var $searchModel WarehouseSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Warehouses';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('Create Warehouse', ['create'], ['class' => 'btn btn-primary']) ?>
</p>
<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'id',
        [
            'label'  => 'Total',
            'format' => 'currency',
            'attribute' => 'pw_total',
            'filter' => FieldRange::widget([
                'model'            => $searchModel,
                'template'         => '{widget}{error}',
                'attribute1'       => 'total_from',
                'attribute2'       => 'total_to',
                'separator'        => '-',
                'separatorOptions' => ['class' => 'py-0'],
                'type'             => FieldRange::INPUT_TEXT,
            ]),
        ],
        [
            
            'attribute' => 'user_id',
            'value'     => 'user.name',
            'visible'   => Yii::$app->user->can(Role::ADMIN),
            'label'     => 'User',
        ],
        [
            'attribute' => 'name',
            'format'    => 'raw',
            'value'     => function(Warehouse $model)
            {
                return Html::a($model->name, ['view', 'id' => $model->id], ['data-pjax' => 0]);
            },
        
        ]
        ,
        'zip',
        'city',
        'address',
        'state',
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'active',
        ],
        AdminGrid::COLUMN_ACTION,
    ],
]); ?>
<div class="text-de"></div>
