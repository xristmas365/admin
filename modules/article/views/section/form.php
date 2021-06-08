<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Section */
/* @var $form ActiveForm */
?>

<?php $form = ActiveForm::begin() ?>
<div class="shadow p-4">
    <div class="text-heading mb-4"><?= $model->name ?></div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'home')->checkbox() ?>
            <?= $form->field($model, 'visible')->checkbox() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'files')->widget(Upload::class, [
                'url'        => ['/storage/default/upload'],
                'uploadPath' => 'section/',
                'multiple'   => true,
            ])->label('Cover') ?>
        </div>
    </div>
    <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white']) ?>
    <?= Html::a('<div class="fas fa-ban"></div> Cancel', ['/article/section/index'], ['class' => 'btn btn-white']) ?>
</div>
<?php $form = ActiveForm::end() ?>
