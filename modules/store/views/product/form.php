<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\tree\TreeViewInput;
use trntv\filekit\widget\Upload;
use extead\autonumeric\AutoNumeric;
use app\modules\store\models\Brand;
use app\modules\store\models\Catalog;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $model app\modules\store\models\Product */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'Register New Product' : $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(); ?>
<div class="container-admin shadow p-4">
    <div class="d-flex justify-content-between">
        <div class="text-heading mb-4"><?= $this->title ?></div>
        <div>
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white']) ?>
            <?= Html::a('<i class="fas fa-ban"></i> Cancel', ['index'], ['class' => 'btn btn-white']) ?>
            <?php if(!$model->isNewRecord) : ?>
                <?= Html::a('<div class="fas fa-trash"></div> Delete', ['delete', 'id' => $model->id], [
                    'class'        => 'btn btn-danger ml-2',
                    'data-confirm' => 'Are You sure you want to Delete?',
                    'data-method'  => 'POST',
                ]) ?>
            <?php endif ?></div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'title') ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'catalog_id')->widget(TreeViewInput::class, [
                        'query'            => Catalog::find()->addOrderBy('root, lft'),
                        'headingOptions'   => ['label' => 'Store'],
                        'rootOptions'      => ['label' => '<i class="fas fa-tree text-success"></i>'],
                        'fontAwesome'      => true,
                        'multiple'         => false,
                        'topRootAsHeading' => true,
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <?= $form->field($model, 'content')->widget(TinyMce::class, [
                'clientOptions' => [
                    'height'   => '700px',
                    'toolbar'  => "undo redo | code link table hr | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  ",
                    'branding' => false,
                    'plugins'  => [
                        "advlist autolink lists link charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table paste hr",
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-md-3 border-left">
            <?= $form->field($model, 'price', ['addon' => ['prepend' => ['content' => '<i class="fas fa-dollar-sign"></i>']]])->widget(AutoNumeric::class) ?>
            <?= $form->field($model, 'active')->checkbox(['custom' => true, 'switch' => true]) ?>
            <?= $form->field($model, 'new')->checkbox(['custom' => true, 'switch' => true]) ?>
            <?= $form->field($model, 'popular')->checkbox(['custom' => true, 'switch' => true]) ?>
            <?= $form->field($model, 'keywords')->textInput(['data-role' => 'tagsinput'])->hint('Use Commas To Separate Keywords') ?>
            <div class="d-flex justify-content-start align-content-end pt-2">
                <?= $form->field($model, 'files')->widget(Upload::class, [
                    'url'              => ['/storage/default/upload'],
                    'uploadPath'       => 'photo/',
                    'multiple'         => true,
                    'sortable'         => true,
                    'maxNumberOfFiles' => 50,
                ])->label('Images') ?>
            </div>
        </div>
    </div>
    <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white']) ?>
    <?= Html::a('<i class="fas fa-ban"></i> Cancel', ['index'], ['class' => 'btn btn-white']) ?>
    <?php if(!$model->isNewRecord) : ?>
        <?= Html::a('<div class="fas fa-trash"></div> Delete', ['delete', 'id' => $model->id], [
            'class'        => 'btn btn-danger ml-2',
            'data-confirm' => 'Are You sure you want to Delete?',
            'data-method'  => 'POST',
        ]) ?>
    <?php endif ?>
</div>
<?php ActiveForm::end(); ?>
