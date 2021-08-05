<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\tinymce\TinyMce;
use trntv\filekit\widget\Upload;
use extead\autonumeric\AutoNumeric;
use app\modules\store\models\Product;

/**
 * @var $this         View
 * @var $model        Product
 * @var $form         ActiveForm
 * @var $rootCatalogs []
 */

$this->title = $model->isNewRecord ? 'New Product' : $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'shopping-bag'

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
        <?= $form->field($model, 'title')->textInput(['placeholder' => 'Product Title']) ?>
        
        <?= $form->field($model, 'catalog_id')->dropDownList($rootCatalogs, ['prompt' => 'Select Catalog']) ?>
        
        <?= $form->field($model, 'price')->widget(AutoNumeric::class, ['options' => ['placeholder' => 'Product Price']]) ?>
        <?= $form->field($model, 'description')->textInput(['placeholder' => 'Product Description']) ?>
        <div class="row">
            <div class="col-2">Flags</div>
            <div class="col"> <?= $form->field($model, 'active')->checkbox(['custom' => true, 'switch' => true]) ?></div>
            <div class="col"> <?= $form->field($model, 'new')->checkbox(['custom' => true, 'switch' => true]) ?></div>
            <div class="col"> <?= $form->field($model, 'popular')->checkbox(['custom' => true, 'switch' => true]) ?></div>
        </div>
        <?= $form->field($model, 'keywords')->textInput(['data-role' => 'tagsinput'])->hint('Use Commas To Separate Keywords') ?>
        <?= $form->field($model, 'content')->widget(TinyMce::class)->label('Content (HTML)') ?>
        <div class="row">
            <div class="col-2">Images</div>
            <div class="col-10">
                <div class="d-flex justify-content-start align-content-end pt-2">
                    <?= $form->field($model, 'files')->widget(Upload::class, [
                        'url'              => ['/storage/default/upload'],
                        'uploadPath'       => 'photo/',
                        'multiple'         => true,
                        'sortable'         => false,
                        'maxNumberOfFiles' => 50,
                    ])->label(false) ?>
                </div>
            </div>
        </div>
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>




