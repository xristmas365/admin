<?php
/**
 * UserSearch.php
 *
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @package    AX project
 * @version    1.0
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\user\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\user\models\User;
use kartik\daterange\DateRangeBehavior;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    
    public $search;
    
    public $created_at_start;
    
    public $created_at_end;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'role', 'zip'], 'integer'],
            [
                [
                    'email',
                    'password',
                    'auth_key',
                    'first_name',
                    'last_name',
                    'phone',
                    'address',
                    'city',
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
                     ->select(['id', 'email', 'first_name', 'last_name', 'blocked', 'confirmed', 'role', 'created_at', 'last_login_at']);
        
        if(!Yii::$app->user->can(User::ROLE_DEVELOPER)) {
            $query->andWhere(['<>', 'role', User::ROLE_DEVELOPER]);
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
            'blocked'   => $this->blocked,
            'confirmed' => $this->confirmed,
            'role'      => $this->role,
        ]);
        
        $query
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['between', 'created_at', $this->created_at_start, $this->created_at_end])
            ->andFilterWhere(['ilike', 'CONCAT(first_name, \' \' ,last_name)', $this->first_name])
            ->andFilterWhere([
                'OR',
                ['ilike', 'first_name', $this->search],
                ['ilike', 'last_name', $this->search],
                ['ilike', 'phone', $this->search],
                ['ilike', 'email', $this->search],
            ]);
        
        return $dataProvider;
    }
}
