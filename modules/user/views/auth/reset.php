<?php
/**
 * reset.php
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

$this->title = 'Reset Password';

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'auth-form py-5 col-md-5 offset-md-7 px-5']]) ?>
<div class="h4 text-primary mb-2"><?= $this->title ?></div>
<?= $form->field($model, 'email') ?>
<?= Html::submitButton('Reset', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>
