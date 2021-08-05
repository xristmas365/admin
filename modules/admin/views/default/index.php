<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use app\modules\user\models\Role;
use app\modules\admin\widgets\Dashboard;

$this->title = 'Dashboard';
$this->params['description'] = 'The Main Page';
?>
<?php if(Yii::$app->user->identity->role === Role::USER): ?>
    <?= Dashboard::widget([
        'items' => [
            [
                [
                    'title'       => 'My Registered Products',
                    'url'         => ['/store/product/index'],
                    'description' => 'Click here to view/edit the products you have already registered in our database',
                    'icon'        => 'shopping-bag',
                ],
                [
                    'title'       => 'Register a New Product',
                    'url'         => ['/store/product/create'],
                    'description' => 'Register a New Product',
                    'icon'        => 'edit',
                ],
            ],
        ],
    ]) ?>
<?php endif ?>
<?php if(Yii::$app->user->can(Role::ADMIN)): ?>
    <?= Dashboard::widget([
        'columnClass' => 'col-lg-6',
        'items'       => [
            [
                [
                    'title'       => 'Products',
                    'url'         => ['/store/product/index'],
                    'description' => 'Click here to view/edit the Products in the database',
                    'icon'        => 'shopping-bag',
                    'bg'          => '#e4e5ec',
                    'color'       => '#2a3176',
                ],
                [
                    'title'       => 'Product Catalogs',
                    'url'         => ['/store/catalog/index'],
                    'description' => 'Click here to register the product catalog in the database',
                    'icon'        => 'server',
                ],
            ],
            [
                [
                    'title'       => 'Articles',
                    'url'         => ['/article/default/index'],
                    'description' => 'Click here to view/edit the Articles in the database',
                    'icon'        => 'file-text',
                    'bg'          => '#f5f5f5',
                ],
                [
                    'title'       => 'Pages',
                    'url'         => ['/page/default/index'],
                    'description' => 'Click here to view/edit Pages',
                    'icon'        => 'file-text',
                    'bg'          => '#f5f5f5',
                ],
            ],
            [
                [
                    'title'       => 'Users',
                    'url'         => ['/user/default/index'],
                    'description' => 'Click here to manage Users in the database',
                    'icon'        => 'users',
                    'bg'          => '#fcfcff',
                ],
            ],
        ],
    ]) ?>
<?php endif ?>
