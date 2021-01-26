<?php

use yii\web\View;
use yii\helpers\Html;
use app\modules\article\models\Section;

/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

/**
 * @var $this  View
 * @var $model Section
 */

?>
<div class="card">
    <div class="card-header">
        <?= $model->name ?>
    </div>
    <div class="card-body">
        <?= Html::a(Html::img($model->image), ['/article/front/section', 'slug' => $model->slug], ['data-pjax' => 0]) ?>
    </div>
</div>

