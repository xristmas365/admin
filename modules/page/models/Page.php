<?php
/**
 * Page.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\page\models;

/**
 * This is the model class for table "page".
 *
 * @property int         $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $created_by
 * @property int|null    $updated_by
 * @property string|null $keywords
 * @property string|null $slug
 * @property bool|null   $draft
 */
class Page extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['draft'], 'boolean'],
            [['title', 'description', 'keywords', 'slug'], 'string', 'max' => 255],
        ];
    }
    
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
            [
                'class'     => 'yii\behaviors\SluggableBehavior',
                'attribute' => 'title',
            ],
        
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'title'       => 'Title',
            'description' => 'Description',
            'content'     => 'Content',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
            'created_by'  => 'Created By',
            'updated_by'  => 'Updated By',
            'keywords'    => 'Keywords',
            'slug'        => 'Slug',
            'draft'       => 'Draft',
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeHints()
    {
        return [
            'description' => 'SEO and Description',
            'keywords'    => 'SEO Keywords',
        ];
    }
}
