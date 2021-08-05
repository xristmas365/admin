<?php

use yii\web\View;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use app\modules\storage\models\StorageSearch;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

/**
 * @var $this         View
 * @var $searchModel  StorageSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = 'Storage';
$this->params['breadcrumbs'][] = 'Storage';
$this->params['icon'] = 'database';
Pjax::begin(['id' => 'w0-pjax']);
echo $this->render('_search', ['model' => $searchModel]);
?>
<?= AdminGrid::widget([
    'pjax'         => false,
    'dataProvider' => $dataProvider,
    'columns'      => [
        'id',
        'model_name',
        'model_id',
        'path',
        'type',
        'size:shortSize',
        'name',
        'created_at:date',
        [
            'class' => ActionColumn::class,
            'template' => '{delete}'
        ],
    ],
]);

Pjax::end();

?>
