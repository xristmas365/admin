<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

use yii\web\View;
use yii\helpers\Html;
use app\modules\article\models\Article;

/**
 * @var $this  View
 * @var $model Article
 */
?>
<div class="card">
    <div class="card-header">
        <?= $model->title ?>
    </div>
    <div class="card-body">
        <?= Html::a(Html::img($model->image), ['/article/front/article', 'slug' => $model->slug], ['data-pjax' => 0]) ?>
    </div>
</div>
