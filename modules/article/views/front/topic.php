<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Topic;
use app\modules\article\models\search\ArticleSearch;

/**
 * @var $this         View
 * @var $section      Topic
 * @var $searchModel  ArticleSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = Yii::$app->name . ' - ' . $section->name

?>
<h1><?= $section->name ?></h1>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => '_article_item',
    'summary'      => false,
    'layout'       => "<div class='row'>{items}</div>\n{pager}",
    'itemOptions'  => [
        'class' => 'col-md-3',
    ],
    'options'      => [
        'class' => 'row',
    ],
]) ?>
