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
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\grid\SerialColumn;
use yz\shoppingcart\ShoppingCart;
use app\modules\store\models\Coupon;

/**
 * @var array        $dataProvider
 * @var ShoppingCart $cart
 * @var Coupon|null  $coupon
 */

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php Pjax::begin(['id' => 'checkout-pjax']) ?>
<?php if($coupon): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Coupon <strong><?= $coupon->name ?></strong> Applied! Your Discount <strong><?= $coupon->value ?>%</strong>
        <button type="button" id="checkout-coupon-delete" class="close" data-url="<?= Url::toRoute(['/store/cart/coupon-delete']) ?>" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif ?>
<?= GridView::widget([
    'dataProvider'     => $dataProvider,
    'summary'          => false,
    'striped'          => false,
    'resizableColumns' => false,
    'showPageSummary'  => true,
    'tableOptions'     => [
        'class' => 'table table-sm',
    ],
    'columns'          => [
        [
            'class' => SerialColumn::class,
        ],
        [
            'attribute' => 'title',
            'format'    => 'raw',
            'value'     => function($model)
            {
                return Html::a($model['title'], ['/store/front/product', 'slug' => $model['slug']], ['data-pjax' => 0, 'target' => '_blank']);
            },
        ],
        'price:currency',
        [
            'attribute' => 'quantity',
            'format'    => 'raw',
            'width'     => '150px',
            'value'     => function($model)
            {
                $addUrl = Url::toRoute(['/store/cart/add', 'slug' => $model['slug']]);
                $removeUrl = Url::toRoute(['/store/cart/remove', 'slug' => $model['slug']]);
                
                return '
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <button class="btn btn-sm btn-secondary checkout-remove" type="button" data-id="' . $model['id'] . '"  data-url="' . $removeUrl . '">-</button>
                    </div>
                    <input type="number" readonly class="form-control text-center" value="' . $model['quantity'] . '">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-secondary checkout-add" type="button" data-id="' . $model['id'] . '" data-url="' . $addUrl . '">+</button>
                    </div>
                </div>';
            },
        ],
        [
            'label'       => 'Summary',
            'format'      => 'currency',
            'pageSummary' => true,
            'value'       => function($model)
            {
                return $model['quantity'] * $model['price'];
            },
        ],
        [
            'format' => 'raw',
            'width'  => '40px',
            'value'  => function($model)
            {
                return Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-danger checkout-remove', 'data-url' => Url::toRoute(['/store/cart/delete', 'slug' => $model['slug']])]);
            },
        ],
    ],
]) ?>
<?php

$tax = Yii::$app->getModule('store')->tax;
$discount = $coupon ? $coupon->value : 0;
$sum = $cart->cost * (1 - $discount / 100);
$total = $tax * $sum;
?>
<div class="text-right">
    <div class="row justify-content-end">
        <div class="col-3">
            <div class="input-group input-group-sm mb-2">
                <input type="text" id="checkout-coupon-input" placeholder="Enter Coupon" class="form-control text-center">
                <div class="input-group-append">
                    <button id="checkout-coupon-apply" class="btn btn-sm btn-secondary" type="button" data-url="<?= Url::toRoute(['/store/cart/coupon']) ?>">Apply</button>
                </div>
            </div>
        </div>
    </div>
    <?php if($coupon) : ?>
        <h6>Coupon Discount ( -<?= Yii::$app->formatter->asPercent($discount / 100) ?>): <?= Yii::$app->formatter->asCurrency(($discount / 100) * $cart->cost) ?></h6>
    <?php endif ?>
    <h6>Sales Taxes (<?= Yii::$app->formatter->asPercent($tax) ?>): <?= Yii::$app->formatter->asCurrency($tax * $sum) ?></h6>
    <h6 class="font-weight-bold">Total: <?= Yii::$app->formatter->asCurrency($tax * $sum + $sum) ?></h6>
    <?php if($sum > 0) : ?>
        <?= Html::a('Continue to Billing <i class="fas fa-angle-double-right"></i>', ['billing'], ['class' => 'btn btn-primary']) ?>
    <?php endif ?>
</div>
<?php Pjax::end() ?>
