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
use Mailgun\Mailgun;

class Register extends Model
{
    
    public $email;
    
    public $password;
    
    public $name;
    
    public $phone;
    
    public $company;
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password', 'name'], 'required'],
            [['name', 'password', 'phone', 'company'], 'string'],
            ['email', 'email'],
            ['email', 'unique', 'targetAttribute' => 'email', 'targetClass' => User::class, 'message' => 'Account already exists'],
            ['company', 'unique', 'targetAttribute' => 'email', 'targetClass' => User::class, 'message' => 'Company already exists'],
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
        $user->company = $this->company;
        $user->phone = $this->phone;
        $user->password = $this->password;
        $user->name = $this->name;
        
        if($user->save()) {
            $mg = Mailgun::create(getenv('MAILGUN_KEY'));
            
            $mg->messages()->send(getenv('MAILGUN_DOMAIN'), [
                'from'    => 'security@' . getenv('MAILGUN_DOMAIN'),
                'to'      => $this->email,
                'subject' => 'Account Verification',
                'html'    => Yii::$app->controller->renderPartial('@mail/auth/verify', ['user' => User::findOne(['email' => $this->email])]),
            ]);
            
            return true;
        }
        
        return false;
        
    }
}
