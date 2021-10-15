<?php

use yii\helpers\Html;
use app\modules\user\models\Role;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\store\models\CouponSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coupons';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Html::a('<i class="fas fa-plus"></i> Create New Coupon', ['create'], ['class' => 'btn btn-primary']) ?>


<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        'name',
        'value',
        [
            'attribute' => 'created_by',
            'value'     => 'user.name',
            'visible'   => Yii::$app->user->can(Role::DEVELOPER),
        ],
        'start_date:date',
        'end_date:date',
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'active',
        ],
        
        AdminGrid::COLUMN_ACTION,
    ],
]); ?>

