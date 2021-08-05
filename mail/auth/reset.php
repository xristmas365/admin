<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

/**
 * @var $user User
 */

use yii\helpers\Html;
use app\modules\user\models\User;

?>
<h3>Hello, <?= $user->name ?></h3>
<h4>To crete new Password click the link below</h4>
<?= Html::a('New Password', $user->generateResetLink()) ?>
