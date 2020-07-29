<?php
/**
 * menu.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use app\modules\user\models\User;

return [
    [
        'label' => '<i data-feather="box"></i> <span>Dashboard</span>',
        'url'   => ['/admin/default/index'],
    ],
    [
        'label' => '<i data-feather="shopping-bag"></i> <span>Products</span>',
        'url'   => ['/store/product/index'],
    ],
    [
        'label' => '<i data-feather="server"></i> <span>Catalogs</span>',
        'url'   => ['/store/catalog/index'],
    ],
    [
        'label'   => '<i data-feather="file-text"></i> <span>Pages</span>',
        'url'     => ['/page/default/index'],
        'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
    ],
    [
        'label'   => '<i data-feather="users"></i> <span>Users</span>',
        'url'     => ['/user/default/index'],
        'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
    ],
    [
        'label'   => '<i data-feather="layers"></i> <span>Error Log</span>',
        'url'     => ['/admin/log/index'],
        'visible' => Yii::$app->user->can(User::ROLE_ADMIN),
    ],
];
