<?php

/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yz\shoppingcart\ShoppingCart;
use app\modules\store\models\Coupon;
use app\modules\store\models\Billing;

/**
 * @var ShoppingCart $cart
 * @var Billing      $billing
 * @var Coupon       $coupon
 */
$this->title = 'Billing Information';
$this->params['breadcrumbs'][] = ['label' => 'Checkout', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$discount = $coupon ? $coupon->value : 0;
$sum = $cart->cost * (1 - $discount / 100);
$taxRate = Yii::$app->getModule('store')->tax;
$tax = $sum * $taxRate;
$total = $sum + $tax;

?>
<div class="row">
    <div class="col-7">
        <table class="table table-bordered">
            <tr>
                <th>Items</th>
                <td><?= $cart->count ?></td>
            </tr>
            <tr>
                <th>Summary</th>
                <td><?= Yii::$app->formatter->asCurrency($cart->cost) ?></td>
            </tr>
            <?php if($coupon) : ?>
                <tr>
                    <th>Discount (<?= $coupon->name ?> - <?= $coupon->value ?>%)</th>
                    <td>- <?= Yii::$app->formatter->asCurrency($cart->cost * $discount / 100) ?></td>
                </tr>
            <?php endif ?>
            <tr>
                <th>Sale Taxes</th>
                <td><?= Yii::$app->formatter->asCurrency($tax) ?></td>
            </tr>
            <tr>
                <th>Total</th>
                <th><?= Yii::$app->formatter->asCurrency($total) ?></th>
            </tr>
        </table>
    </div>
    <div class="col-5">
        <div class="card">
            <div class="card-body">
                <?php $form = ActiveForm::begin() ?>
                <?= $form->field($billing, 'email') ?>
                <?= $form->field($billing, 'name') ?>
                <?= $form->field($billing, 'phone')->phoneInput() ?>
                <?= $form->field($billing, 'token')->stripeCard() ?>
                <?= Html::submitButton('Proceed', ['class' => 'btn btn-primary btn-block']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>
