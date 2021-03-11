<?php
/**
 * login.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\web\View;
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
<section class="container">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'auth-form py-5 col-lg-5 offset-lg-7 px-5']]) ?>
    <div class="h4 text-primary mb-2"><?= $this->title ?></div>
    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'firstName')->textInput(['placeholder' => 'First Name']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'lastName')->textInput(['placeholder' => 'Last Name']) ?>
        </div>
    </div>
    <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '(999) 999-9999', 'options' => ['placeholder' => '(___) ___-____']]) ?>
    <?= $form->field($model, 'remember')->checkbox() ?>
    <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    <p class="text-muted mt-2">
        Already have an account?
        <?= Html::a('Login', ['/user/auth/login'], ['class' => 'btn btn-link']) ?>
    </p>
    <?php ActiveForm::end() ?>
</section>
