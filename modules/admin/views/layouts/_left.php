<?php
/**
 * _left.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\admin\widgets\Menu;

if(Yii::$app->controller->action->id === 'create' || Yii::$app->controller->action->id === 'update') {
    $icon = 'edit';
} else {
    $icon = ArrayHelper::getValue($this->params, 'icon', 'home');
}

?>
<aside class="aside aside-fixed">
    <div class="aside-header">
        <a href="<?= Url::home() ?>" class="aside-logo">AX<span>basic</span></a>
        <a href="" class="aside-menu-link">
            <i data-feather="menu"></i>
            <i data-feather="x"></i>
        </a>
    </div>
    <div class="aside-body">
        <div class="aside-loggedin">
            <div class="d-flex align-items-center justify-content-start">
                <a href="" class="avatar"><img src="<?= Yii::$app->user->identity->image ?>" class="rounded-circle" alt=""></a>
                <div class="aside-alert-link">
                    <a href="" data-toggle="tooltip" title="Sign out"><i data-feather="help-circle"></i></a>
                </div>
            </div>
            <div class="aside-loggedin-user">
                <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">
                    <h6 class="tx-semibold mg-b-0"><?= Yii::$app->user->identity->name ?></h6>
                    <i data-feather="chevron-down"></i>
                </a>
                <p class="tx-color-03 tx-12 mg-b-0"><?= Yii::$app->user->identity->roleValue ?></p>
            </div>
            <div class="collapse" id="loggedinMenu">
                <ul class="nav nav-aside mg-b-0">
                    <li class="nav-item"><a href="<?= Url::toRoute(['/user/default/account']) ?>" class="nav-link"><i data-feather="user"></i> <span>Account</span></a></li>
                    <li class="nav-item"><a href="<?= Url::toRoute(['/user/auth/logout']) ?>" class="nav-link"><i data-feather="log-out"></i> <span>Exit</span></a></li>
                </ul>
            </div>
        </div>
        <?= Menu::widget(['items' => require Yii::getAlias('@config/menu.php')]) ?>
        <div class="bg-icon text-center">
            <i data-feather="<?= $icon ?>" width="220" height="220"></i>
            <span class="text-uppercase"><?= $this->title ?></span>
        </div>
    </div>
</aside>
