<?php
/**
 * Reset.php
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
        
        $mg = \Mailgun\Mailgun::create(getenv('MAILGUN_KEY'));
        
        $mg->messages()->send('5th-store.com', [
            'from'    => '5th Store <admin@5th-store.com>',
            'to'      => $this->email,
            'subject' => 'Reset Password',
            'html'    => Yii::$app->controller->renderPartial('@mail/auth/reset', ['user' => User::findOne(['email' => $this->email])]),
        ]);
        
        return true;
        
    }
}
