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
use yii\base\Model;
use yii\helpers\Html;

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
            $registerLink = Html::a('<i class="fas fa-lock"></i> Register', ['/user/auth/register']);
            $this->addError('email', 'Account not found. ' . $registerLink);
            
            return false;
        }
        
        if(!Yii::$app->security->validatePassword($this->password, $user->password)) {
            $resetLink = Html::a('<i class="fas fa-lock"></i> Reset Password', ['/user/auth/reset']);
            $this->addError('password', 'Incorrect password. ' . $resetLink);
            
            return false;
        }
        
        if($user->blocked) {
            $this->addError('email', 'Sorry, Your Account is blocked. Contact Adminitstrator');
            
            return false;
        }
        
        if(!$user->confirmed) {
            $this->addError('email', 'Email not verified');
            
            return false;
        }
        
        return Yii::$app->user->login($user, getenv('SESSION_DURATION'));
    }
}
