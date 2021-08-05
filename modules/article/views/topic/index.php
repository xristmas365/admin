<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Topic;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;
use app\modules\article\models\search\TopicSearch;

/**
 * @var $this          View
 * @var $searchModel   TopicSearch
 * @var $dataProvider  ActiveDataProvider
 */

$this->title = 'Topics';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['/article/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'bookmark';
?>
<?= Html::a('<i class="fas fa-plus"></i> Create New Topic', ['create'], ['class' => 'btn btn-primary']) ?>

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'emptyText'    => '<i data-feather="cast"></i><hr>' . Html::a('Create', ['create'], ['data-pjax' => 0]) . ' Your First Topic',
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'name',
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'home',
        ],
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'visible',
        ],
        [
            'label'          => 'Articles',
            'width'          => '50px',
            'contentOptions' => [
                'class' => 'text-center',
            ],
            'value'          => function(Topic $model)
            {
                return $model->getArticles()->count();
            },
        ],
        AdminGrid::COLUMN_ACTION,
    ],
]); ?>



