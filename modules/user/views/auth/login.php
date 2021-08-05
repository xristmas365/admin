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
use app\modules\user\models\Login;

/**
 * @var $this  View
 * @var $model Login
 */

$this->title = 'Login';
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-signin']]) ?>
<h3 class="display-5 text-muted"><?= Html::a('Home', Url::home()) . ' / ' . $this->title ?></h3>
<p class="fs-5 text-muted">
    Enter Your Email Address and Password to Login. If You forgot your Password, click&nbsp;<?= Html::a('Reset&nbsp;Password', ['/user/auth/reset']) ?>
</p>
<img class="mb-4" src="/images/t.png" alt="" width="100%">
<?= $form->field($model, 'email', [
    'errorOptions' => [
        'encode' => false,
    
    ],
])->textInput(['placeholder' => 'Email'])->label(false) ?>
<?= $form->field($model, 'password', [
    'errorOptions' => [
        'encode' => false,
    
    ],
])->passwordInput(['autocomplete' => 'new-password', 'placeholder' => 'Password'])->label(false) ?>
<?= $form->field($model, 'remember')->checkbox()->label('Remember Me') ?>
<?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block']) ?>
<p class="text-muted mt-2">
    Don't have an account?
    <?= Html::a('Register', ['/user/auth/register']) ?>
</p>
<?php ActiveForm::end() ?>
