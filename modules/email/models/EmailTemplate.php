<?php

namespace app\modules\email\models;

use yii\helpers\Url;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\modules\storage\models\Storage;
use app\modules\storage\traits\ImageTrait;

/**
 * This is the model class for table "email_template".
 *
 * @property int         $id
 * @property string|null $name
 * @property string|null $subject
 * @property string|null $content
 * @property Storage[]   $templateAttachments
 * @property string      $templateImage
 * @property string      $template_key [varchar(255)]
 */
class EmailTemplate extends ActiveRecord
{
    
    use ImageTrait;
    
    public $template;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_template';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['name', 'subject', 'template_key'], 'string', 'max' => 255],
            [['files', 'template'], 'safe'],
        ];
    }
    
    public function behaviors()
    {
        return [
            'template' => [
                'class'            => 'app\modules\storage\behaviors\UploadBehavior',
                'customKey'        => 'Template',
                'uploadRelation'   => 'templateAttachments',
                'pathAttribute'    => 'path',
                'attribute'        => 'template',
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
            'id'      => 'ID',
            'name'    => 'Name',
            'subject' => 'Subject',
            'content' => 'Content',
            'template_key'     => 'Key',
        ];
    }
    
    public function getTemplateAttachments() : ActiveQuery
    {
        return $this->hasMany(Storage::class, ['model_id' => 'id'])->andWhere(['model_name' => 'Template']);
    }
    
    public function getTemplateImage()
    {
        if($this->templateAttachments) {
            return $this->templateAttachments[0]->src;
        }
        
        return Url::base(true) . '/images/no_photo.webp';
    }
    
}
