<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

use yii\web\View;
use app\modules\article\models\Article;

/**
 * @var $this    View
 * @var $article Article
 */

?>
<h1><?= $article->title ?></h1>
<div class="content">
    <?= $article->content ?>
</div>
