<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
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
