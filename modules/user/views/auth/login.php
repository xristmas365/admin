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
use app\modules\user\models\Login;

/**
 * @var $this  View
 * @var $model Login
 */

$this->title = 'Login';

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'auth-form py-5 col-md-5 offset-md-7 px-5']]) ?>
<div class="h4 text-primary mb-2"><?= $this->title ?></div>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password', ['addon' => ['append' => ['content' => Html::a('?', ['/user/auth/reset'])]]])->passwordInput() ?>
<?= $form->field($model, 'remember')->checkbox(['custom' => true])->label('Remember Me') ?>
<?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
<p class="text-muted mt-2">
    Don't have an account?
    <?= Html::a('Register', ['/user/auth/register'], ['class' => 'btn btn-link']) ?>
</p>
<?php ActiveForm::end() ?>

