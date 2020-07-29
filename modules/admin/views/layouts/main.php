<?php
/**
 * main.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

/* @var $this View */

/* @var $content string */

use yii\web\View;
use yii\helpers\Html;
use kartik\icons\Icon;
use kartik\dialog\Dialog;
use yii\widgets\Breadcrumbs;
use kartik\alert\AlertBlock;
use app\modules\admin\assets\DashAsset;

Icon::map($this);
DashAsset::register($this);

echo Dialog::widget([
    'dialogDefaults' => [
        Dialog::DIALOG_CONFIRM => [
            'type'           => Dialog::TYPE_PRIMARY,
            'title'          => 'Confirmation',
            'btnOKClass'     => 'btn-white',
            'btnCancelClass' => 'btn-outline-danger',
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
<body class="pos-relative" data-spy="scroll" data-target="#navSection" data-offset="120">
<?php $this->beginBody() ?>
<?= $this->render('_left') ?>
<div class="content ht-100v pd-0">
    <?= $this->render('_top') ?>
    <div class="content-body">
        <div class="container-fluid">
            <?= AlertBlock::widget(['type' => 'growl', 'delay' => 1000]) ?>
            <?= Breadcrumbs::widget([
                'homeLink'           => ['label' => 'Dashboard', 'url' => ['/admin/default/index']],
                'links'              => $this->params['breadcrumbs'] ?? [],
                'tag'                => 'ol',
                'options'            => ['class' => 'breadcrumb df-breadcrumbs mg-b-10'],
                'itemTemplate'       => "<li class=\"breadcrumb-item\">{link}</li>\n",
                'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
            ]) ?>
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
