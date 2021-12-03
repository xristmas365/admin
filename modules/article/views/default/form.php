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
use kartik\date\DatePicker;
use dosamigos\tinymce\TinyMce;
use trntv\filekit\widget\Upload;
use richardfan\widget\JSRegister;
use app\modules\article\models\Topic;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Article */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'New Article' : $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'cast';

if($model->published_at) {
    $model->published_at = date('m/d/Y', $model->published_at);
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
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Title']) ?>
        <?= $form->field($model, 'topic_id')->dropDownList(Topic::items(), ['prompt' => 'Select Topic']) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 2, 'placeholder' => 'Description']) ?>
        <?= $form->field($model, 'published_at')->widget(DatePicker::class, [
            'pluginOptions' => [
                'format'    => 'mm/dd/yyyy',
                'autoclose' => true,
            ],
            'options'       => [
                'width' => '300px',
            ],
        ])->label('Publish At') ?>
        <?= $form->field($model, 'content')->widget(TinyMce::class, [
            'clientOptions' => [
                'height'                  => '70vh',
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
        <?= $form->field($model, 'seo_title') ?>
        <?= $form->field($model, 'seo_description')->textarea(['rows' => 2]) ?>
        <?= $form->field($model, 'seo_keywords')->textInput(['data-role' => 'tagsinput']) ?>
        
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-primary']) ?>
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

