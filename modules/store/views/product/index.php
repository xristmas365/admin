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

use yii\helpers\Html;
use yii\helpers\StringHelper;
use kartik\grid\BooleanColumn;
use app\modules\store\models\Product;
use app\modules\store\models\Catalog;
use app\modules\admin\widgets\grid\AdminGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\store\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'shopping-bag'
?>


<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        AdminGrid::COLUMN_SERIAL,
        [
            'attribute' => 'title',
            'format'    => 'raw',
            'value'     => function(Product $model)
            {
                return Html::a($model->title, ['/store/front/product', 'slug' => $model->slug], ['data-pjax' => 0]);
            },
        ],
        [
            'attribute'           => 'catalog_id',
            'format'              => 'raw',
            'width'               => '30%',
            'filterType'          => 'kartik\tree\TreeViewInput',
            'filterWidgetOptions' => [
                'query'            => Catalog::find()->addOrderBy('root, lft'),
                'headingOptions'   => ['label' => 'Store'],
                'rootOptions'      => ['label' => '<i class="fas fa-tree text-success"></i>'],
                'fontAwesome'      => true,
                'multiple'         => false,
                'topRootAsHeading' => true,
            ],
            'value'               => function(Product $model)
            {
                return $model->catalog->getBreadcrumbs(0);
                
            },
        ],
        //[
        //    'attribute' => 'description',
        //    'width'     => '30%',
        //    'value'     => function(Product $model)
        //    {
        //        return StringHelper::truncate($model->description, 70);
        //    },
        //],
        [
            'class'     => BooleanColumn::class,
            'attribute' => 'active',
        ],
        'price:currency',
        AdminGrid::COLUMN_ACTION,
    ],
]) ?>
