<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use trntv\filekit\widget\Upload;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model app\modules\email\models\EmailTemplate */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'New Email Template' : $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Email Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'mail';

?>


<?php $form = ActiveForm::begin(); ?>
<div class="card shadow p-4">
    <div class="text-heading mb-4"><?= $this->title ?></div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'content')->widget(TinyMce::class, [
        'clientOptions' => [
            'height'                  => '40vh',
            'toolbar'                 => "fullscreen |undo redo | code link table hr | styleselect | bold italic | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent |  ",
            'branding'                => false,
            'content_css'             => Yii::$app->assetManager->getPublishedUrl(Yii::getAlias('@npm/bootstrap/dist')) . '/css/bootstrap.css',
            'apply_source_formatting' => true,
            'plugins'                 => [
                "advlist template autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime image imagetools media table paste hr fullscreen",
            ],
            'images_upload_handler'   => new JsExpression('tinyUploadImage'),
        ],
    ]) ?>
    <p><b>Available handlebars:</b> {{name}}</p>
    <?= $form->field($model, 'files')->widget(Upload::class, [
        'url'              => ['/storage/default/upload'],
        'uploadPath'       => 'photo/',
        'multiple'         => true,
        'sortable'         => false,
        'maxNumberOfFiles' => 20,
    ])->label('Attachments') ?>
   
    <div class="form-group">
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php JSRegister::begin(['position' => View::POS_BEGIN]) ?>
<script>
function tinyUploadImage (blobInfo, success, failure, progress) {
  $('#w1').fileupload('add', { files: blobInfo.blob() })
  $('#w1').on('fileuploaddone', function (e, data) {
    success(window.location.origin + data.jqXHR.responseJSON.files[0].url)
  })
}
</script>
<?php JSRegister::end() ?>

