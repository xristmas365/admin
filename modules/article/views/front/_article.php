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
use app\modules\article\models\Article;

/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

/**
 * @var $this  View
 * @var $model Article
 */

?>
<div class="card mb-3 shadow">
    <img src="<?= $model->image ?>" class="card-img-top" alt="...">
    <div class="card-body">
        <small class="text-muted"><?= $model->topic->name ?></small>
        <h5 class="card-title"><?= Html::a($model->title, ['/article/front/article', 'slug' => $model->slug], [
                'class'     => 'stretched-link',
                'style'     => 'text-decoration:none; color:#000',
                'data-pjax' => 0,
            ]) ?></h5>
        <p class="card-text"><small class="text-muted">Published <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></small></p>
    </div>
</div>



