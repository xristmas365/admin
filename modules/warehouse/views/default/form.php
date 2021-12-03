<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\modules\user\models\Role;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */
/* @var $userList array */
?>

<?php
$this->title = $model->isNewRecord ? 'New Warehouse' : $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'truck';

?>


<?php $form = ActiveForm::begin([
    'type'       => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 2],
]); ?>
<div class="card shadow">
    <div class="card-header d-flex justify-content-center">
        <div class="text-uppercase font-weight-bold" style="color:#596882"><?= $this->title ?></div>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>
        
        <?php if(Yii::$app->user->can(Role::ADMIN)): ?>
            
            <?= $form->field($model, 'user_id')->widget(Select2::class, [
                'data'          => $userList,
                'options'       => ['placeholder' => 'Select User'],
                'pluginOptions' => [
                    'allowClear'         => true,
                    'minimumInputLength' => 3,
                    'ajax'               => [
                        'url' => Url::toRoute(['/user/default/all-users']),
                    ],
                ],
            ]) ?>
        <?php endif ?>
        
        <?= $form->field($model, 'zip')->textInput(['maxlength' => true, 'placeholder' => 'Zip']) ?>
        
        <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'City']) ?>
        
        <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address']) ?>
        
        <?= $form->field($model, 'state')->textInput(['maxlength' => true, 'placeholder' => 'State']) ?>
        
        <?= $form->field($model, 'active')->checkbox(['custom' => true, 'switch' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

