<?php
/**
 * reset-complete.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\web\View;
use app\modules\user\models\Reset;

/**
 * @var $this   View
 * @var $model  Reset
 */

$this->title = 'Reset Password';

?>
<h4>We sent an Email to <?= $model->email ?></h4>
