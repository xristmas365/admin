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
            'auth_key' => Yii::$app->security->generateRandomString(),
        ], ['auth_key' => $this->auth]);
    }
}
