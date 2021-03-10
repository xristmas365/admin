<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use app\modules\user\models\User;
use app\modules\admin\widgets\Menu;

/**
 * @var $user User
 */
$user = Yii::$app->user->identity;

?>
<aside class="aside aside-fixed shadow">
    <div class="aside-header">
        <a href="<?= Url::home() ?>" class="aside-logo"><i class="fas fa-code"></i> <?= Yii::$app->name ?></a>
        <a href="" class="aside-menu-link">
            <i data-feather="menu"></i>
            <i data-feather="x"></i>
        </a>
    </div>
    <div class="aside-body">
        <div class="aside-loggedin shadow">
            <a href="<?= Url::toRoute(['/user/default/account']) ?>" class="avatar"><img src="<?= $user->image ?>" alt=""></a>
        </div>
        <div class="aside-loggedin-user">
            <span class="d-flex align-items-center justify-content-between mg-b-2">
                <h6 class="tx-semibold mg-b-0 text-uppercase"><?= $user->name ?></h6>
            </span>
            <p class="tx-color-03 tx-12 mg-b-0"><?= $user->roleValue ?></p>
        </div>
        <?= Menu::widget(['items' => require Yii::getAlias('@config/menu.php')]) ?>
    </div>
</aside>
