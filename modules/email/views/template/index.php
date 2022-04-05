<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\email\models\search\TemplateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $userList array */

$this->title = 'Email Templates';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'mail';

?>
<div class="file-index">
    <?= Html::a('<i class="fas fa-plus"></i> Create New Template', ['create'], ['class' => 'btn btn-primary']) ?>
    <?= AdminGrid::widget([
        'id'           => 'template',
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            AdminGrid::COLUMN_CHECKBOX,
            'name',
            'subject',
            [
                'class'    => ActionColumn::class,
                'template' => "{send}{update}{delete}",
                'hAlign'   => AdminGrid::ALIGN_LEFT,
                'buttons'  => [
                    'send' => function($url, $model)
                    {
                        return Html::a('<i class="fas fa-envelope"></i>', '#', [
                            'data'  => [
                                'pjax'  => 0,
                                'url'   => Url::toRoute(['view', 'id' => $model->id]),
                                'title' => $model->name,
                                'id'    => $model->id,
                            ],
                            'class' => 'show-template text-primary',
                        ]);
                    },
                ],
            ],
        
        ],
    ]); ?>
</div>
<?php Modal::begin([
    'id'             => 'modal-template-content',
    'size'           => Modal::SIZE_EXTRA_LARGE,
    'centerVertical' => true,
    'title'          => '',
]) ?>
<div class="row">
    <div class="col-md-12">
        <div id="template-content"></div>
    </div>
</div>
<?php $form = ActiveForm::begin(['id' => 'send-email-form']) ?>
<?= Select2::widget([
    'name'          => 'users',
    'data'          => $userList,
    'theme'         => Select2::THEME_BOOTSTRAP,
    'options'       => ['multiple' => true, 'placeholder' => 'Select users', 'autocomplete' => 'on'],
    'pluginOptions' => [
        'allowClear'     => true,
        'dropdownParent' => '#modal-template-content',
    ],
]) ?>
<?= Html::hiddenInput('template_id', null, ['id' => 'template_id']) ?>
<?php ActiveForm::end() ?>
<div class="form-group">
    <?= Html::button('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <i class="fas fa-envelope"></i> Send', ['data-url' => Url::toRoute('send-mail'), 'class' => 'btn btn-primary mt-2', 'id' => 'send-template']) ?>
</div>
<?php Modal::end() ?>

<?php JSRegister::begin() ?>
<script>
$(document).on('click', '.show-template', function (e) {
  e.preventDefault()
  const url = $(this).data('url')
  const title = $(this).data('title')
  const id = $(this).data('id')
  $('#template-content').load(url)
  $('#modal-template-content').modal('show')
  $('#template_id').val(id)
  console.log(e)
  $('#modal-template-content-label').text(title)
})
$(document).on('click', '#send-template', function (e) {
  const data = $('#send-email-form').serialize()
  const url = $(this).data('url')
  $(this).attr('disabled','disabled')
  $.post(url, data).done(function (response) {
    $('#modal-template-content').modal('hide')
    $('#template_id').val('')
  })
})

$(document).ajaxSend(function () {
  $('.spinner-border').fadeIn()
})
$(document).ajaxSuccess(function () {
  $('.spinner-border').fadeOut()
})

$('#modal-template-content').on('hidden.bs.modal', function (e) {
  $('#template-content').text('')
  $('#modal-template-content-label').text('')
})
</script>
<?php JSRegister::end() ?>




