<?php
/**
 * index.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
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
    'filterModel'  => $searchModel,
    'createButton'  => '<span></span>',
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
            'class' => 'app\modules\admin\widgets\grid\ActionColumn',
            'template'=> '{view}'
        ],
    ],
]); ?>
