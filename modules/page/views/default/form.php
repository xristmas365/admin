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

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->isNewRecord ? 'New Page' : $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = ActiveForm::begin() ?>
<div class="card user-card">
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
            <?= Html::submitButton('<i class="fas fa-pencil-ruler"></i> Save as Draft', ['class' => 'btn btn-white mr-2']) ?>
            <?= Html::submitButton('<i class="fas fa-check-double"></i> Publish', ['class' => 'btn btn-white']) ?>
        </div>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
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
        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

