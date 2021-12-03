<?php

use yii\helpers\Html;
use app\modules\warehouse\models\Warehouse;

/**
 * @var $warehouse Warehouse
 * @var $products  array
 */

$this->title = 'Receive '.count($products) .' products to '.$warehouse->name;
$this->params['breadcrumbs'][] = ['label'=>'products', 'url'=>['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'arrow-down-circle';
?>
<?= Html::beginForm(['receive-products', 'id' => $warehouse->id]) ?>
<table class="table">
    <tr>
        <th>#</th>
        <th>Product</th>
        <th>Price, $</th>
        <th>Quantity</th>
    </tr>
    <?php $i = 1;
    foreach($products as $product) : ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= Html::dropDownList("Receive[$i][id]", $product['id'], [$product['id'] => $product['title']], ['class' => 'form-control']) ?></td>
            <td><?= Html::textInput("Receive[$i][price]", $product['price'], ['readonly' => true, 'class' => 'form-control']) ?></td>
            <td><?= Html::textInput("Receive[$i][quantity]", 1, ['class' => 'form-control']) ?></td>
        </tr>
        <?php $i++ ?>
    <?php endforeach; ?>
</table>
<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-link']) ?>

<?= Html::endForm() ?>
