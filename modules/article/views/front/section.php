<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

use yii\web\View;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Section;
use app\modules\article\models\search\ArticleSearch;

/**
 * @var $this         View
 * @var $section      Section
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
