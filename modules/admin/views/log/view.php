<?php
/**
 * view.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Log */

$this->title = $model->logName;
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="log-view">
	
	<?= DetailView::widget([
		'model'      => $model,
		'attributes' => [
			'id',
			'levelName',
			'category',
			'log_time:datetime',
			'prefix:ntext',
			'message:ntext',
		],
	]) ?>

</div>
