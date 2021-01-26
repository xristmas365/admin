<?php

namespace app\modules\article\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\article\models\Section;

/**
 * SectionSearch represents the model behind the search form of `app\modules\article\models\Section`.
 */
class SectionSearch extends Section
{
    
    public $search;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'search'], 'safe'],
            [['home', 'visible'], 'boolean'],
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
        $query = Section::find();
        
        // add conditions that should always apply here
        
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
            'id'      => $this->id,
            'home'    => $this->home,
            'visible' => $this->visible,
        ]);
        
        $query->andFilterWhere(['ilike', 'name', $this->name]);
        
        return $dataProvider;
    }
}
