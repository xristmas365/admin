<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

/* @var $this View */

/* @var $content string */

use yii\web\View;
use yii\helpers\Html;
use kartik\icons\Icon;
use kartik\dialog\Dialog;
use kartik\alert\AlertBlock;
use yii\bootstrap4\Breadcrumbs;
use app\modules\admin\assets\DashAsset;
use app\modules\admin\assets\CustomAsset;

Icon::map($this);
DashAsset::register($this);
CustomAsset::register($this);

echo Dialog::widget([
    'dialogDefaults' => [
        Dialog::DIALOG_CONFIRM => [
            'type'           => Dialog::TYPE_PRIMARY,
            'btnOKClass'     => 'btn-primary',
            'btnCancelClass' => 'btn-secondary',
            'closable'       => false,
        ],
    ],
]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik:300,400&display=swap">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= $this->render('_left') ?>
<div class="content">
    <div class="content-body">
        <div class="container-admin">
            <?= AlertBlock::widget(['type' => 'growl', 'delay' => 1000]) ?>
            <h3 class="tx-spacing--1"><i class="pb-1" data-feather="<?= $this->params['icon'] ?? 'box' ?>"></i> <?= $this->title ?></h3>
            <span class="tx-12 tx-color-03">
                <?= Breadcrumbs::widget([
                    'homeLink'           => ['label' => 'Dashboard', 'url' => ['/admin/default/index']],
                    'links'              => $this->params['breadcrumbs'] ?? [],
                    'tag'                => 'ol',
                    'options'            => ['class' => 'breadcrumb df-breadcrumbs mb-4'],
                    'itemTemplate'       => "<li class=\"breadcrumb-item\">{link}</li>\n",
                    'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
                ]) ?>
            </span>
            <?= $content ?>
        </div>
        <img src="/images/t.png" alt="" style="z-index:-1; height: 80%; width: auto;opacity: 0.1; position: fixed; right: 0; bottom: 0">
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
