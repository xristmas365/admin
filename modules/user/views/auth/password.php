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
use app\modules\user\models\Password;

/**
 * @var $this  View
 * @var $model Password
 */

$this->title = 'New Password';

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-signin']]) ?>
<h3 class="display-5 text-muted"><?= Html::a('Home', Url::home()) . ' / ' . $this->title ?></h3>
<p class="fs-5 text-muted">
    Enter New Password and Confirm&nbsp;New&nbsp;Password to Continue
</p>
<img class="mb-4" src="/images/t.png" alt="" width="100%">
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'New Password'])->label(false) ?>
<?= $form->field($model, 'password_confirm')->passwordInput(['placeholder' => 'New Password Confirm'])->label(false) ?>
<?= Html::submitButton('Continue...', ['class' => 'btn btn-primary btn-block']) ?>
<?php ActiveForm::end() ?>
