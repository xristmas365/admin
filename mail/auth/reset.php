<?php
/**
 * reset.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
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
