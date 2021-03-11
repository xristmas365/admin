<?php
/**
 * main.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap4\NavBar;

/**
 * @var $this    View
 * @var $content string
 */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php NavBar::begin([
    'brandLabel'           => 'NavBar Test',
    'brandImage'           => '/favicon.ico',
    'renderInnerContainer' => false,
    'options'              => [
        'class' => 'navbar navbar-expand-lg shadow p-1 z-index-2',
    ],
    'collapseOptions'      => [
        'class' => 'd-flex justify-content-end mx-5',
    ],
]) ?>
<?= Html::a('Home', Url::home(), ['class' => 'btn btn-secondary']) ?>
<?php if(Yii::$app->user->isGuest): ?>
    <?= Html::a('Register', ['/user/auth/register'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Login', ['/user/auth/login'], ['class' => 'btn btn-primary']) ?>
<?php else: ?>
    <?= Html::a('Dashboard', ['/admin/default/index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Logout', ['/user/auth/logout'], ['class' => 'btn btn-primary']) ?>
<?php endif ?>
<?php NavBar::end() ?>
<div class="app">
    <img src="/images/bg.webp" class="blur" alt="">
    <div class="z-index-2 w-100 text">
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
