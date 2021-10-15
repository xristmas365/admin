<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\store\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\store\models\Coupon;

/**
 * CouponSearch represents the model behind the search form of `app\modules\store\models\Coupon`.
 */
class CouponSearch extends Coupon
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'value', 'created_by', 'start_date', 'end_date'], 'integer'],
            [['name'], 'safe'],
            [['deleted'], 'boolean'],
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
        $query = Coupon::find()->andWhere(['deleted' => false, 'created_by' => Yii::$app->user->id]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id'         => $this->id,
            'value'      => $this->value,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
            'deleted'    => $this->deleted,
        ]);
        
        $query->andFilterWhere(['ilike', 'name', $this->name]);
        
        return $dataProvider;
    }
}
