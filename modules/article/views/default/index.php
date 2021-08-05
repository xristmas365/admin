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
use app\modules\article\models\Article;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\article\models\search\ArticleSearch;

/**
 * @var $this         View
 * @var $searchModel  ArticleSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'cast';
?>
<?= Html::a('<i class="fas fa-plus"></i> Create New Article', ['create'], ['class' => 'btn btn-primary']) ?>
<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'emptyText'    => '<i data-feather="cast"></i><hr>' . Html::a('Create', ['create'], ['data-pjax' => 0]) . ' Your First Article',
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'title',
        [
            'attribute' => 'topic_id',
            'value'     => 'topic.name',
        ],
        [
            'attribute' => 'published_at',
            'format'    => 'dateTime',
            'width'     => '100px',
        ],
        [
            'attribute' => 'created_at',
            'format'    => 'dateTime',
            'width'     => '100px',
        ],
        [
            'attribute'      => 'visits',
            'width'          => '50px',
            'contentOptions' => [
                'class' => 'text-center',
            ],
        
        ],
        [
            'label'          => 'Content',
            'format'         => 'raw',
            'width'          => '50px',
            'contentOptions' => [
                'class' => 'text-center',
            ],
            'value'          => function(Article $model)
            {
                if($model->content) {
                    return '<i class="fas text-success fa-check"></i>';
                }
                
                return '<i class="fas text-danger fa-times"></i>';
            },
        ],
        [
            'label'          => 'SEO',
            'format'         => 'raw',
            'width'          => '50px',
            'contentOptions' => [
                'class' => 'text-center',
            ],
            'value'          => function(Article $model)
            {
                if($model->seo_keywords && $model->seo_description) {
                    return '<i class="fas text-success fa-check"></i>';
                }
                
                return '<i class="fas text-danger fa-times"></i>';
            },
        ],
        
        AdminGrid::COLUMN_ACTION,
    ],
]); ?>
