<?php
/**
 * index.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\helpers\Html;
use app\modules\store\models\Product;
use app\modules\store\models\Catalog;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\SwitchColumn;

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
        AdminGrid::COLUMN_IMAGE,
        AdminGrid::COLUMN_CHECKBOX,
        [
            'attribute' => 'title',
            'format'    => 'raw',
            'value'     => function(Product $model)
            {
                return Html::a($model->title, ['/store/front/product', 'slug' => $model->slug], ['data-pjax' => 0]);
            },
        ],
        [
            'attribute' => 'catalog_id',
            'format'    => 'raw',
            'filter'    => Catalog::getList(),
            'value'     => function(Product $model)
            {
                return $model->catalog ? $model->catalog->getBreadcrumbs(0) : null;
                
            },
        ],
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'active',
        ],
        'price:currency',
    ],
]) ?>
