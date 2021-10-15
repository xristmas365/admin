<?php

namespace app\modules\user\models;

use yii\behaviors\BlameableBehavior;
use yii\db\{ActiveQuery, ActiveRecord};

/**
 * This is the model class for table "user_card".
 *
 * @property int         $id
 * @property int|null    $user_id
 * @property string|null $source
 * @property string|null $brand
 * @property string|null $country
 * @property string|null $number
 *
 * @property User        $user
 */
class Card extends ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_card';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['source', 'brand', 'country', 'number'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'user_id' => 'User ID',
            'source'  => 'Fingerprint',
            'brand'   => 'Brand',
            'country' => 'Country',
            'number'  => 'Number',
        ];
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
