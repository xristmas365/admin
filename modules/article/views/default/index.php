<?php

use yii\web\View;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Section;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ImageColumn;
use app\modules\admin\widgets\grid\SwitchColumn;
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

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'leftButtons'  => [
        [
            'url'   => ['create'],
            'label' => '<div class="fas fa-plus"></div> New',
        ],
        [
            'url'   => ['/article/section/index'],
            'label' => '<div class="fas fa-bars"></div> Topics',
        ],
    ],
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        [
            'class'          => ImageColumn::class,
            'imageAttribute' => 'coverImage',
        ],
        'title',
        [
            'attribute' => 'section_id',
            'value'     => 'section.name',
            'filter'    => Section::items(),
        ],
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'draft',
        ],
    ],
]); ?>
