<?php

namespace app\modules\article\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `app\modules\article\models\Article`.
 */
class ArticleSearch extends Article
{
    
    public $search;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'section_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description', 'content', 'seo_description', 'seo_keywords', 'search', 'slug'], 'safe'],
            [['draft'], 'boolean'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find()->joinWith(['section'])->with('coverAttachments');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'section_id' => $this->section_id,
            'draft'      => $this->draft,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);
        
        $query->andFilterWhere(['ilike', 'title', $this->title])
              ->andFilterWhere(['ilike', 'description', $this->description])
              ->andFilterWhere(['ilike', 'content', $this->content])
              ->andFilterWhere(['ilike', 'seo_description', $this->seo_description])
              ->andFilterWhere(['ilike', 'seo_keywords', $this->seo_keywords]);
        
        return $dataProvider;
    }
    
    public function frontSearch($section_id, $params)
    {
        $query = Article::find()
                        ->joinWith(['section'])
                        ->andWhere(['section_id' => $section_id])
                        ->with('coverAttachments');
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => 20],
        ]);
        
        $this->load($params);
        
        return $dataProvider;
    }
}
