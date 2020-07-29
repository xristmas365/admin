<?php
/**
 * _top.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="content-header">
    <div class="content-search">
        <i data-feather="search"></i>
        <input type="search" class="form-control" placeholder="Search...">
    </div>
    <nav class="nav">
        <a href="<?= Url::toRoute(['/user/auth/logout']) ?>" class="nav-link" data-confirm="Are you sure you want to exit?"><i data-feather="log-out"></i></a>
    </nav>
</div>
