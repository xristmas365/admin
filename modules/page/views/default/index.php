<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\page\models\Page;
use app\modules\admin\widgets\grid\AdminGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\page\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'file-text'
?>

<?= Html::a('<i class="fas fa-plus"></i> Create New Page', ['create'], ['class' => 'btn btn-primary']) ?>

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'emptyText'    => '<i data-feather="file-text"></i><hr>' . Html::a('Create', ['create'], ['data-pjax' => 0]) . ' Your First Page',
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'title',
        [
            'label'     => 'Author',
            'attribute' => 'created_by',
            'value'     => 'author.name',
        ],
        [
            'attribute' => 'slug',
            'label'     => 'Link',
            'format'    => 'raw',
            'value'     => function(Page $model)
            {
                $link = Url::toRoute(['/page/front/view', 'slug' => $model->slug], true);
                
                return Html::a('<i class="fas fa-external-link-alt"></i>&nbsp' . $link, $link, ['data-pjax' => 0, 'target' => '_blank']);
            },
        ],
        'created_at:date',
        [
            'label'          => 'Content',
            'format'         => 'raw',
            'width'          => '50px',
            'contentOptions' => [
                'class' => 'text-center',
            ],
            'value'          => function(Page $model)
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
            'value'          => function(Page $model)
            {
                if($model->seo_keywords && $model->seo_description) {
                    return '<i class="fas text-success fa-check"></i>';
                }
                
                return '<i class="fas text-danger fa-times"></i>';
            },
        ],
        AdminGrid::COLUMN_ACTION,
    ],
]) ?>

