<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\article\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\modules\article\models\{Topic, Article, search\ArticleSearch};

class FrontController extends Controller
{
    
    /**
     * Renders All Actual Topic
     *
     * @return string
     */
    public function actionIndex()
    {
        /**
         * Fluid Layout
         */
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->frontSearch(Yii::$app->request->queryParams);
        $topics = ArrayHelper::map(Topic::find()->select(['id', 'name'])->where(['visible' => true])->asArray()->all(), 'id', 'name');
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'topics'       => $topics,
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
