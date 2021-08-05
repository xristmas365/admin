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

?>
<?php $form = ActiveForm::begin([
    'id'      => 'storage-search-form',
    'method'  => 'GET',
    'action'  => ['/admin/file/storage'],
    'options' => [
        'data-pjax' => 1,
    ],
]) ?>
<?= $form->field($model, 'search', [
    'addon' => [
        'append' => [
            'content'  => Html::submitButton('<i class="fas fa-search"></i> Search', ['class' => 'btn btn-primary']) . Html::a('<i class="fas fa-ban"></i> Clear', ['storage'], ['class' => 'btn btn-secondary']),
            'asButton' => true,
        ],
    ],
])->textInput(['placeholder' => 'Search by Model Name, Path, Name'])->label(false) ?>
<?php ActiveForm::end() ?>
