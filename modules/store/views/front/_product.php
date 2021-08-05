<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Html;
use app\modules\store\models\Product;

/**
 * @var $model Product
 */

?>
<div class="card mb-3 shadow">
    <img src="<?= $model->image ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <small class="text-muted"><?= $model->catalog->name ?></small>
        <h5 class="card-title"><?= Html::a($model->title, ['/store/front/product', 'slug' => $model->slug], [
                'class'     => 'stretched-link',
                'style'     => 'text-decoration:none; color:#000',
                'data-pjax' => 0,
            ]) ?></h5>
        <p class="card-text"><span class="text-muted"><?= Yii::$app->formatter->asCurrency($model->price) ?></span></p>
    </div>
</div>
