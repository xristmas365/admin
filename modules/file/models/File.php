<?php

namespace app\modules\file\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use app\modules\file\models\query\FileQuery;

/**
 * This is the model class for table "file".
 *
 * @property int          $id
 * @property string|null  $name
 * @property int|null     $size
 * @property string|null  $ext
 * @property string|null  $url
 * @property int|null     $created_at
 * @property int|null     $created_by
 * @property int|null     $uploaded_at
 * @property int|null     $uploaded_by
 *
 * @property UploadedFile $file
 * @property string       $src
 * @property string       $link
 */
class File extends ActiveRecord
{
    
    public $file;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }
    
    /**
     * {@inheritdoc}
     * @return FileQuery the active query used by this AR class.
     */
    public static function find() : FileQuery
    {
        return new FileQuery(get_called_class());
    }
    
    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
            [
                'class'              => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false],
            [['size', 'created_at', 'created_by', 'uploaded_at', 'uploaded_by'], 'default', 'value' => null],
            [['size', 'created_at', 'created_by', 'uploaded_at', 'uploaded_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['ext'], 'string', 'max' => 10],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Name',
            'size'        => 'Size',
            'ext'         => 'Ext',
            'url'         => 'Url',
            'created_at'  => 'Created At',
            'created_by'  => 'Created By',
            'uploaded_at' => 'Uploaded At',
            'uploaded_by' => 'Uploaded By',
        ];
    }
    
    public function upload()
    {
        if($this->validate()) {
            $this->file->saveAs('@app/web/upload/' . $this->file->name);
            
            return true;
        } else {
            return false;
        }
    }
    
    public function beforeSave($insert)
    {
        $path = Yii::getAlias('@app/web/upload/');
        $ext = $this->file->extension;
        $name = $this->file->name;
        $size = $this->file->size;
        $url = Yii::$app->security->generateRandomString(10) . '.' . $ext;
        
        if($insert && $this->file->saveAs($path . $url)) {
            $this->name = $name;
            $this->ext = $ext;
            $this->size = $size;
            $this->url = $url;
        }
        
        return parent::beforeSave($insert);
    }
    
    public function getSrc()
    {
        $path = Yii::getAlias('@app/web/upload/');
        
        return "$path{$this->url}";
    }
    
    public function getLink()
    {
        return Url::base(true) . "/upload/{$this->url}";
    }
}
