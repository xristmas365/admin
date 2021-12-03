<?php
/**
 * @author    Ann Kononovich <anna.kononovich@gmail.com>
 * @package   Admin AX project
 * @version   2.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\data\ActiveDataProvider;
use app\modules\warehouse\models\Warehouse;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\warehouse\models\search\ProductSearch;

/**
 * @var $model        Warehouse
 * @var $searchModel  ProductSearch
 * @var $dataProvider ActiveDataProvider
 *
 */
$this->title = 'Warehouse ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'attribute' => 'product_id',
            'value'     => 'product.title',
        ],
        'price:currency',
        'qty',
        'total:currency',
    ],
]); ?>

