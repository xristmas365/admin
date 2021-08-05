<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model app\modules\article\models\Topic */
/* @var $form ActiveForm */

$this->title = $model->isNewRecord ? 'New Topic' : $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['/article/default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'bookmark'
?>
<?php $form = ActiveForm::begin([
    'type'       => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 1],
]); ?>
<div class="card shadow">
    <div class="card-header d-flex justify-content-center">
        <div class="text-uppercase font-weight-bold" style="color:#596882"><?= $this->title ?></div>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'name') ?>
        <div class="row">
            <div class="col-1">Visibility</div>
            <div class="col-1">
                <?= $form->field($model, 'home')->checkbox() ?>
                <?= $form->field($model, 'visible')->checkbox() ?>
            </div>
        </div>
        <?= $form->field($model, 'files')->widget(Upload::class, [
            'url'        => ['/storage/default/upload'],
            'uploadPath' => 'section/',
            'multiple'   => true,
        ])->label('Cover') ?>
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
</div>
<?php $form = ActiveForm::end() ?>
