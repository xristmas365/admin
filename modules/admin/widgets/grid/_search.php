<?php
/**
 * _search.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
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

