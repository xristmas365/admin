<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use app\modules\article\models\Article;

/**
 * @var $this    View
 * @var $article Article
 */
$this->title = $article->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['/article/front/index']];
$this->params['breadcrumbs'][] = ['label' => $article->title];
/**
 * Register SEO Keywords
 */
if($article->seo_keywords) {
    $this->registerMetaTag([
        'name'    => 'keywords',
        'content' => $article->seo_keywords,
    ]);
}

/**
 * Register SEO Description
 */
if($article->seo_description) {
    $this->registerMetaTag([
        'name'    => 'description',
        'content' => $article->seo_description,
    ]);
}
?>
<h1 class="text-center"><?= $article->title ?></h1>
<h6 class="text-center text-muted"><?= $article->description ?></h6>
<div class="content">
    <?= $article->content ?>
</div>
