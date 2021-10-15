<?php

namespace app\modules\store\models;

use app\modules\user\models\User;
use yii\db\{ActiveQuery, ActiveRecord};

/**
 * This is the model class for table "order".
 *
 * @property int            $id
 * @property int|null       $coupon_id
 * @property int|null       $created_at
 * @property int|null       $created_by
 * @property float|null     $sum
 * @property float|null     $coupon_discount
 * @property float|null     $tax
 * @property float|null     $total
 * @property int|null       $status
 *
 * @property OrderProduct[] $orderProducts
 */
class Order extends ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coupon_id', 'created_at', 'created_by', 'status'], 'default', 'value' => null],
            [['coupon_id', 'created_at', 'created_by', 'status'], 'integer'],
            [['sum', 'coupon_discount', 'tax', 'total'], 'number'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'coupon_id'       => 'Coupon',
            'created_at'      => 'Created At',
            'created_by'      => 'Customer',
            'sum'             => 'Sum',
            'coupon_discount' => 'Coupon Discount',
            'tax'             => 'Tax',
            'total'           => 'Total',
            'status'          => 'Status',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class'              => 'yii\behaviors\TimestampBehavior',
                'updatedAtAttribute' => false,
            ],
        ];
    }
    
    /**
     * Gets query for [[OrderProducts]].
     *
     * @return ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::class, ['order_id' => 'id']);
    }
    
    /**
     * Gets query for Coupon.
     *
     * @return ActiveQuery
     */
    public function getCoupon()
    {
        return $this->hasOne(Coupon::class, ['id' => 'coupon_id']);
    }
    
    /**
     * Gets query for User.
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
