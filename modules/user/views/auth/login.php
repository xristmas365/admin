<?php
/**
 * login.php
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
use app\modules\user\models\Login;

/**
 * @var $this  View
 * @var $model Login
 */

$this->title = 'Login';

?>
<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password', ['addon' => ['append' => ['content' => Html::a('?', ['/user/auth/reset'])]]])->passwordInput() ?>
<?= $form->field($model, 'remember')->checkbox() ?>
<?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end() ?>
