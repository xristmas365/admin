<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use app\modules\user\models\User;
use app\modules\admin\widgets\Dashboard;

$this->title = 'Dashboard';
$this->params['icon'] = 'box';
?>
<h3 class="mb-3">Welcome, <?= Yii::$app->user->identity->name ?>!</h3>
<?php if(Yii::$app->user->identity->role === User::ROLE_USER): ?>
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

<?php if(Yii::$app->user->can(User::ROLE_ADMIN)): ?>
    <?= Dashboard::widget([
        'items' => [
            [
                [
                    'title'       => 'Products',
                    'url'         => ['/store/product/index'],
                    'description' => 'Click here to view/edit the Products in the database',
                    'icon'        => 'shopping-bag',
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
                ],
                [
                    'title'       => 'Pages',
                    'url'         => ['/article/section/index'],
                    'description' => 'Click here to view/edit Pages',
                    'icon'        => 'file-text',
                ],
            ],
            [
                [
                    'title'       => 'Users',
                    'url'         => ['/user/default/index'],
                    'description' => 'Click here to manage Users in the database',
                    'icon'        => 'users',
                ],
            ],
        ],
    ]) ?>
<?php endif ?>
<?php if(Yii::$app->user->can(User::ROLE_DEVELOPER)) : ?>
    <?= Dashboard::widget([
        'items' => [
            [
                [
                    'title'       => 'Error Logs',
                    'url'         => ['/admin/log/index'],
                    'description' => 'Click here to view App Logs',
                    'icon'        => 'layers',
                ],
                [
                    'title'       => 'GII',
                    'url'         => ['/gii'],
                    'description' => 'Click here generate PHP Code',
                    'icon'        => 'code',
                ],
            ],
        ],
    ]) ?>
<?php endif ?>
