<?php
/**
 * password.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\web\View;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\modules\user\models\Password;

/**
 * @var $this  View
 * @var $model Password
 */

$this->title = 'Reset Password';

?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_confirm')->passwordInput() ?>
<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>
