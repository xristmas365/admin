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
use app\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use app\modules\store\assets\CartAsset;

/**
 * @var $this    View
 * @var $content string
 */

AppAsset::register($this);
CartAsset::register($this);

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
<?= $this->render('@app/views/layouts/_header') ?>
<div class="main">
    <?= $this->render('@app/views/layouts/_cart') ?>
    <div class="container py-5">
        <h2><?= $this->title ?></h2>
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Home', 'url' => ['/site/index']],
            'links'    => $this->params['breadcrumbs'] ?? [],
            'options'  => ['class' => 'breadcrumb bg-white pl-0 pt-0'],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
