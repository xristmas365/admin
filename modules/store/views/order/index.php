<?php

use yii\helpers\Html;
use app\modules\user\models\Role;
use app\modules\store\models\Order;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\store\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>


<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        [
            'attribute' => 'id',
            'format'    => 'raw',
            'value'     => function(Order $model)
            {
                return Html::a($model->id, ['view', 'id' => $model->id], ['data-pjax' => 0]);
            },
        ],
        [
            'attribute' => 'coupon_id',
            'label'     => 'Coupon',
            'value'     => 'coupon.name',
        ],
        [
            'attribute' => 'created_by',
            'value'     => 'user.name',
            'visible'   => Yii::$app->user->can(Role::ADMIN),
        ],
        'sum:currency',
        'coupon_discount:currency',
        'tax:currency',
        'total:currency',
        'created_at:dateTime',
        [
            'class'    => ActionColumn::class,
            'template' => "{delete}",
            'visible'  => Yii::$app->user->can(Role::DEVELOPER),
        ],
    ],
]); ?>

