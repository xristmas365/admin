<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\LogSearch;
use app\modules\admin\widgets\grid\AdminGrid;

/**
 * @var $this         View
 * @var $searchModel  LogSearch
 * @var $dataProvider ActiveDataProvider
 *
 */

$this->title = 'Error Log';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'layers';
?>

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        'category',
        'log_time:datetime',
        [
            'attribute'      => 'message',
            'contentOptions' => [
                'class' => 'text-wrap',
            ],
            'value'          => function($model)
            {
                return ArrayHelper::getValue(explode(PHP_EOL, $model->message), 0);
            },
        ],
        [
            'class'    => 'app\modules\admin\widgets\grid\ActionColumn',
            'template' => '{view}',
        ],
    ],
]); ?>
