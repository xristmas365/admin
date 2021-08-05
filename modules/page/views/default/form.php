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
use yii\web\JsExpression;
use kartik\form\ActiveForm;
use dosamigos\tinymce\TinyMce;
use trntv\filekit\widget\Upload;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'New Page' : $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'file-text';

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
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'content')->widget(TinyMce::class, [
            'clientOptions' => [
                'height'   => '500px',
                'toolbar'                 => "fullscreen | undo redo | code link table hr | styleselect | bold italic | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent |  ",
                'branding'                => false,
                'content_css'             => "/dist/app/bootstrap.css, /dist/app/app.css",
                'apply_source_formatting' => true,
                'plugins'                 => [
                    "advlist template autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime image imagetools media table paste hr",
                ],
                'images_upload_handler'   => new JsExpression('tinyUploadImage'),
                'templates'               => [
                    [
                        'title'       => 'Base Template',
                        'url'         => Url::toRoute(['/article/template/view', 'file' => 'base']),
                        'description' => 'Basic Template with standard elements',
                    ],
                ],
            
            ],
        ]) ?>
        <?= $form->field($model, 'files')->widget(Upload::class, [
            'url'              => ['/storage/default/upload'],
            'uploadPath'       => 'photo/',
            'multiple'         => true,
            'sortable'         => false,
            'maxNumberOfFiles' => 20,
        ])->label('Attachments') ?>
        <?= $form->field($model, 'seo_keywords')->textInput(['data-role' => 'tagsinput']) ?>
        <?= $form->field($model, 'seo_description') ?>
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save & Publish', ['class' => 'btn btn-primary', 'name' => 'publish']) ?>
        <?= Html::submitButton('<i class="fas fa-cloud"></i> Save', ['class' => 'btn btn-secondary']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>

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


