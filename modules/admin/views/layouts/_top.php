<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use yii\bootstrap4\Breadcrumbs;

?>
<div class="content-header shadow">
    <nav class="nav"></nav>
    <div class="content-search">
        <?= Breadcrumbs::widget([
            'homeLink'           => ['label' => 'Dashboard', 'url' => ['/admin/default/index']],
            'links'              => $this->params['breadcrumbs'] ?? [],
            'tag'                => 'ol',
            'options'            => ['class' => 'breadcrumb df-breadcrumbs font-weight-bold'],
            'itemTemplate'       => "<li class=\"breadcrumb-item\">{link}</li>\n",
            'activeItemTemplate' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
        ]) ?>
    </div>

    <nav class="nav">
        <a href="<?= Url::toRoute(['/user/auth/logout']) ?>" class="nav-link" data-confirm="Are you sure you want to exit?"><i data-feather="log-out"></i></a>
    </nav>
</div>
