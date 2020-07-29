<?php
/**
 * form.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\tree\TreeViewInput;
use trntv\filekit\widget\Upload;
use extead\autonumeric\AutoNumeric;
use app\modules\store\models\Catalog;

/* @var $this yii\web\View */
/* @var $model app\modules\store\models\Product */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'New Product' : $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = ActiveForm::begin(); ?>
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-start">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Back', ['index'], ['class' => 'btn btn-white mr-4']) ?>
        </div>
        <div class="text-heading"><?= $this->title ?></div>
        <div class="d-flex justify-content-end">
            <?php if(!$model->isNewRecord) : ?>
                <?= Html::a('<div class="fas fa-trash"></div> Delete', ['delete', 'id' => $model->id], [
                    'class'        => 'btn btn-danger mr-2',
                    'data-confirm' => 'Are You sure you want to Delete?',
                    'data-method'  => 'POST',
                ]) ?>
            <?php endif ?>
            <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-white']) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-8">
                        <?= $form->field($model, 'title') ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'catalog_id')->widget(TreeViewInput::class, [
                            'query'          => Catalog::find()->addOrderBy('root, lft'),
                            'headingOptions' => ['label' => 'Store'],
                            'rootOptions'    => ['label' => '<i class="fas fa-tree text-success"></i>'],
                            'fontAwesome'    => true,
                            'multiple'       => false,
                            'topRootAsHeading'     => true,
                        ]) ?>
                    </div>
                </div>
                <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2 border-left">
                <?= $form->field($model, 'price')->widget(AutoNumeric::class) ?>
                <?= $form->field($model, 'active')->checkbox() ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'new')->checkbox() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'popular')->checkbox() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start align-content-end border-top pt-2">
            <?= $form->field($model, 'files')->widget(Upload::class, [
                'url'        => ['/storage/default/upload'],
                'uploadPath' => 'photo/',
                'multiple'   => true,
                'sortable'   => true,
                'maxNumberOfFiles'   => 5,
            ])->label('Images') ?>
        </div>
        <?= $form->field($model, 'content')->widget(TinyMce::class, [
            'clientOptions' => [
                'height'   => '700px',
                'toolbar'  => "undo redo | code link table hr | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  ",
                'branding' => false,
                'plugins'  => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste hr",
                ],
            ],
        ]) ?>
        <?= $form->field($model, 'keywords') ?>
    </div>
</div>
<?php ActiveForm::end(); ?>






