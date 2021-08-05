<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use app\modules\admin\widgets\grid\AdminGrid;
use app\modules\admin\widgets\grid\ActionColumn;

/**
 * @var $this         View
 * @var $dataProvider ArrayDataProvider
 */

$this->title = 'Files';
$this->params['breadcrumbs'][] = 'Files';
$this->params['icon'] = 'folder';

?>
<?= AdminGrid::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'attribute' => 'id',
            'format'    => 'raw',
            'label'     => 'Preview',
            'value'     => function($model)
            {
                $path = $model['id'];
                $src = str_replace('/Users/ax/Sites/admin/web', Url::base(true) . '/', $path);
                
                return Html::img($src, ['width' => '50px']);
            },
        ],
        [
            'attribute' => 'id',
            'label'     => 'Path',
            'value'     => function($model)
            {
                return str_replace('/Users/ax/Sites/admin/web/upload', '', $model['id']);
            },
        ],
        [
            'class'    => ActionColumn::class,
            'template' => '{delete}',
            'buttons'  => [
                'delete' => function($url, $model)
                {
                    $url = Url::toRoute(['/admin/file/delete-src', 'id' => $model['id']]);
                    
                    return Html::a('<span class="fas fa-trash-alt"></span>', $url, [
                        'class'      => 'text-danger grid-delete-btn',
                        'title'      => 'Delete',
                        'aria-label' => 'Delete',
                        'data-pjax'  => 0,
                    ]);
                },
            ],
        ],
    ],
]) ?>
