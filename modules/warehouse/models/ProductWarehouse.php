<?php

namespace app\modules\warehouse\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\modules\store\models\Product;
use app\modules\warehouse\models\query\WarehouseQuery;
use app\modules\warehouse\models\query\ProductWarehouseQuery;

/**
 * This is the model class for table "product_warehouse".
 *
 * @property int        $id
 * @property int|null   $product_id
 * @property int|null   $warehouse_id
 * @property float      $quantity
 * @property int|null   $status
 * @property float|null $price
 * @property float|null $total
 * @property int|null   $created_at
 *
 * @property Product    $product
 * @property Warehouse  $warehouse
 * @property int        $qty
 */
class ProductWarehouse extends ActiveRecord
{
    
    
    const STATUS_INBOUND = 1;
    
    const STATUS_OUTBOUND = 2;
    
    const STATUS_RETURN = 3;
    
    const STATUS_SELL = 4;
    
    public $qty;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_warehouse';
    }
    
    /**
     * {@inheritdoc}
     * @return ProductWarehouseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductWarehouseQuery(get_called_class());
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'warehouse_id', 'status', 'created_at'], 'default', 'value' => null],
            [['product_id', 'warehouse_id', 'status', 'created_at'], 'integer'],
            [['quantity'], 'required'],
            [['quantity', 'price', 'total'], 'number'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::class, 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'product_id'   => 'Product',
            'warehouse_id' => 'Warehouse ID',
            'quantity'     => 'Quantity',
            'qty'          => 'Quantity',
            'status'       => 'Status',
            'price'        => 'Price',
            'total'        => 'Total',
            'created_at'   => 'Created At',
        ];
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'              => 'yii\behaviors\TimestampBehavior',
                'updatedAtAttribute' => false,
            ],
        ];
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
    
    /**
     * Gets query for [[Warehouse]].
     *
     * @return ActiveQuery|WarehouseQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::class, ['id' => 'warehouse_id']);
    }
}
