<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\modules\user\models\Role;
use app\modules\store\models\Catalog;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;
use app\modules\admin\widgets\grid\ActionColumn;
use app\modules\store\models\search\ProductSearch;

/**
 * @var $this         View
 * @var $searchModel  ProductSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Catalogs';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'server'
?>

<?= Html::a('<i class="fas fa-plus"></i> Create New Catalog', ['create'], ['class' => 'btn btn-primary']) ?>
<div class="my-3"></div>
<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'emptyText'    => '<i data-feather="server"></i><hr>' . Html::a('Create', ['create'], ['data-pjax' => 0]) . ' Your First Catalog',
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'name',
        [
            'attribute' => 'slug',
            'label'     => 'Link',
            'format'    => 'raw',
            'value'     => function(Catalog $model)
            {
                $link = Url::toRoute([
                    '/store/front/index',
                    'ProductSearch' => ['catalog_id' => $model->id],
                ]);
                
                return Html::a('<i class="fas fa-external-link-alt"></i>&nbsp' . $model->name, $link, ['data-pjax' => 0, 'target' => '_blank']);
            },
        ],
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'visible',
            'readonly'  => !Yii::$app->user->can(Role::ADMIN),
        ],
        [
            'label' => 'Products',
            'width' => '40px',
            'value' => function(Catalog $model)
            {
                return $model->getProducts()->count();
            },
        ],
        [
            'class'   => ActionColumn::class,
            'visible' => Yii::$app->user->can(Role::ADMIN),
        ],
    ],
]) ?>
