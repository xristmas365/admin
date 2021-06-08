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
<div class="container-admin shadow p-4">
    <div class="text-heading mb-4"><?= $this->title ?></div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'files')->widget(Upload::class, [
                'url'        => ['/storage/default/upload'],
                'uploadPath' => 'photo/',
                'multiple'   => true,
            ])->label('Photo') ?>
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white btn-block']) ?>
            <?= Html::a('<div class="fas fa-ban"></div> Cancel', ['/admin/default/index'], ['class' => 'btn btn-block btn-white']) ?>
        </div>
        <div class="col-md-10 ">
            <?= $form->field($model, 'email') ?>
            <div class="row">
                <div class="col"><?= $form->field($model, 'first_name') ?></div>
                <div class="col"><?= $form->field($model, 'last_name') ?></div>
            </div>
            <?= $form->field($model, 'phone') ?>
            <?= $form->field($model, 'address') ?>
            <?= $form->field($model, 'city') ?>
            <?= $form->field($model, 'state') ?>
            <?= $form->field($model, 'zip') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 offset-md-2">
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
