<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\admin\widgets\grid\AdminGrid;

/* @var $this yii\web\View */
/* @var $model app\modules\file\models\File */
/* @var $line array */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="file-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'size',
            'ext',
            'created_at',
            'created_by',
            'uploaded_at',
            'uploaded_by',
        ],
    ]) ?>
    <?php foreach($line as $key): ?>
       <?= $key ?>
    <?php endforeach; ?>
   

</div>
