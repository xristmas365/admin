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

/**
 * @var $this   View
 */

$this->title = 'Password Saved';

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-signin']]) ?>
<h3 class="display-5 text-muted"><?= Html::a('Home', Url::home()) . ' / ' . $this->title ?></h3>
<p class="fs-5 text-muted">
    Congratulations! Your New Password Saved Successfully. You can&nbsp;<?= Html::a('Login', ['/user/auth/login']) ?> with the new Credentials.
</p>
<img class="mb-4" src="/images/t.png" alt="" width="100%">
<?= Html::a('Login', ['/user/auth/login'], ['class' => 'btn btn-primary btn-block']) ?>

<?php ActiveForm::end() ?>
