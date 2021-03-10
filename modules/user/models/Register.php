<?php
/**
 *
 * @author    Paul Stolyarov <teajeraker@gmail.com>
 * @copyright industrialax.com
 * @license   https://industrialax.com/crm-general-license
 */

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

class Register extends Model
{
    
    public $email;
    
    public $password;
    
    public $firstName;
    
    public $lastName;
    
    public $phone;
    
    public $remember;
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password', 'firstName'], 'required'],
            [['firstName', 'lastName', 'password', 'phone'], 'string'],
            ['email', 'email'],
            ['remember', 'boolean'],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => User::class, 'message' => 'Account already exists'],
        ];
    }
    
    /**
     * Logs in a user using the provided email and password.
     * @return bool whether the user is logged in successfully
     */
    public function up()
    {
        if(!$this->validate()) {
            return false;
        }
        $user = new User;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->password = $this->password;
        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        
        if($user->save()) {
            return Yii::$app->user->login($user, $this->remember ? getenv('SESSION_DURATION') : 0);
            
        }
        
        return false;
        
    }
}
