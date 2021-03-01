<?php

use yii\web\View;
use yii\helpers\Html;
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

$createButton =
    '<div>' .
    Html::a('<div class="fas fa-plus"></div> New', ['create'], ['class' => 'btn btn-white', 'data-pjax' => 0])
    . Html::a('<div class="fas fa-bars"></div> Topics', ['/article/section/index'], ['class' => 'btn btn-white ml-2', 'data-pjax' => 0])
    . '</div>';

?>

<?= AdminGrid::widget([
    'createButton' => $createButton,
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        AdminGrid::COLUMN_SERIAL,
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
        
        AdminGrid::COLUMN_ACTION,
    ],
]); ?>
