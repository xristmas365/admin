<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

return [
    'definitions' => [
        'yii\data\Sort'             => [
            'class'        => 'yii\data\Sort',
            'defaultOrder' => ['id' => SORT_ASC],
        ],
        'kartik\form\ActiveField'   => 'app\modules\admin\widgets\form\ActiveField',
        'dosamigos\tinymce\TinyMce' => [
            'clientOptions' => [
                'height'   => '60vh',
                'toolbar'  => "undo redo | code link table hr | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent |  ",
                'branding' => false,
                'plugins'  => [
                    "advlist autolink lists link charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table paste hr",
                ],
            ],
        ],
    ],
];
