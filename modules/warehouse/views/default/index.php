<?php

use yii\helpers\Html;
use app\modules\user\models\Role;
use app\modules\warehouse\models\Warehouse;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\search\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Warehouses';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('Create Warehouse', ['create'], ['class' => 'btn btn-primary']) ?>
</p>
<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'id',
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


