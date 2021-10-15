<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use richardfan\widget\JSRegister;
use app\modules\store\models\search\ProductSearch;

/**
 * @var $this         View
 * @var $dataProvider ActiveDataProvider
 * @var $searchModel  ProductSearch
 * @var $catalogs     []
 */

$this->title = 'Products';
$this->params['breadcrumbs'][] = ['label' => 'Products'];
?>
<?php Pjax::begin() ?>
<?= $this->render('_search', ['model' => $searchModel, 'catalogs' => $catalogs]) ?>
<?= ListView::widget([
    'emptyText'        => '<i class="fas fa-4x fa-store-slash"></i><p class="mt-4 text-muted">Products Not Found</p>',
    'emptyTextOptions' => [
        'class' => 'col-12 text-center mt-4',
    ],
    'dataProvider'     => $dataProvider,
    'itemView'         => '_product',
    'summary'          => false,
    'layout'           => "<div class='row'>{items}</div>\n{pager}",
    'itemOptions'      => [
        'class' => 'col-lg-3 col-md-4',
    ],
    'options'          => [
        'class' => 'row pt-2',
    ],
]) ?>
<?php Pjax::end() ?>


<?php JSRegister::begin() ?>
<script>
$(document).on('change', 'input:radio[id^="productsearch-catalog-id-"]', function () {
  $('#product-search-form').submit()
})
</script>
<?php JSRegister::end() ?>


