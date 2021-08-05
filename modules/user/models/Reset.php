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

class Reset extends Model
{
    
    public $email;
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetAttribute' => 'email', 'targetClass' => User::class, 'message' => 'Account not Found'],
        ];
    }
    
    public function reset()
    {
        if(!$this->validate()) {
            return false;
        }
        
        $mg = Mailgun::create(getenv('MAILGUN_KEY'));
        
        $mg->messages()->send(getenv('MAILGUN_DOMAIN'), [
            'from'    => 'security@' . getenv('MAILGUN_DOMAIN'),
            'to'      => $this->email,
            'subject' => 'Reset Password',
            'html'    => Yii::$app->controller->renderPartial('@mail/auth/reset', ['user' => User::findOne(['email' => $this->email])]),
        ]);
        
        return true;
        
    }
}
