<?php

namespace app\modules\store\models;

use Yii;
use yii\db\{ActiveQuery, ActiveRecord};

/**
 * This is the model class for table "order_product".
 *
 * @property int        $id
 * @property int|null   $order_id
 * @property int|null   $product_id
 * @property float|null $price
 * @property float|null $coupon_discount
 * @property float|null $tax
 * @property int|null   $quantity
 * @property float|null $sum
 *
 * @property Order      $order
 * @property Product    $product
 */
class OrderProduct extends ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_product';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'quantity'], 'default', 'value' => null],
            [['order_id', 'product_id', 'quantity'], 'integer'],
            [['price', 'coupon_discount', 'tax', 'sum'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'order_id'        => 'Order',
            'product_id'      => 'Product Item',
            'price'           => 'Product Price',
            'coupon_discount' => 'Product Discount',
            'tax'             => 'Product Tax',
            'quantity'        => 'Product Quantity',
            'sum'             => 'Product Total Amount',
        ];
    }
    
    /**
     * Gets query for [[Order]].
     *
     * @return ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
    
    /**
     * Gets query for [[Product]].
     *
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
