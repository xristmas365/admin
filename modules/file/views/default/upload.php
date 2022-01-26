<?php
/**
 * @author    Ann Kononovich <anna.kononovich@gmail.com>
 * @package   Admin AX project
 * @version   2.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\file\models\File */

$this->title = 'Create File';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
