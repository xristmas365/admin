<?php

use yii\web\View;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use trntv\filekit\widget\Upload;
use richardfan\widget\JSRegister;
use app\modules\article\models\Section;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'New Article' : $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$this->params['icon'] = $this->title;
?>
<?php $form = ActiveForm::begin() ?>
<div class="card">
    <div class="card-header text-center text-heading bg-light d-flex justify-content-between align-items-center">
        <div></div>
        <?= $this->title ?>
        <div>
            <?= Html::submitButton('<i class="fas fa-cloud"></i> Save as Draft', ['class' => 'btn btn-white', 'name' => 'draft']) ?>
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save & Post', ['class' => 'btn btn-white']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <?= $form->field($model, 'description')->textarea(['rows' => 2, 'placeholder' => 'Description'])->label(false) ?>
                <?= $form->field($model, 'content')->widget(TinyMce::class, [
                    'clientOptions' => [
                        'height'                => '70vh',
                        'toolbar'               => "undo redo | code link table hr | styleselect | bold italic | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent |  ",
                        'branding'              => false,
                        'plugins'               => [
                            "advlist template autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime image imagetools media table paste hr",
                        ],
                        'images_upload_handler' => new JsExpression('tinyUploadImage'),
                    
                    ],
                ])->label(false) ?>
                <?= $form->field($model, 'files')->widget(Upload::class, [
                    'url'              => ['/storage/default/upload'],
                    'uploadPath'       => 'photo/',
                    'multiple'         => true,
                    'sortable'         => false,
                    'maxNumberOfFiles' => 20,
                ])->label('Attachments') ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'title')->textInput(['placeholder' => 'Title'])->label(false) ?>
                <?= $form->field($model, 'section_id')->dropDownList(Section::items(), ['prompt' => 'Select Section'])->label(false) ?>
                <?= $form->field($model, 'cover')->widget(Upload::class, [
                    'url'        => ['/storage/default/upload'],
                    'uploadPath' => 'photo/',
                    'multiple'   => true,
                ])->label('Cover') ?>
                <hr>
                <?= $form->field($model, 'seo_description')->textarea(['rows' => 2]) ?>
                <?= $form->field($model, 'seo_keywords')->textInput(['data-role' => 'tagsinput']) ?>
            </div>
        </div>
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




