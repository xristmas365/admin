<?php

namespace app\modules\store\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\user\models\User;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "coupon".
 *
 * @property int         $id
 * @property string|null $name
 * @property int|null    $value
 * @property string|null $token
 * @property int|null    $created_by
 * @property int|null    $start_date
 * @property int|null    $end_date
 * @property bool        $deleted
 * @property bool        $active
 */
class Coupon extends ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coupon';
    }
    
    /**
     * @return int|null
     */
    public static function getDiscount()
    {
        $couponID = Yii::$app->session->get('coupon-discount');
        
        if(!$couponID) {
            return 0;
        }
        
        $coupon = Coupon::findOne($couponID);
        
        return $coupon->value;
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'created_by', 'start_date', 'end_date'], 'default', 'value' => null],
            [['value', 'created_by'], 'integer'],
            [['deleted'], 'boolean'],
            [['start_date', 'end_date'], 'safe'],
            [['name', 'token'], 'string', 'max' => 255],
        ];
    }
    
    public function behaviors()
    {
        return [
            'creator' => [
                'class'              => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
            'token'   => [
                'class'      => AttributeBehavior::class,
                'attributes' => [static::EVENT_BEFORE_INSERT => 'token'],
                'value'      => Yii::$app->security->generateRandomString(),
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
            'name'       => 'Name',
            'active'     => 'Active',
            'value'      => 'Discount, %',
            'created_by' => 'Created By',
            'start_date' => 'Start Date',
            'end_date'   => 'End Date',
            'deleted'    => 'Deleted',
        ];
    }
    
    public function beforeSave($insert)
    {
        $this->start_date = strtotime($this->start_date . ' 12:00:00 AM');
        $this->end_date = strtotime($this->end_date . ' 11:59:00 PM');
        
        return parent::beforeSave($insert);
    }
    
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
}
