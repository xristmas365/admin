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
use app\modules\user\models\User;
use app\modules\user\models\Role;
use kartik\daterange\DateRangeBehavior;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    
    
    public $created_at_start;
    
    public $created_at_end;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role'], 'integer'],
            [
                [
                    'email',
                    'password',
                    'auth_key',
                    'name',
                    'phone',
                    'address',
                    'city',
                    'zip',
                    'state',
                    'name',
                    'search',
                    'created_at',
                    'updated_at',
                    'last_login_at',
                    'created_at_start',
                    'created_at_end',
                ],
                'safe',
            ],
            [['blocked', 'confirmed'], 'boolean'],
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
        $query = User::find()
                     ->with(['attachments'])
                     ->select(['id', 'zip', 'state', 'city', 'email', 'name', 'blocked', 'confirmed', 'role', 'created_at', 'last_login_at']);
    
        /**
         * Exclude Admin and Developer from Users List
         */
        $query->andWhere(['<>', 'role', Role::DEVELOPER]);
        
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => ['pageSize' => Yii::$app->session->get('page-size', 20)],
        ]);
        
        $this->load($params);
        
        if(!$this->validate()) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id'        => $this->id,
            'blocked'   => $this->blocked,
            'confirmed' => $this->confirmed,
            'role'      => $this->role,
        ]);
        
        $query
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['between', 'created_at', $this->created_at_start, $this->created_at_end])
            ->andFilterWhere(['ilike', 'name', $this->name]);
        
        return $dataProvider;
    }
}
