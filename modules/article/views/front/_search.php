<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use kartik\form\ActiveForm;
use app\modules\article\models\search\ArticleSearch;

/**
 * @var $topics []
 * @var $model  ArticleSearch
 *
 */

?>
<div class="article-search border-bottom border-secondary">
    <?php $form = ActiveForm::begin([
        'id'      => 'article-search-form',
        'method'  => 'GET',
        'action'  => ['/article/front/index'],
        'options' => ['data-pjax' => 1],
    ]) ?>
    <div class="text-center">
    
    <?= $form->field($model, 'topic_id')->radioButtonGroup([0 => 'All'] + $topics, [
        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-light']],
    ])->label(false) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>

