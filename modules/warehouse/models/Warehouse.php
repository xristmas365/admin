<?php

namespace app\modules\warehouse\models;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Role;
use yii\db\{ActiveQuery, ActiveRecord};
use app\modules\warehouse\models\query\WarehouseQuery;
use app\modules\warehouse\models\query\ProductWarehouseQuery;

/**
 * This is the model class for table "warehouse".
 *
 * @property int                $id
 * @property int|null           $user_id
 * @property string             $name
 * @property string|null        $zip
 * @property string|null        $city
 * @property string|null        $address
 * @property string|null        $state
 * @property bool               $active
 *
 * @property ProductWarehouse[] $productWarehouses
 * @property User               $user
 */
class Warehouse extends ActiveRecord
{
    public $pw_total;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'warehouse';
    }
    
    public static function getWarehouseList($id)
    {
        return self::find()
                   ->select(['id', 'name', 'active'])
                   ->andFilterWhere(['user_id' => $id])
                   ->orderBy(['active' => SORT_DESC, 'name' => SORT_ASC])
                   ->asArray()
                   ->all();
        
    }
    
    /**
     * {@inheritdoc}
     * @return WarehouseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WarehouseQuery(get_called_class());
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            [
                'name',
                'unique',
                'targetClass'     => self::class,
                'targetAttribute' => ['user_id', 'name'],
                'message'         => Yii::$app->user->can(Role::ADMIN) ? 'Warehouse {value} has been already taken for selected User' : 'Warehouse {value} has been already taken',
            ],
            [
                ['user_id'],
                'required',
                'when' => function($model)
                {
                    return Yii::$app->user->can(Role::ADMIN);
                },
            ],
            [['user_id'], 'integer'],
            [['active'], 'boolean'],
            [['name', 'city', 'address'], 'string', 'max' => 255],
            [['zip'], 'string', 'max' => 6],
            [['state'], 'string', 'max' => 2],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['pw_total'], 'number'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'user_id'  => 'User',
            'name'     => 'Name',
            'zip'      => 'Zip',
            'city'     => 'City',
            'address'  => 'Address',
            'state'    => 'State',
            'active'   => 'Active',
            'pw_total' => 'Total',
        ];
    }
    
    /**
     * Gets query for [[ProductWarehouses]].
     *
     * @return ProductWarehouseQuery|ActiveQuery
     */
    public function getProductWarehouses()
    {
        return $this->hasMany(ProductWarehouse::class, ['warehouse_id' => 'id']);
    }
    
    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
}
