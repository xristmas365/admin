<?php
/**
 * Password.php
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

class Password extends Model
{
    
    public $auth;
    
    public $password;
    
    public $password_confirm;
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['password', 'password_confirm'], 'required'],
            [['password', 'password_confirm'], 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }
    
    public function save()
    {
        return User::updateAll([
            'password' => Yii::$app->security->generatePasswordHash($this->password),
            'auth_key' => null,
        ], ['auth_key' => $this->auth]);
    }
}
