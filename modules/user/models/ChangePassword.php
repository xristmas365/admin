<?php
/**
 * ChangePassword.php
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

class ChangePassword extends Model
{
    
    public $password;
    
    public $new_password;
    
    public $new_password_confirm;
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'new_password', 'new_password_confirm'], 'required'],
            [['password', 'new_password', 'new_password_confirm'], 'string', 'min' => 6],
            ['new_password_confirm', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }
    
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        
        /**
         * @var $user User
         */
        $user = Yii::$app->user->identity;
        
        if(!Yii::$app->security->validatePassword($this->password, $user->password)) {
            $this->addError('password', 'Invalid password');
            
            return false;
        }
        
        return $user->updateAttributes(['password' => Yii::$app->security->generatePasswordHash($this->new_password)]);
        
    }
}
