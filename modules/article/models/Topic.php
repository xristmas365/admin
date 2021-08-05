<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\article\models;

use yii\helpers\ArrayHelper;
use yii\db\{ActiveQuery, ActiveRecord};
use app\modules\storage\traits\ImageTrait;

/**
 * This is the model class for table "section".
 *
 * @property int         $id
 * @property string|null $name
 * @property string      $slug
 * @property bool        $home
 * @property bool        $visible
 *
 * @property Article[]   $articles
 */
class Topic extends ActiveRecord
{
    
    use ImageTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topic';
    }
    
    public static function items()
    {
        return ArrayHelper::map(static::find()->select(['id', 'name'])->asArray()->all(), 'id', 'name');
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['files'], 'safe'],
            [['home', 'visible'], 'boolean'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }
    
    public function behaviors()
    {
        return [
            'slug' => [
                'class'     => 'yii\behaviors\SluggableBehavior',
                'attribute' => 'name',
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'name'    => 'Name',
            'home'    => 'Home',
            'slug'    => 'Slug',
            'visible' => 'Visible',
        ];
    }
    
    /**
     * Gets query for [[Articles]].
     *
     * @return ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::class, ['topic_id' => 'id']);
    }
}
