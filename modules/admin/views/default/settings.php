<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

use yii\web\View;
use yii\helpers\Html;
use yii\base\DynamicModel;
use kartik\form\ActiveForm;

/**
 * @var $this     View
 * @var $settings DynamicModel
 */

$this->title = 'Settings';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin() ?>
<div class="container-admin shadow p-4">
    <div class="text-heading mb-4"><?= $this->title ?></div>
    <?php foreach($settings->attributes as $attribute => $value): ?>
        <?= $form->field($settings, $attribute) ?>
    <?php endforeach ?>
    
    
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>
