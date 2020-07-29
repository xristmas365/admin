<?php
/**
 * Dependency Injections
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

return [
    'definitions' => [
        //'yii\grid\GridView' => 'app\modules\admin\widgets\grid\AdminGrid',
        'yii\data\Sort' => [
            'class'        => 'yii\data\Sort',
            'defaultOrder' => ['id' => SORT_ASC],
        ],
    ],
];
