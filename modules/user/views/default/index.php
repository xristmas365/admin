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

use kartik\grid\BooleanColumn;
use app\modules\user\models\User;
use app\modules\user\models\UserSearch;
use app\modules\admin\widgets\grid\AdminGrid;

/* @var $this yii\web\View */
/* @var $searchModel UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'users';

?>

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        AdminGrid::COLUMN_SERIAL,
        'email:email',
        [
            'attribute' => 'first_name',
            'format'    => 'raw',
            'label'     => 'Name',
            'value'     => function(User $model)
            {
                return $model->id === Yii::$app->user->id ? '<strong>' . $model->name . ' (you)</strong>' : $model->name;
            },
        ],
        [
            'class'     => BooleanColumn::class,
            'attribute' => 'blocked',
        ],
        [
            'class'     => BooleanColumn::class,
            'attribute' => 'confirmed',
        ],
        [
            'attribute' => 'role',
            'value'     => 'roleValue',
            'filter'    => User::roleList(),
        ],
        [
            'attribute'           => 'created_at',
            'format'              => 'date',
            'filterType'          => 'kartik\daterange\DateRangePicker',
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'locale'     => ['format' => 'M/D/Y'],
                    'autoWidget' => true,
                    'autoClose'  => true,
                ],
            ],
        ],
        'last_login_at:date',
        [
            'class'    => 'app\modules\admin\widgets\grid\ActionColumn',
            'template' => '<div class="d-flex actions justify-content-around"><span class="action-delete">{delete}</span></div>',
        ],
    ],
]); ?>
