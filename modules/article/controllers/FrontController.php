<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

namespace app\modules\article\controllers;

use Yii;
use yii\web\Controller;
use app\modules\article\models\{Section, Article, search\SectionSearch, search\ArticleSearch};

class FrontController extends Controller
{
    
    public function actionSections()
    {
        $searchModel = new SectionSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('sections', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionSection($slug)
    {
        $section = Section::findOne(['slug' => $slug]);
        
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->frontSearch($section->id, Yii::$app->request->queryParams);
        
        return $this->render('section', [
            'section'      => $section,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionArticle($slug)
    {
        $article = Article::findOne(['slug' => $slug]);
        
        return $this->render('article', [
            'article' => $article,
        ]);
    }
    
}
