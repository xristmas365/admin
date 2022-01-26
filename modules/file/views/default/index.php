<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\modules\admin\widgets\grid\AdminGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\file\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">
    <p>
        <button type="button" class="btn btn-primary" style="margin-left: 10px;" data-toggle="modal" data-target="#exampleModalCenter">Upload File</button>
    </p>
    <?= AdminGrid::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'id',
            'name',
            'size',
            'ext',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php $form = ActiveForm::begin([
                'id'      => 'js-form-file',
                'method'  => 'post',
                'options' => ['enctype' => 'multipart/form-data'],
                'action'  => Url::toRoute(['/file/default/create']),
            ]) ?>
            <div class="modal-body px-4 py-0">
                <div class="d-flex my-4 align-items-center">
                    <?= $form->field($model, 'file')->fileInput(['id' => 'file-upload', 'class' => 'd-none file-upload'])->label(false) ?>
                    <button type="button" class="add-btn js-file-upload mr-3">
                        choose file
                    </button>
                    <span class="js-file-name">No file chosen</span>
                </div>
            </div>
            <div class="modal-footer px-4">
                <button type="button" id="js-upload-button" disabled class="btn btn-primary">Upload file</button>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

<?php $js = <<< JS
$(document).on('click','.js-export',function(e) {
  e.preventDefault()
  $('#preloader').css('display','block')
  let count = $(this).data('count')
  $.post({
  url:'/file/default/export',
  data:{count:count},
  success:function(res) {
    $('#preloader').css('display','none')
    var link = document.createElement('a');
	link.setAttribute('href', res);
	link.setAttribute('download', 'list.csv');
	link.click();
	link.remove()
	$.post({
	url:'/shop/product/delete-csv'
	})
	return false;
  }
  })
})

 let upload = $('#file-upload')
    $('.js-file-upload').click(function () {
        upload.trigger('click');
    })
    upload.change(function () {
        $('.js-file-name').text(this.files.item(0).name)
        $('#js-upload-button').removeAttr('disabled')
    })

    $(document).on('click', '#js-upload-button', function () {
       let form = $('#js-form-file')
       $('#preloader').css('display','block')
       form.submit()
    })
JS;
$this->registerJs($js)
?>
