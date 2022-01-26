<?php

namespace app\modules\file\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\file\models\File;

/**
 * FileSearch represents the model behind the search form of `app\modules\file\models\File`.
 */
class FileSearch extends File
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'size', 'created_at', 'created_by', 'uploaded_at', 'uploaded_by'], 'integer'],
            [['name', 'ext'], 'safe'],
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
        $query = File::find();

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
            'size' => $this->size,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'uploaded_at' => $this->uploaded_at,
            'uploaded_by' => $this->uploaded_by,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'ext', $this->ext]);

        return $dataProvider;
    }
}
