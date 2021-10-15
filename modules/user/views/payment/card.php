<?php

use app\modules\user\models\Card;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\store\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment Cards';
$this->params['breadcrumbs'][] = $this->title;
?>


<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        [
            'attribute' => 'number',
            'value'     => function(Card $model)
            {
                return '**** **** **** ' . $model->number;
            },
        ],
        'source',
        'brand',
        'country',
        
        [
            'class'    => ActionColumn::class,
            'template' => "{delete}",
        ],
    ],
]); ?>

