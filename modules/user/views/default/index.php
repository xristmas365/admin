<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Html;
use app\modules\user\models\Role;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\user\models\search\UserSearch;
use app\modules\admin\widgets\grid\SwitchColumn;
use app\modules\admin\widgets\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['icon'] = 'users';

?>

<?= Html::a('<i class="fas fa-user-plus"></i> Register New User', ['create'], ['class' => 'btn btn-primary']) ?>

<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        AdminGrid::COLUMN_CHECKBOX,
        [
            'attribute' => 'name',
            'label'     => 'Name',
        ],
        'email',
        'zip',
        'state',
        'city',
        [
            'attribute' => 'role',
            'value'     => 'roleValue',
        ],
        [
            'attribute' => 'created_at',
            'format'    => 'date',
        ],
        [
            'attribute' => 'last_login_at',
            'format'    => 'relativeTime',
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
            'class'    => ActionColumn::class,
            'template' => "{update}{switch}",
            'hAlign'   => AdminGrid::ALIGN_LEFT,
            'buttons'  => [
                'switch' => function($url, $model)
                {
                    if($model->id === Yii::$app->user->id) {
                        return '';
                    }
                    
                    return Html::a('Login', ['/user/auth/switch', 'id' => $model->id], [
                        'class'        => 'border-left',
                        'data-pjax'    => 0,
                        'data-confirm' => 'Are You sure You want to become <strong>' . $model->name . '</strong> user?' .
                            '<br> You can return in the <strong>left menu</strong>',
                    ]);
                },
            ],
        ],
    ],
]); ?>
