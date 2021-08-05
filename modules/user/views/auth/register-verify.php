<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\modules\user\models\Register;

/**
 * @var $this    View
 * @var $model   Register
 */

$this->title = 'Verify Email';

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-signin']]) ?>
<h3 class="display-5 text-muted"><?= Html::a('Home', Url::home()) . ' / ' . $this->title ?></h3>
<p class="fs-5 text-muted">
    We sent an Email with a Link to Verify your <strong><?= $model->email ?></strong> account
</p>
<img class="mb-4" src="/images/t.png" alt="" width="100%">
<?php ActiveForm::end() ?>
