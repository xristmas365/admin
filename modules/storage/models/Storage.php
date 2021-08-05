<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\storage\models;

use yii\helpers\Url;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "storage".
 *
 * @property int         $id
 * @property int|null    $model_id
 * @property string|null $model_name
 * @property string|null $path
 * @property string|null $base_url
 * @property string|null $type
 * @property int|null    $size
 * @property string|null $name
 * @property int|null    $created_at
 * @property int|null    $created_by
 *
 * @property string      $src
 */
class Storage extends ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storage';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'size', 'created_at', 'created_by'], 'default', 'value' => null],
            [['model_id', 'size', 'created_at', 'created_by'], 'integer'],
            [['model_name', 'path', 'base_url', 'name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 32],
        ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class'              => 'yii\behaviors\TimestampBehavior',
                'updatedAtAttribute' => false,
            ],
            [
                'class'              => 'yii\behaviors\BlameableBehavior',
                'updatedByAttribute' => false,
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
            'model_id'   => 'Model ID',
            'model_name' => 'Model Name',
            'path'       => 'Path',
            'base_url'   => 'Base Url',
            'type'       => 'Type',
            'size'       => 'Size',
            'name'       => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
    
    /**
     * Public source
     *
     * @return string
     */
    public function getSrc()
    {
        return Url::base(true) . $this->base_url . $this->path;
    }
    
}
