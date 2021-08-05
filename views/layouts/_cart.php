<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use yii\widgets\Pjax;
use yz\shoppingcart\ShoppingCart;

/**
 * @var $cart ShoppingCart
 */

$cart = Yii::$app->cart;
$positions = $cart->positions;

?>
<nav id="sidebar" class="bg-light">
    <?php Pjax::begin(['id' => 'card-sidebar']) ?>
    <?php if($positions) : ?>
        <?php
        $summary = $cart->cost;
        $taxes = Yii::$app->getModule('store')->tax;
        $total = $summary * (1 + $taxes);
        ?>
        <div class="mx-2 mt-4">
            <div class="row">
                <div class="col-6">Summary:</div>
                <div class="col-6"><?= Yii::$app->formatter->asCurrency($summary) ?></div>
                <div class="col-6">Sale Taxes:</div>
                <div class="col-6"><?= Yii::$app->formatter->asCurrency($summary * $taxes) ?></div>
                <div class="col-6">Total:</div>
                <div class="col-6"><?= Yii::$app->formatter->asCurrency($total) ?></div>
            </div>
        </div>
        <hr>
        <?php foreach($positions as $position): ?>
            <div class="card m-2">
            <span
            class="cart-delete text-right text-danger"
            style="position: absolute; bottom: 20px; right: 20px; cursor: pointer"
            data-url="<?= Url::toRoute(['/store/cart/delete', 'slug' => $position->slug]) ?>"
            >
                <i class="fas fa-trash-alt"></i>
            </span>
                <img class="card-img-top" src="<?= $position->image ?>" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">
                        <?= $position->quantity . ' x ' . Yii::$app->formatter->asCurrency($position->price) . ' (' . $position->title . ')' ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center mt-4">
            Empty
        </div>
    <?php endif ?>
    <?php Pjax::end() ?>
</nav>
<div class="overlay"></div>
