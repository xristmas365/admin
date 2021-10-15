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
use app\modules\store\models\search\ProductSearch;

/**
 * @var $catalogs []
 * @var $model    ProductSearch
 *
 */

?>
<div class="product-search border-bottom border-secondary">
    <?php $form = ActiveForm::begin([
        'id'      => 'product-search-form',
        'method'  => 'GET',
        'action'  => ['/store/front/index'],
        'options' => ['data-pjax' => 1],
    ]) ?>
    <div class="text-left">
        <?= $form->field($model, 'catalog_id')->radioButtonGroup([0 => 'All'] + $catalogs, [
            'itemOptions' => ['labelOptions' => ['class' => 'btn btn-light']],
        ])->label('Catalogs: ') ?>
    </div>
    <div class="row">
        <div class="col-1">Filters:</div>
        <div class="col-2"><?= $form->field($model, 'priceMin')->textInput(['placeholder' => '$ Price Min'])->label(false) ?></div>
        <div class="col-2"><?= $form->field($model, 'priceMax')->textInput(['placeholder' => '$ Price Max'])->label(false) ?></div>
        <div class="col-1"><?= $form->field($model, 'new')->checkbox(['custom' => true]) ?></div>
        <div class="col-1"><?= $form->field($model, 'popular')->checkbox(['custom' => true]) ?></div>
        <div class="col text-right">
            <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Clear', ['/store/front/index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>

