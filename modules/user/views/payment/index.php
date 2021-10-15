<?php

use app\modules\user\models\Charge;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\store\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment History';
$this->params['breadcrumbs'][] = $this->title;
?>


<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'id',
        'stripe_id',
        [
            'attribute' => 'card_id',
            'label'     => 'Card',
            'value'     => function(Charge $model)
            {
                return '**** **** **** '.$model->card->number;
            },
        ],
        'amount:currency',
        'created_at:dateTime',
        [
            'class'    => ActionColumn::class,
            'template' => "{delete}",
        ],
    ],
]); ?>

