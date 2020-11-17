<?php
/**
 * form.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\web\View;
use app\models\User;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use trntv\filekit\widget\Upload;

/**
 * @var      $this  View
 * @var      $model User
 * @var      $form  ActiveForm
 */

$this->title = $model->isNewRecord ? 'New User' : $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(); ?>
<div class="card user-card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-start">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back', ['index'], ['class' => 'btn btn-white mr-4']) ?>
        </div>
        <div class="text-heading"><?= $this->title ?></div>
        <div class="d-flex justify-content-end">
            <?php if(!$model->isNewRecord) : ?>
                <?= Html::a('<div class="fas fa-trash"></div> Delete', ['delete', 'id' => $model->id], [
                    'class'        => 'btn btn-danger mr-2',
                    'data-confirm' => 'Are You sure you want to Delete?',
                    'data-method'  => 'POST',
                ]) ?>
            <?php endif ?>
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end align-content-end">
            <?= $form->field($model, 'files')->widget(Upload::class, [
                'url'        => ['/storage/default/upload'],
                'uploadPath' => 'photo/',
                'multiple'   => true,
            ])->label('Photo') ?>
            <div class="row ml-4">
                <div class="col-md-6">
                    <?= $form->field($model, 'email') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'first_name') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'last_name') ?>
                </div>
            </div>
            <div class="row ml-4">
                <div class="col-md-6">
                    <?= $form->field($model, 'address') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'city') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'state') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'zip') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
