<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
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
            <a href="<?= Url::toRoute(['/user/default/account']) ?>" class="avatar"><img src="<?= Yii::$app->user->identity->image ?>" alt=""></a>
        </div>
        <?= Menu::widget(['items' => require Yii::getAlias('@config/menu.php')]) ?>
    </div>
</aside>
