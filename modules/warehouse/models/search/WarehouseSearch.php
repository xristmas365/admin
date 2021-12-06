<?php

namespace app\modules\warehouse\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\user\models\Role;
use app\modules\warehouse\models\Warehouse;

/**
 * WarehouseSearch represents the model behind the search form of `app\modules\warehouse\models\Warehouse`.
 */
class WarehouseSearch extends Warehouse
{
    
    public $total_from;
    
    public $total_to;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'zip', 'city', 'address', 'state', 'pw_total', 'user_id'], 'safe'],
            [['active'], 'boolean'],
            [['total_from', 'total_to'], 'number'],
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
        $query = Warehouse::find()
                          ->addSelect(['warehouse.*', "SUM(product_warehouse.total) as pw_total"])
                          ->joinWith(['productWarehouses', 'user'])
                          ->groupBy('warehouse.id');
        
        if(!Yii::$app->user->can(Role::ADMIN)) {
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => Yii::$app->session->get('page-size', 20)],
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'warehouse.id' => $this->id,
            'active'       => $this->active,
        
        ]);
        $query->andFilterHaving([
            '<',
            'SUM(product_warehouse.total)',
            $this->total_to,
        
        ])->andFilterHaving([
            '>',
            'SUM(product_warehouse.total)',
            $this->total_from,
        
        ]);
        $dataProvider->sort->attributes['pw_total'] = [
            'asc'          => ['pw_total' => SORT_ASC],
            'desc'         => ['pw_total' => SORT_DESC],
            'defaultOrder' => SORT_ASC,
        ];
        
        $query->andFilterWhere(['ilike', 'name', $this->name])
              ->andFilterWhere(['ilike', 'zip', $this->zip])
              ->andFilterWhere(['ilike', 'user.name', $this->user_id])
              ->andFilterWhere(['ilike', 'city', $this->city])
              ->andFilterWhere(['ilike', 'address', $this->address])
              ->andFilterWhere(['ilike', 'state', $this->state]);
        
        return $dataProvider;
    }
}
