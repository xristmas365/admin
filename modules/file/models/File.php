<?php

namespace app\modules\file\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $size
 * @property string|null $ext
 * @property int|null $created_at
 * @property int|null $created_by
 * @property int|null $uploaded_at
 * @property int|null $uploaded_by
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
            'id' => 'ID',
            'name' => 'Name',
            'size' => 'Size',
            'ext' => 'Ext',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'uploaded_at' => 'Uploaded At',
            'uploaded_by' => 'Uploaded By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\modules\file\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\modules\file\models\query\FileQuery(get_called_class());
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('@app/web/upload/' . $this->file->name);
            return true;
        } else {
            return false;
        }
    }
}
