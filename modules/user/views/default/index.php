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

use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\user\models\search\UserSearch;
use app\modules\admin\widgets\grid\SwitchColumn;

/* @var $this yii\web\View */
/* @var $searchModel UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'users';

?>

<?= AdminGrid::widget([
    'leftButtons' => [],
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        'id',
        'email:email',
        [
            'attribute' => 'first_name',
            'format'    => 'raw',
            'label'     => 'Name',
            'value'     => function(User $model)
            {
                if($model->id === Yii::$app->user->id) {
                    $value = '<strong>' . $model->name . ' (you)</strong>';
                } else {
                    $value = Html::a('<i class="fas fa-user-secret text-secondary"></i> ', ['/user/auth/switch', 'id' => $model->id], [
                            'data-pjax'    => 0,
                            'data-confirm' => 'Are You sure You want to become <strong>&#60;' . $model->name . '&#62;</strong>?' .
                                '<br> You can return in the <strong>left menu</strong>',
                        ]) . $model->name;
                }
                
                return $value;
            },
        ],
        [
            'class'     => SwitchColumn::class,
            'attribute' => 'blocked',
        ],
        [
            'class'     => SwitchColumn::class,
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
        [
            'attribute'           => 'last_login_at',
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
        //[
        //    'class'    => 'app\modules\admin\widgets\grid\ActionColumn',
        //    'template' => '<div class="d-flex actions justify-content-between px-2">{switch}<span class="action-delete">{delete}</span></div>',
        //    'buttons'  => [
        //        'switch' => function($url, $model)
        //        {
        //            return $model->id === Yii::$app->user->id ? null : Html::a(
        //                '<i class="fas fa-user-cog"></i>',
        //                ['/user/auth/switch', 'id' => $model->id],
        //                [
        //                    'data-pjax'    => 0,
        //                    'title'        => 'Switch to ' . $model->name,
        //                    'data-confirm' => 'Are You sure You want to become <strong>&#60;' . $model->name . '&#62;</strong>?' .
        //                        '<br> You can return in the <strong>left menu</strong>',
        //                ]);
        //        },
        //    ],
        //],
    ],
]); ?>
