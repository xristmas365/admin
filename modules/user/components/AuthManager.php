<?php

/**
 * AuthManager.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\user\components;

use Yii;
use yii\base\Component;
use app\modules\user\models\User;
use yii\rbac\CheckAccessInterface;

/**
 * Class AuthManager
 * @package app\components
 */
class AuthManager extends Component implements CheckAccessInterface
{
    
    
    /**
     * @param int|string $userId
     * @param string     $permissionName
     * @param array      $params
     *
     * @return bool
     */
    public function checkAccess($userId, $permissionName, $params = [])
    {
        if(Yii::$app->user->isGuest) {
            return false;
        }
        
        if(key_exists($permissionName, User::roles())) {
            return $this->checkRoleAccess(Yii::$app->user->identity->role, $permissionName);
        }
        
        return false;
        
    }
    
    protected function checkRoleAccess($role, $permissionName)
    {
        if($role === $permissionName) {
            return true;
        }
        
        if(key_exists('access', User::roles()[$role])) {
            foreach(User::roles()[$role]['access'] as $child) {
                if($this->checkRoleAccess($child, $permissionName)) {
                    return true;
                }
            }
        }
        
        return false;
        
    }
    
}
