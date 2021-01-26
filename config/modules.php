<?php

/**
 * modules.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

return [
    'gridview'    => 'kartik\grid\Module',
    'admin'       => 'app\modules\admin\Module',
    'user'        => 'app\modules\user\Module',
    'storage'     => 'app\modules\storage\Module',
    'store'       => 'app\modules\store\Module',
    'page'        => 'app\modules\page\Module',
    'article'     => 'app\modules\article\Module',
    'treemanager' => [
        'class'            => '\kartik\tree\Module',
        'treeViewSettings' => [
            'nodeView' => '@app/modules/store/views/catalog/form',
        ],
    ],
];
