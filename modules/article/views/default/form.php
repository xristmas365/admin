<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

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
<div class="container-admin shadow p-4">
    <div class="text-heading mb-4"><?= $this->title ?></div>
    <div class="row">
        <div class="col-md-10">
            <?= $form->field($model, 'title')->textInput(['placeholder' => 'Title']) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 2, 'placeholder' => 'Description']) ?>
            <?= $form->field($model, 'content')->widget(TinyMce::class, [
                'clientOptions' => [
                    'height'                  => '70vh',
                    'toolbar'                 => "undo redo | code link table hr | styleselect | bold italic | alignleft aligncenter alignright alignjustify | image | bullist numlist outdent indent |  ",
                    'branding'                => false,
                    'content_css'             => "/dist/app/bootstrap.css, /dist/app/app.css",
                    'apply_source_formatting' => true,
                    'plugins'                 => [
                        "advlist template autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime image imagetools media table paste hr",
                    ],
                    'images_upload_handler'   => new JsExpression('tinyUploadImage'),
                
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
            <?= $form->field($model, 'section_id')->dropDownList(Section::items(), ['prompt' => 'Select Section']) ?>
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
    <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save & Post', ['class' => 'btn btn-white']) ?>
    <?= Html::submitButton('<i class="fas fa-cloud"></i> Save as Draft', ['class' => 'btn btn-white', 'name' => 'draft']) ?>
    <?= Html::a('<i class="fas fa-ban"></i> Cancel', ['index'], ['class' => 'btn btn-white']) ?>
    <?php if(!$model->isNewRecord) : ?>
        <?= Html::a('<div class="fas fa-trash"></div> Delete', ['delete', 'id' => $model->id], [
            'class'        => 'btn btn-danger ml-2',
            'data-confirm' => 'Are You sure you want to Delete?',
            'data-method'  => 'POST',
        ]) ?>
    <?php endif ?>
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

