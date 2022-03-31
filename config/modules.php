<?php

/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

return [
    'gridview'    => 'kartik\grid\Module',
    'admin'       => 'app\modules\admin\Module',
    'user'        => 'app\modules\user\Module',
    'storage'     => 'app\modules\storage\Module',
    'store'       => 'app\modules\store\Module',
    'page'        => 'app\modules\page\Module',
    'article'     => 'app\modules\article\Module',
    'system'      => 'app\modules\system\Module',
    'warehouse'   => 'app\modules\warehouse\Module',
    'file'        => 'app\modules\file\Module',
    'email'       => 'app\modules\email\Module',
    'treemanager' => [
        'class'            => '\kartik\tree\Module',
        'treeViewSettings' => [
            'nodeView' => '@app/modules/store/views/catalog/form',
        ],
    ],
];
