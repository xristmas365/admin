<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\web\View;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use app\assets\MasonryAsset;
use yii\data\ActiveDataProvider;
use richardfan\widget\JSRegister;
use app\modules\article\models\Article;
use app\modules\article\models\search\ArticleSearch;

/**
 * @var $this                       View
 * @var $searchModel                ArticleSearch
 * @var $topics                     []
 * @var $dataProvider               ActiveDataProvider
 */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = ['label' => 'Articles'];
MasonryAsset::register($this);
?>
<?php Pjax::begin() ?>
<?= $this->render('_search', ['model' => $searchModel, 'topics' => $topics]) ?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => '_article',
    'summary'      => false,
    'layout'       => "<div class='row'>{items}</div>\n{pager}",
    'itemOptions'  => [
        'class' => 'col-lg-3 col-md-4 article-item',
    ],
    'options'      => [
        'class' => 'row article-grid pt-2',
    ],
]) ?>


<?php Pjax::end() ?>

<?php JSRegister::begin() ?>
<script>
$('.article-grid').masonry({
  itemSelector: '.article-item'
})
$(document).on('change', 'input:radio[id^="articlesearch-topic-id-"]', function () {
  $('#article-search-form').submit()
})
$(document).on('pjax:end', function () {
  $('.article-grid').masonry({
    itemSelector: '.article-item'
  })
})
</script>
<?php JSRegister::end() ?>


