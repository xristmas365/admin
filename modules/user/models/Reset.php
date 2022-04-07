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
        
        $user = User::find()->select(['id'])->where(['email' => $this->email])->column();
   
        Yii::$app
            ->email
            ->useTemplateWithKey('Reset')
            ->to($user)
            ->send();
        
        
        return true;
        
    }
}
