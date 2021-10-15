<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;
use yii\behaviors\{BlameableBehavior, TimestampBehavior};

/**
 * This is the model class for table "user_charge".
 *
 * @property int         $id
 * @property int|null    $user_id
 * @property int|null    $order_id
 * @property int|null    $card_id
 * @property string|null $stripe_id
 * @property float|null  $amount
 * @property bool|null   $paid
 * @property int|null    $created_at
 */
class Charge extends ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_charge';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'order_id', 'card_id', 'created_at'], 'default', 'value' => null],
            [['user_id', 'order_id', 'card_id', 'created_at'], 'integer'],
            [['amount'], 'number'],
            [['paid'], 'boolean'],
            [['stripe_id'], 'string', 'max' => 255],
        ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'User ID',
            'order_id'   => 'Order ID',
            'card_id'    => 'Card ID',
            'stripe_id'  => 'Fingerprint',
            'amount'     => 'Amount',
            'paid'       => 'Paid',
            'created_at' => 'Date',
        ];
    }
    
    public function getCard()
    {
        return $this->hasOne(Card::class, ['id' => 'card_id']);
    }
}
