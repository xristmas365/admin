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

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(
    [
        'action'  => ['index'],
        'method'  => 'get',
        'options' => ['data-pjax' => 1],
    ]
); ?>

<?= $form->field($model, 'search',
    [
        'options' => ['class' => 'grid-form-group'],
        'addon'   => [
            'append' => [
                'content'  => Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'btn btn-white']),
                'asButton' => true,
            ],
        ],
    ]
)->textInput(['placeholder' => 'Search...', 'class' => 'grid-search'])->label(false) ?>
<?php ActiveForm::end(); ?>

