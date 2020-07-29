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
use app\modules\user\models\User;

/**
 * @var      $this  View
 * @var      $model User
 * @var      $form  ActiveForm
 */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'account', 'url' => ['account', 'id' => Yii::$app->user->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(); ?>
<div class="card user-card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-start">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back', ['account', 'id' => Yii::$app->user->id], ['class' => 'btn btn-white mr-4']) ?>
        </div>
        <div class="text-heading"><?= $this->title ?></div>
        <div class="d-flex justify-content-end">
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?= $form->field($model, 'password') ?>
                <?= $form->field($model, 'new_password') ?>
                <?= $form->field($model, 'new_password_confirm') ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
