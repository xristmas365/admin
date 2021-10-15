<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\user\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveQuery;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
use yii\base\InvalidConfigException;
use yii\behaviors\SluggableBehavior;
use app\modules\storage\models\Storage;

/**
 * This is the model class for table "user".
 *
 * @property int         $id
 * @property string      $email
 * @property string|null $password
 * @property bool        $blocked
 * @property bool        $confirmed
 * @property string|null $auth_key
 * @property int         $role
 * @property string      $name
 * @property string|null $phone
 * @property string|null $company
 * @property string|null $slug
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property int|null    $zip
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $last_login_at
 * @property string|null $stripe_id
 *
 * @property string      $roleValue
 * @property Storage[]   $attachments
 * @property string      $image
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    
    public $files;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
    
    /**
     * @param int|string $id
     *
     * @return array|ActiveRecord|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->one();
    }
    
    /**
     * @param mixed $token
     * @param null  $type
     *
     * @return User|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
    
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password'], 'required'],
            [['blocked', 'confirmed'], 'boolean'],
            [['role', 'zip', 'created_at', 'updated_at', 'last_login_at'], 'default', 'value' => null],
            [['role', 'created_at', 'updated_at', 'last_login_at'], 'integer'],
            [['email', 'company', 'stripe_id'], 'string', 'max' => 255],
            [['password', 'address'], 'string', 'max' => 60],
            [['auth_key', 'name', 'city'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
            [['state'], 'string', 'max' => 2],
            [['zip'], 'string', 'max' => 5],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['files', 'slug'], 'safe'],
            [['company'], 'unique'],
        
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'file'     => [
                'class'            => 'app\modules\storage\behaviors\UploadBehavior',
                'uploadRelation'   => 'attachments',
                'pathAttribute'    => 'path',
                'attribute'        => 'files',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute'    => 'type',
                'sizeAttribute'    => 'size',
                'nameAttribute'    => 'name',
                'orderAttribute'   => 'sort',
                'multiple'         => true,
            ],
            'auth_key' => [
                'class'      => 'yii\behaviors\AttributeBehavior',
                'attributes' => [static::EVENT_BEFORE_INSERT => 'auth_key'],
                'value'      => Yii::$app->security->generateRandomString(),
            ],
            'slug'     => [
                'class'     => SluggableBehavior::class,
                'attribute' => 'company',
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'email'         => 'Email',
            'password'      => 'Password',
            'blocked'       => 'Blocked',
            'confirmed'     => 'Confirmed',
            'auth_key'      => 'Auth Key',
            'role'          => 'Role',
            'name'          => 'Name',
            'phone'         => 'Phone',
            'address'       => 'Address',
            'city'          => 'City',
            'state'         => 'State',
            'zip'           => 'Zip',
            'created_at'    => 'Registration',
            'updated_at'    => 'Updated At',
            'last_login_at' => 'Last Login',
        ];
    }
    
    /**
     * @param string $authKey
     *
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    
    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string|null
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * Gets Role Value
     *
     * @return array
     */
    public function getRoleValue() : string
    {
        return ArrayHelper::getValue(Role::list(), [$this->role]);
    }
    
    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getAttachments() : ActiveQuery
    {
        return $this->hasMany(Storage::class, ['model_id' => 'id'])->where(['model_name' => $this->formName()]);
    }
    
    public function getImage()
    {
        if($this->attachments) {
            return $this->attachments[0]->src;
        }
        
        return Url::base(true) . '/images/no_photo.webp';
    }
    
    /**
     * @return string
     */
    public function generateResetLink()
    {
        $this->updateAuthKey();
        
        return Url::toRoute(['/user/auth/password', 'auth' => $this->auth_key], true);
    }
    
    /**
     * @param bool $setNull
     *
     * @throws Exception
     */
    public function updateAuthKey($clear = false) : void
    {
        $key = $clear ? null : Yii::$app->security->generateRandomString();
        $this->updateAttributes(['auth_key' => $key]);
    }
    
    /**
     * @return string
     */
    public function generateVerifyLink()
    {
        $this->updateAuthKey();
        
        return Url::toRoute(['/user/auth/verify', 'auth' => $this->auth_key], true);
    }
    
    /**
     * Generates password hash token for new User
     *
     * @param bool $insert
     *
     * @return bool
     * @throws Exception
     */
    public function beforeSave($insert) : bool
    {
        if($insert) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->role = $this->role ?? Role::USER;
        }
        
        return parent::beforeSave($insert);
    }
}
