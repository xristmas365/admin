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
use richardfan\widget\JSRegister;
use app\modules\store\models\Product;

/**
 * @var $product Product
 */

$this->title = $product->title;
$this->params['breadcrumbs'][] = ['label' => 'Store', 'url' => ['/store/front/index']];
$this->params['breadcrumbs'][] = ['label' => $product->title];

?>
<h1><?= $product->title ?></h1>
<div class="row">
    <div class="col-8">
        <?= Html::img($product->image, ['width' => '100%']) ?>
    </div>
    <div class="col-4">
        <h3><?= Yii::$app->formatter->asCurrency($product->price) ?></h3>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <button id="cart-qty-delete" class="btn btn-secondary" type="button">-</button>
            </div>
            <input id="cart-qty" value="1" type="number" class="form-control" data-csrf="<?= Yii::$app->request->csrfToken ?>">
            <div class="input-group-append">
                <button id="cart-qty-add" class="btn btn-secondary" type="button">+</button>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-6">Sale Taxes:</div>
                <div class="col-6">
                    <span class="text-muted" id="cart-taxes" data-val="<?= Yii::$app->getModule('store')->tax ?>">
                        <?= Yii::$app->formatter->asPercent(Yii::$app->getModule('store')->tax) ?>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-6">Total:</div>
                <div class="col-6 font-weight-bold">
                    <span>$ </span>
                    <span id="cart-total">0</span>
                </div>
            </div>
        </div>
        <?= Html::button('Add to Cart', [
            'class'    => 'btn btn-primary btn-block cart-add',
            'data-url' => Url::toRoute(['/store/cart/add', 'slug' => $product->slug]),
        ]) ?>
        <section class="mt-4">
            <?= $product->description ?>
        </section>
    </div>
</div>
<div class="row mt-4">
    <div class="col-12">
        <?= $product->content ?>
    </div>
</div>
<?php JSRegister::begin() ?>
<script>
function count () {
  const price = Number("<?=$product->price?>")
  const qty = $('#cart-qty').val()
  const taxes = $('#cart-taxes').data('val')
  const total = price * qty + (price * qty * taxes)
  $('#cart-total').text(Number(total).toFixed(2))
}

count()
$(document).on('click', '#cart-qty-add', function () {
    const qty = $('#cart-qty')
    let val = Number(qty.val())
    val++
    qty.val(val)
    count()
  }
)
$(document).on('click', '#cart-qty-delete', function () {
    const qty = $('#cart-qty')
    let val = Number(qty.val())
    if (val !== 1) {
      val--
      qty.val(val)
      count()
    }
  }
)
$(document).on('keyup', '#cart-qty', function (e) {
  count()
})
</script>
<?php JSRegister::end() ?>

