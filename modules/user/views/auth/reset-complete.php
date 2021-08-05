<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
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
