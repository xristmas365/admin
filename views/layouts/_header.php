<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use app\modules\page\models\Page;

?>
<?php NavBar::begin([
    'brandLabel'      => Yii::$app->name,
    'options'         => ['class' => 'navbar navbar-dark navbar-expand-lg sticky-top shadow', 'style' => 'background-color:#40425f'],
    'collapseOptions' => ['class' => 'collapse navbar-collapse'],
]) ?>
<div class="m-auto"></div>
<?php

$pages = Page::find()->select(['slug', 'title'])->where(['draft' => false])->asArray()->all();
$pageItems = [];
if($pages) {
    $pageItemsList = [];
    foreach($pages as $page) {
        $pageItemsList[] = [
            'label' => $page['title'],
            'url'   => Url::toRoute(['/page/front/view', 'slug' => $page['slug']]),
        ];
    }
    $pageItems = [
        [
            'label' => 'Pages',
            'url'   => ['#'],
            'items' => $pageItemsList,
        ],
    ];
}

$defaultItems = [
    [
        'label' => '<i class="fas fa-home"></i> Home',
        'url'   => ['/site/index'],
    ],
    [
        'label' => '<i class="fas fa-newspaper"></i> Articles',
        'url'   => ['/article/front/index'],
    ],
    [
        'label' => '<i class="fas fa-store"></i> Products',
        'url'   => ['/store/front/index'],
    ],
    [
        'label'       => '<i class="fas fa-shopping-cart"></i> Cart',
        'url'         => null,
        'linkOptions' => [
            'id'    => 'sidebarCollapse',
            'style' => 'cursor:pointer',
        ],
    ],
];

$authItems = [
    [
        'visible' => !Yii::$app->user->isGuest,
        'label'   => 'Dashboard',
        'items'   => [
            [
                'label' => 'Dashboard',
                'url'   => ['/admin/default/index'],
            ],
            [
                'label' => 'Account',
                'url'   => ['/user/default/account'],
            ],
            '<div class="dropdown-divider"></div>',
            [
                'label' => 'Logout',
                'url'   => ['/user/auth/logout'],
            ],
        ],
    ],
    [
        'label'   => '<i class="fas fa-user"></i> Login',
        'url'     => ['/user/auth/login'],
        'visible' => Yii::$app->user->isGuest,
    ],
    [
        'label'   => '<i class="fas fa-user-plus"></i> Register',
        'url'     => ['/user/auth/register'],
        'visible' => Yii::$app->user->isGuest,
    ],
];

$items = array_merge($defaultItems, $pageItems, $authItems);

echo Nav::widget([
    'encodeLabels'    => false,
    'options'         => ['class' => 'navbar-nav'],
    'activateParents' => true,
    'items'           => $items,
]);
?>

<?php NavBar::end() ?>
