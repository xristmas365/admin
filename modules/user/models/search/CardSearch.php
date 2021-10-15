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
use app\modules\user\models\Card;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class CardSearch extends Card
{
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'number',
                    'brand',
                    'country',
                    'stripe_id',
                    'source',
                ],
                'safe',
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
        $query = Card::find();
        
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
            'number'  => $this->number,
            'brand'   => $this->brand,
            'country' => $this->country,
        ]);
        
        return $dataProvider;
    }
}
