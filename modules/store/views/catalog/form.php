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

$this->title = $model->isNewRecord ? 'New Catalog' : $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Catalogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'server'

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
        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Catalog Name']) ?>
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Save', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
