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
use app\modules\user\models\Role;
use app\modules\store\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\modules\store\models\Order`.
 */
class OrderSearch extends Order
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'coupon_id', 'created_at', 'created_by', 'status'], 'integer'],
            [['sum', 'coupon_discount', 'tax', 'total'], 'number'],
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
        $query = Order::find()->with(['coupon', 'user']);
        
        if(!Yii::$app->user->can(Role::ADMIN)) {
            $query->andWhere(['created_by' => Yii::$app->user->id]);
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
            'id'              => $this->id,
            'coupon_id'       => $this->coupon_id,
            'created_at'      => $this->created_at,
            'created_by'      => $this->created_by,
            'sum'             => $this->sum,
            'coupon_discount' => $this->coupon_discount,
            'tax'             => $this->tax,
            'total'           => $this->total,
            'status'          => $this->status,
        ]);
        
        return $dataProvider;
    }
}
