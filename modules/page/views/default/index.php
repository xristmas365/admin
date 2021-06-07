<?php
/**
 * index.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use kartik\grid\CheckboxColumn;
use app\modules\admin\widgets\grid\AdminGrid;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\page\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pages';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'file-text'
?>


<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'class' => CheckboxColumn::class,
        ],
        'title',
        'created_at',
        'created_by',
        'slug',
        'draft:boolean',
    ],
]) ?>

