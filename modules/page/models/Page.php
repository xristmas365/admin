<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\page\models;

use yii\helpers\Url;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\modules\user\models\User;
use yii\base\InvalidConfigException;
use app\modules\storage\models\Storage;
use app\modules\storage\traits\ImageTrait;

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
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $slug
 * @property bool|null   $draft
 * @property Storage[]   $coverAttachments
 * @property string      $coverImage
 * @property User        $author
 */
class Page extends ActiveRecord
{
    
    use ImageTrait;
    
    public $cover;
    
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
            [['title'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['draft'], 'boolean'],
            [['files', 'cover'], 'safe'],
            [['title', 'description', 'seo_keywords', 'seo_description', 'slug'], 'string', 'max' => 255],
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
            'cover' => [
                'class'            => 'app\modules\storage\behaviors\UploadBehavior',
                'customKey'        => 'Cover',
                'uploadRelation'   => 'coverAttachments',
                'pathAttribute'    => 'path',
                'attribute'        => 'cover',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute'    => 'type',
                'sizeAttribute'    => 'size',
                'nameAttribute'    => 'name',
                'orderAttribute'   => 'sort',
                'multiple'         => true,
            ],
        
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'title'           => 'Title',
            'description'     => 'Description',
            'content'         => 'Content',
            'created_at'      => 'Created At',
            'updated_at'      => 'Updated At',
            'created_by'      => 'Created By',
            'updated_by'      => 'Updated By',
            'seo_keywords'    => 'SEO Keywords',
            'seo_description' => 'SEO Description',
            'slug'            => 'Slug',
            'draft'           => 'Draft',
        ];
    }
    
    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCoverAttachments() : ActiveQuery
    {
        return $this->hasMany(Storage::class, ['model_id' => 'id'])->andWhere(['model_name' => 'Cover']);
    }
    
    public function getCoverImage()
    {
        if($this->coverAttachments) {
            return $this->coverAttachments[0]->src;
        }
        
        return Url::base(true) . '/images/no_photo.webp';
    }
    
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
    
}
