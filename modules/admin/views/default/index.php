<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   NACR project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use app\modules\user\models\User;

$this->title = 'Dashboard';
$this->params['icon'] = 'box';
?>
<h3 class="mb-3">Welcome, <?= Yii::$app->user->identity->name ?>!</h3>
<?php if(Yii::$app->user->identity->role === User::ROLE_USER): ?>
    <div class="row mb-4">
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/store/product/index']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="shopping-bag"></i>
                        </div>
                        <div>
                            <h4>My Registered Products</h4>
                            <p class="m-0">Click here to view/edit the products you have already registered in our database</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>My registered products</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/store/product/create']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="edit"></i>
                        </div>
                        <div>
                            <h4>Register a New Product</h4>
                            <p class="m-0">Click here to register the product in our database</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>Register a new product</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
    </div>
<?php endif ?>

<?php if(Yii::$app->user->can(User::ROLE_ADMIN)): ?>
    <div class="row mb-4">
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/store/product/index']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="shopping-bag"></i>
                        </div>
                        <div>
                            <h4>Products</h4>
                            <p class="m-0">Click here to view/edit the products you have already registered in the database</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>Registered products</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/store/catalog/index']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="server"></i>
                        </div>
                        <div>
                            <h4>Product Catalogs</h4>
                            <p class="m-0">Click here to register the product catalog in the database</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>Registered Product Catalogs</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/article/default/index']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="file-text"></i>
                        </div>
                        <div>
                            <h4>Articles</h4>
                            <p class="m-0">Click here to view/edit the Articles in the database</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>Articles</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/article/section/index']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="file-text"></i>
                        </div>
                        <div>
                            <h4>Pages</h4>
                            <p class="m-0">Click here to view/edit Pages</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>Pages</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/store/barcode/index']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="users"></i>
                        </div>
                        <div>
                            <h4>Users</h4>
                            <p class="m-0">Click here to manage Users in the database</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>Active Users</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
    </div>
<?php endif ?>
<?php if(Yii::$app->user->can(User::ROLE_DEVELOPER)) : ?>
    <div class="row mb-4">
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/admin/log/index']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="layers"></i>
                        </div>
                        <div>
                            <h4>Error Log</h4>
                            <p class="m-0">Click here to view App Logs</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>Errors Log</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
        <div class="col-lg-4">
            <a href="<?= Url::toRoute(['/gii']) ?>" class="dashboard-card shadow">
                <div class="dashboard-card-body">
                    <div class="d-flex align-items-center">
                        <div class="dashboard-card-icon">
                            <i data-feather="code"></i>
                        </div>
                        <div>
                            <h4>GII</h4>
                            <p class="m-0">Click here generate PHP Code</p>
                        </div>
                    </div>
                </div>
                <div class="dashboard-card-footer">
                    <span>GII generator</span> <i data-feather="chevron-right"></i>
                </div>
            </a>
        </div>
    </div>
<?php endif ?>
