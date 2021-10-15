<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\modules\user\models\Role;
use app\modules\store\models\Order;
use app\modules\admin\widgets\CardWidget;
use app\modules\store\models\OrderProduct;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/**
 * @var $model        Order
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Order #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= CardWidget::widget([
    'items' => [
        [
            [
                'label'     => 'Order Price',
                'value'     => Yii::$app->formatter->asCurrency($model->sum),
                'percent'   => Yii::$app->formatter->asPercent($model->sum / $model->total),
                'percentOf' => 'of Total Order Amount',
            ],
            [
                'label'     => 'Order Discount',
                'value'     => Yii::$app->formatter->asCurrency($model->coupon_discount),
                'percent'   => Yii::$app->formatter->asPercent($model->coupon_discount / $model->total),
                'percentOf' => 'of Total Order Amount',
            ],
            [
                'label'     => 'Order Sale Taxes',
                'value'     => Yii::$app->formatter->asCurrency($model->tax),
                'percent'   => Yii::$app->formatter->asPercent($model->tax / $model->total),
                'percentOf' => 'of Total Order Amount',
            ],
            [
                'label' => 'Total Order Amount',
                'value' => Yii::$app->formatter->asCurrency($model->total),
            ],
        ],
    ],
]) ?>

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        AdminGrid::COLUMN_SERIAL,
        [
            'attribute' => 'product_id',
            'format'    => 'raw',
            'value'     => function(OrderProduct $model)
            {
                return Html::a($model->product->title, ['/store/front/product', 'slug' => $model->product->slug], ['data-pjax' => 0, 'target' => '_blank']);
            },
        ],
        'price:currency',
        'coupon_discount:currency',
        'tax:currency',
        'quantity',
        'sum:currency',
        [
            'class'    => ActionColumn::class,
            'template' => "{delete}",
            'visible'  => Yii::$app->user->can(Role::DEVELOPER),
        ],
    ],
]); ?>
