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
use app\modules\user\models\ChangePassword;

/**
 * @var      $this  View
 * @var      $model ChangePassword
 * @var      $form  ActiveForm
 */

$this->title = 'New Password for '. $model->user->name;
$this->params['breadcrumbs'][] = ['label' => 'account', 'url' => ['update', 'id' => $model]];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin([
    'type'       => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => 2],
]); ?>
<?= Html::a('<i class="fas fa-arrow-left"></i> Account', ['update', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-light']) ?>
<div class="my-3"></div>
<div class="card shadow">
    <div class="card-header d-flex justify-content-center">
        <div class="text-uppercase font-weight-bold" style="color:#596882"><?= $this->title ?></div>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'new_password')->passwordInput() ?>
        <?= $form->field($model, 'new_password_confirm')->passwordInput() ?>
        <?= Html::submitButton('<i class="fas fa-cloud-upload-alt"></i> Set New Password', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

