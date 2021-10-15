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

/**
 * Class ChangePassword changes password from admin page for all users
 *
 * @property string $password
 * @property string $new_password
 * @property string $new_password_confirm
 * @property User   $user
 *
 * @package app\modules\user\models
 *
 */
class NewPassword extends Model
{
    
    public $new_password;
    
    public $new_password_confirm;
    
    public $user;
    
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['new_password', 'new_password_confirm'], 'required'],
            [['new_password', 'new_password_confirm'], 'string', 'min' => 6],
            ['new_password_confirm', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }
    
    public function save()
    {
        if(!$this->validate()) {
            return false;
        }
        
        return $this->user->updateAttributes(['password' => Yii::$app->security->generatePasswordHash($this->new_password)]);
        
    }
}
