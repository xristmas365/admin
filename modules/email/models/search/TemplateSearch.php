<?php

namespace app\modules\email\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\email\models\EmailTemplate;

/**
 * FileSearch represents the model behind the search form of `app\modules\email\models\EmailTemplate`.
 */
class TemplateSearch extends EmailTemplate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'subject', 'content', 'template_key'], 'safe'],
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
        $query = EmailTemplate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'subject', $this->subject])
            ->andFilterWhere(['ilike', 'content', $this->content]);

        return $dataProvider;
    }
}
