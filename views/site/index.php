<?php
/**
 * index.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Congratulations!</h1>
        <p>IndustrialAX-powered Application.</p>
        <p>
            <?php if(Yii::$app->user->isGuest) : ?>
                <?= Html::a('Login', ['/user/auth/login'], ['class' => 'btn btn-primary']) ?>
            <?php else : ?>
                <?= Html::a('Dashboard', ['/admin/default/index'], ['class' => 'btn btn-primary']) ?>
            <?php endif ?>
        </p>
    </div>
</div>
