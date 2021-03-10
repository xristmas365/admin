<?php
/**
 * menu.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use app\modules\user\models\User;

return [
    [
        'label'   => 'Account Identity',
        'visible' => Yii::$app->session->has('admin_id'),
    ],
    [
        'label'   => '<i data-feather="user-x"></i> <span> Back to ' . Yii::$app->session->get('admin_name') . '</span>',
        'url'     => ['/user/auth/switch-back', 'id' => Yii::$app->session->get('admin_id')],
        'visible' => Yii::$app->session->has('admin_id'),
    ],
    [
        'label'   => '',
        'visible' => Yii::$app->session->has('admin_id'),
    ],
    ['label' => 'Dashboard'],
    [
        'label' => '<i data-feather="box"></i> <span>Dashboard</span>',
        'url'   => ['/admin/default/index'],
    ],
    [
        'label' => '<i data-feather="user"></i> <span>Account</span>',
        'url'   => ['/user/default/account'],
    ],
    ['label' => 'Store'],
    [
        'label' => '<i data-feather="shopping-bag"></i> <span>Products</span>',
        'url'   => ['/store/product/index'],
    ],
    [
        'label' => '<i data-feather="server"></i> <span>Catalogs</span>',
        'url'   => ['/store/catalog/index'],
    ],
    ['label' => 'Content', 'visible' => Yii::$app->user->can(User::ROLE_ADMIN),],
    [
        'label'   => '<i data-feather="file-text"></i> <span>Pages</span>',
        'url'     => ['/page/default/index'],
        'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
    ],
    [
        'label'   => '<i data-feather="cast"></i> <span>Articles</span>',
        'url'     => ['/article/default/index'],
        'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
    ],
    [
        'label'   => 'Admin Tools',
        'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
    ],
    [
        'label'   => '<i data-feather="users"></i> <span>Users</span>',
        'url'     => ['/user/default/index'],
        'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
    ],
    [
        'label'   => 'DEV Tools',
        'visible' => Yii::$app->user->can(User::ROLE_DEVELOPER),
    ],
    [
        'label'   => '<i data-feather="layers"></i> <span>Error Log</span>',
        'url'     => ['/admin/log/index'],
        'visible' => Yii::$app->user->can(User::ROLE_DEVELOPER),
    ],
    [
        'label'   => '<i data-feather="code"></i> <span>GII</span>',
        'url'     => ['/gii'],
        'visible' => Yii::$app->user->can(User::ROLE_DEVELOPER),
    ],
];
