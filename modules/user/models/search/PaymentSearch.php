<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\user\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\user\models\Role;
use app\modules\user\models\Charge;
use kartik\daterange\DateRangeBehavior;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class PaymentSearch extends Charge
{
    
    
    public $created_at_start;
    
    public $created_at_end;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'card_id',
                    'order_id',
                    'stripe_id',
                    'amount',
                    'created_at',
                ],
                'safe',
            ],
        ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class'              => DateRangeBehavior::class,
                'attribute'          => 'created_at',
                'dateStartAttribute' => 'created_at_start',
                'dateEndAttribute'   => 'created_at_end',
            ],
        ];
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
        $query = Charge::find()->with(['card']);
        
        if(!Yii::$app->user->can(Role::ADMIN)) {
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => Yii::$app->session->get('page-size', 20)],
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id'       => $this->id,
            'order_id' => $this->order_id,
            'card_id'  => $this->card_id,
        ]);
        
        return $dataProvider;
    }
}
