<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\MaskedInput;
use app\modules\user\models\Register;

/**
 * @var $this  View
 * @var $model Register
 */

$this->title = 'Registration';

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-signin']]) ?>
<h3 class="display-5 text-muted"><?= Html::a('Home', Url::home()) . ' / ' . $this->title ?></h3>
<p class="fs-5 text-muted">
    Enter Your Email Address, Password and Name to Register
</p>
<img class="mb-4" src="/images/t.png" alt="" width="100%">
<?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['placeholder' => 'Email'])->label(false) ?>
<?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'new-password', 'placeholder' => 'Password'])->label(false) ?>
<?= $form->field($model, 'name')->textInput(['placeholder' => 'Name'])->label(false) ?>
<?= $form->field($model, 'company')->textInput(['placeholder' => 'Company Name'])->label(false) ?>
<?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '(999) 999-9999', 'options' => ['placeholder' => 'Phone']])->label(false) ?>
<?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block']) ?>
<p class="text-muted mt-2">
    Already have an account?
    <?= Html::a('Login', ['/user/auth/login']) ?>
</p>
<?php ActiveForm::end() ?>

