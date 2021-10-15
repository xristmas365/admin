<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
use extead\autonumeric\AutoNumeric;
use app\modules\store\models\Coupon;

/**
 * @var $this  yii\web\View
 * @var $model Coupon
 * @var $form  ActiveForm
 */

$this->title = $model->isNewRecord ? 'New Coupon' : $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Coupons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if(!$model->isNewRecord) {
    $model->start_date = Yii::$app->formatter->asDate($model->start_date);
    $model->end_date = Yii::$app->formatter->asDate($model->end_date);
}

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
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Coupon Name']) ?>
        
        <?= $form->field($model, 'value')->widget(AutoNumeric::class, ['options' => ['placeholder' => 'Coupon Discount %']]) ?>
        <?= $form->field($model, 'start_date')->widget(DatePicker::class, ['type' => DatePicker::TYPE_INPUT, 'options' => ['placeholder' => 'Coupon Start Date']]) ?>
        <?= $form->field($model, 'end_date')->widget(DatePicker::class, ['type' => DatePicker::TYPE_INPUT, 'options' => ['placeholder' => 'Coupon End Date']]) ?>
        
        
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>


