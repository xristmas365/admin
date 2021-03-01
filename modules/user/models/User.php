<?php
/**
 * User.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
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
 * @property string      $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property int|null    $zip
 * @property int|null    $created_at
 * @property int|null    $updated_at
 * @property int|null    $last_login_at
 *
 * @property string      $name
 * @property string      $roleValue
 * @property Storage[]   $attachments
 * @property string      $image
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    
    const ROLE_USER      = 0;
    const ROLE_ADMIN     = 1;
    const ROLE_DEVELOPER = 2;
    
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
        return static::find()
                     ->where(['id' => $id])
                     ->with(['attachments'])
                     ->one();
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
     * Gets List of all Roles
     *
     * @return array
     */
    public static function roleList() : array
    {
        $roles = static::roles();
        $list = [];
        
        foreach($roles as $key => $role) {
            if(!Yii::$app->user->can(static::ROLE_DEVELOPER) && $key === static::ROLE_DEVELOPER) {
                continue;
            }
            
            $list[$key] = $role['name'];
        }
        
        return $list;
    }
    
    /**
     * Roles Configuration
     *
     * @return array
     */
    public static function roles() : array
    {
        return [
            static::ROLE_USER      => [
                'name' => 'User',
            ],
            static::ROLE_ADMIN     => [
                'name'   => 'Admin',
                'access' => [
                    User::ROLE_USER,
                ],
            ],
            static::ROLE_DEVELOPER => [
                'name'   => 'Developer',
                'access' => [
                    User::ROLE_ADMIN,
                ],
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'first_name'], 'required'],
            [['blocked', 'confirmed'], 'boolean'],
            [['role', 'zip', 'created_at', 'updated_at', 'last_login_at'], 'default', 'value' => null],
            [['role', 'zip', 'created_at', 'updated_at', 'last_login_at'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['password', 'address'], 'string', 'max' => 60],
            [['auth_key', 'first_name', 'last_name', 'city'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 12],
            [['state'], 'string', 'max' => 2],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['files'], 'safe'],
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
            'first_name'    => 'First Name',
            'last_name'     => 'Last Name',
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
        return $this->authKey === $authKey;
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
     * @return string
     */
    public function getName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
    
    /**
     * Gets Role Value
     *
     * @return mixed|null
     */
    public function getRoleValue() : ?string
    {
        $roles = static::roles();
        
        return ArrayHelper::getValue($roles[$this->role], 'name');
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
     * Generates role, password hash and token for new User
     *
     * @param bool $insert
     *
     * @return bool
     * @throws Exception
     */
    public function beforeSave($insert) : bool
    {
        if($insert) {
            $this->role = $this->role ?? static::ROLE_USER;
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        }
        
        return parent::beforeSave($insert);
    }
}
