<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\form\ActiveForm;
use richardfan\widget\JSRegister;
use app\modules\file\models\File;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\file\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">
    <button type="button" class="btn btn-primary" style="margin-left: 10px;" data-toggle="modal" data-target="#exampleModalCenter">Upload File</button>
    <?= AdminGrid::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'size',
            'ext',
            [
                'class'    => ActionColumn::class,
                'template' => '{upload}{update}{delete}',
                'buttons'  => [
                    'upload' => function($url, File $model)
                    {
                        return Html::a('<i class="fas fa-upload"></i>', '#', [
                            'data'  => [
                                'pjax'  => 0,
                                'url'   => Url::toRoute(['show', 'id' => $model->id]),
                                'title' => $model->name,
                            ],
                            'class' => 'show-file text-primary',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>

<?php Modal::begin([
    'id'             => 'modal-file-content',
    'scrollable'     => true,
    'size'           => Modal::SIZE_EXTRA_LARGE,
    'centerVertical' => true,
    'title'          => '',
]) ?>
<div class="row">
    <div class="col-md-12">
        <div id="file-content"></div>
    </div>
</div>
<?php Modal::end() ?>
<?php JSRegister::begin() ?>
<script>
/**
 * Show File in Modal
 */
$(document).on('click', '.show-file', function (e) {
  e.preventDefault()
  const url = $(this).data('url')
  const title = $(this).data('title')
  $('#file-content').load(url)
  $('#modal-file-content').modal('show')
  $('#modal-file-content-label').text(title)
})
/**
 * Clear Modal Content after modal hide
 */
$('#modal-file-content').on('hidden.bs.modal', function (e) {
  $('#file-content').text('')
  $('#modal-file-content-label').text('')
})
</script>
<?php JSRegister::end() ?>
