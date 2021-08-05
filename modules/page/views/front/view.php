<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use app\modules\page\models\Page;

/**
 * @var $this    View
 * @var $page    Page
 */
$this->title = $page->title;
$this->params['breadcrumbs'][] = ['label' => $page->title];

/**
 * Register SEO Keywords
 */
if($page->seo_keywords) {
    $this->registerMetaTag([
        'name'    => 'keywords',
        'content' => $page->seo_keywords,
    ]);
}

/**
 * Register SEO Description
 */
if($page->seo_description) {
    $this->registerMetaTag([
        'name'    => 'description',
        'content' => $page->seo_description,
    ]);
}

?>
<h1 class="text-center"><?= $page->title ?></h1>
<h6 class="text-center text-muted"><?= $page->description ?></h6>
<div class="content">
    <?= $page->content ?>
</div>
