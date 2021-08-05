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
use app\assets\MasonryAsset;
use yii\bootstrap4\Breadcrumbs;

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

<?= $this->render('@app/views/layouts/_header') ?>
<div class="main">
    <div class="container mt-4">
        <h2><?= $this->title ?></h2>
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Home', 'url' => ['/admin/default/index']],
            'links'    => $this->params['breadcrumbs'] ?? [],
            'options'  => ['class' => 'breadcrumb bg-white pl-0 pt-0'],
            //'itemTemplate'       => "<li class=\"breadcrumb-item\">{link}</li>\n",
            //'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
        ]) ?>
    </div>
    <div class="container-fluid py-5">
        <?= $content ?>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
