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
use richardfan\widget\JSRegister;
use app\modules\user\models\User;
use app\modules\user\models\Role;

/**
 * @var      $this  View
 * @var      $model User
 * @var      $form  ActiveForm
 */

$this->title = $model->isNewRecord ? 'Register New User' : $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin([
    'type'       => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 1],
]); ?>
<div class="card shadow">
    <div class="card-header d-flex justify-content-center">
        <div class="text-uppercase font-weight-bold" style="color:#596882">User: <?= $this->title ?></div>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'email') ?>
        <?php if($model->isNewRecord): ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
        <?php endif ?>
        <?php if(Yii::$app->user->can(Role::ADMIN)): ?>
            <?= $form->field($model, 'role')->dropDownList(Role::list()) ?>
        <?php endif ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'company') ?>
        <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '(999) 999-9999', 'options' => ['placeholder' => '(555)-123-1234 Example']]) ?>
        <?= $form->field($model, 'zip')
                 ->widget(MaskedInput::class, ['mask' => '99999', 'options' => ['placeholder' => '92100 Example']])
                 ->hint('Enter ZIP Code. City and State will be set automatically') ?>
        <?= $form->field($model, 'city') ?>
        <?= $form->field($model, 'state') ?>
        <?= $form->field($model, 'address') ?>
        
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> ' . ($model->isNewRecord ? 'Register' : 'Save'), ['class' => 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord): ?>
            <?= Html::a('<div class="fas fa-lock"></div> New Password', ['new-password', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-light']) ?>
            <?= Html::a('<div class="fas fa-user-alt-slash"></div> Deactivate', ['deactivate', 'id' => Yii::$app->request->get('id')], [
                'class'        => 'btn btn-light',
                'data-confirm' => 'Are You Sure You Want to Deactivate this Account?',
                'data-method'  => 'POST',
            ]) ?>
        <?php endif ?>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php JSRegister::begin() ?>
<script>
$(document).on('change', '#user-zip', function () {
  const zip = $(this).val()
  $.get('<?=Url::toRoute(['/system/default/index'])?>', { zip: zip }).done(function (res) {
    if (res !== null) {
      $('#user-state').val(res.state)
      $('#user-city').val(res.city)
    }
  })
})
</script>
<?php JSRegister::end() ?>
