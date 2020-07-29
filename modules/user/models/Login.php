<?php
/**
 * Login.php
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
use yii\base\Model;

/**
 * Class Login
 *
 * @property string $email
 * @property string $password
 * @property string $remember
 *
 * @package app\modules\user
 */
class Login extends Model
{
    
    public $email;
    
    public $password;
    
    public $remember;
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['remember', 'boolean'],
        ];
    }
    
    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function in()
    {
        if(!$this->validate()) {
            $this->addError('email', 'Incorrect email or password!');
            
            return false;
        }
        
        $user = User::findOne(['email' => $this->email]);
        
        if(!$user) {
            $this->addError('email', 'Account not created. Create an Account');
            
            return false;
        }
        
        if(!Yii::$app->security->validatePassword($this->password, $user->password)) {
            $this->addError('password', 'Incorrect password');
            
            return false;
        }
        
        if($user->blocked) {
            $this->addError('email', 'Account blocked or deactivated');
            
            return false;
        }
        
        if(!$user->confirmed) {
            $this->addError('email', 'Email not verified');
            
            return false;
        }
        
        return Yii::$app->user->login($user, $this->remember ? getenv('SESSION_DURATION') : 0);
    }
}
