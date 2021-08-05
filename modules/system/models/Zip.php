<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\system\models;

use Yii;

/**
 * This is the model class for table "zip".
 *
 * @property int $id
 * @property string|null $zip
 * @property string|null $state
 * @property string|null $city
 */
class Zip extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zip'], 'string', 'max' => 5],
            [['state'], 'string', 'max' => 2],
            [['city'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zip' => 'Zip',
            'state' => 'State',
            'city' => 'City',
        ];
    }
}
