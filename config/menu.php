<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use app\modules\user\models\Role;

$customer = Yii::$app->user->can(Role::CUSTOMER);
$user = Yii::$app->user->can(Role::USER);
$admin = Yii::$app->user->can(Role::ADMIN);
$developer = Yii::$app->user->can(Role::DEVELOPER);

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
        'label' => '<i data-feather="user"></i> <span>Profile</span>',
        'url'   => '#',
        'items' => [
            [
                'label' => ' - My Account',
                'url'   => ['/user/default/account'],
            ],
            [
                'label' => ' - Password',
                'url'   => ['/user/default/password'],
            ],
        ],
    ],
    [
        'label' => '<i data-feather="credit-card"></i> <span>Payments</span>',
        'url'   => '#',
        'items' => [
            [
                'label' => ' - History',
                'url'   => ['/user/payment/index'],
            ],
            [
                'label' => ' - Cards',
                'url'   => ['/user/payment/card'],
            ],
        ],
    ],
    [
        'label'   => 'Store',
        'visible' => $user,
    ],
    [
        'label'   => '<i data-feather="server"></i> <span>Catalogs</span>',
        'url'     => ['/store/catalog/index'],
        'visible' => $user,
    ],
    [
        'label'   => '<i data-feather="shopping-bag"></i> <span>Products</span>',
        'url'     => ['/store/product/index'],
        'visible' => $user,
    ],
    [
        'label' => '<i data-feather="shopping-cart"></i> <span>Orders</span>',
        'url'   => ['/store/order/index'],
    ],
    [
        'label'   => '<i data-feather="trending-up"></i> <span>Coupons</span>',
        'url'     => ['/store/coupon/index'],
        'visible' => $admin,
    ],
    [
        'label'   => '<i data-feather="truck"></i> <span>Warehouse</span>',
        'url'     => ['/warehouse/default/index'],
        'visible' => $user,
    ],
    [
        'label'   => 'Content',
        'visible' => $admin,
    ],
    [
        'label'   => '<i data-feather="file-text"></i> <span>Pages</span>',
        'url'     => ['/page/default/index'],
        'visible' => $admin,
    ],
    [
        'label'   => '<i data-feather="cast"></i> <span>Article Feed</span>',
        'url'     => ['#'],
        'visible' => $admin,
        'items'   => [
            [
                'label' => ' - Articles',
                'url'   => ['/article/default/index'],
            ],
            [
                'label' => ' - Topics',
                'url'   => ['/article/topic/index'],
            ],
        ],
    ],
    [
        'label'   => 'Admin Tools',
        'visible' => $admin,
    ],
    [
        'label'   => '<i data-feather="users"></i> <span>Users</span>',
        'url'     => ['/user/default/index'],
        'visible' => $admin,
    ],
    [
        'label'   => '<i data-feather="mail"></i> <span>Emails</span>',
        'url'     => ['/email/template/index'],
        'visible' => $admin,
    ],
    [
        'label'   => '<i data-feather="layers"></i> <span>Error Log</span>',
        'url'     => ['/admin/log/index'],
        'visible' => $developer,
    ],
    [
        'label'   => '<i data-feather="database"></i> <span>Storage</span>',
        'url'     => ['/admin/file/storage'],
        'visible' => $developer,
    ],
    [
        'label'   => '<i data-feather="folder"></i> <span>Files</span>',
        'url'     => ['/file/default/index'],
        'visible' => $developer,
    ],
    [
        'label'   => '<i data-feather="code"></i> <span>GII</span>',
        'url'     => ['/gii'],
        'visible' => $developer,
    ],
];
