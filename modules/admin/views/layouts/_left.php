<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\admin\widgets\Menu;

/**
 * @var $user User
 */
$user = Yii::$app->user->identity;

?>
<aside class="aside aside-fixed shadow">
    <div class="aside-header">
        <a href="<?= Url::home() ?>" class="aside-logo"><?= Yii::$app->name ?></a>
        <a href="" class="aside-menu-link">
            <i data-feather="menu"></i>
            <i data-feather="x"></i>
        </a>
    </div>
    <div class="aside-body">
        <div class="aside-loggedin">
            <a href="<?= Url::toRoute(['/user/default/account']) ?>" class="avatar"><img src="/images/t.png" alt=""></a>
        </div>
        <?= Menu::widget(['items' => require Yii::getAlias('@config/menu.php')]) ?>
        <?= Html::beginForm(['/user/auth/logout']) ?>
        <?= Html::submitButton('Logout', ['class' => 'btn btn-light btn-block', 'data-confirm'=> 'Are You Sure?']) ?>
        <?= Html::endForm() ?>
    </div>
</aside>
