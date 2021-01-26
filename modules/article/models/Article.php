<?php

namespace app\modules\article\models;

use yii\helpers\Url;
use yii\base\InvalidConfigException;
use yii\db\{ActiveQuery, ActiveRecord};
use app\modules\storage\models\Storage;
use app\modules\storage\traits\ImageTrait;
use yii\behaviors\{TimestampBehavior, BlameableBehavior, SluggableBehavior};

/**
 * This is the model class for table "article".
 *
 * @property int         $id
 * @property int|null    $section_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property bool        $draft
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $created_by
 * @property int|null    $updated_by
 *
 * @property Section     $section
 * @property Storage[]   $coverAttachments
 * @property string      $coverImage
 */
class Article extends ActiveRecord
{
    
    use ImageTrait;
    
    public $cover;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['section_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['section_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description', 'content'], 'string'],
            [['draft'], 'boolean'],
            [['files', 'cover'], 'safe'],
            [['title', 'seo_description', 'seo_keywords', 'slug'], 'string', 'max' => 255],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::class, 'targetAttribute' => ['section_id' => 'id']],
        ];
    }
    
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            'slug'  => [
                'class'        => SluggableBehavior::class,
                'attribute'    => 'title',
                'ensureUnique' => true,
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
            'section_id'      => 'Section',
            'title'           => 'Title',
            'description'     => 'Description',
            'content'         => 'Content',
            'seo_description' => 'Seo Description',
            'seo_keywords'    => 'Seo Keywords',
            'draft'           => 'Draft',
            'created_at'      => 'Created At',
            'updated_at'      => 'Updated At',
            'created_by'      => 'Created By',
            'updated_by'      => 'Updated By',
        ];
    }
    
    /**
     * Gets query for [[Section]].
     *
     * @return ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::class, ['id' => 'section_id']);
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
        
        return Url::base(true) . '/images/no-image.webp';
    }
}
