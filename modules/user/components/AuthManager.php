<?php

/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\user\components;

use Yii;
use yii\base\Component;
use app\modules\user\models\Role;
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
        
        
        if(key_exists($permissionName, Role::config())) {
            return $this->checkRoleAccess(Yii::$app->user->identity->role, $permissionName);
        }
        
        return false;
        
    }
    
    protected function checkRoleAccess($role, $permissionName)
    {
        if($role === $permissionName) {
            return true;
        }
        
        
        if(!key_exists('access', Role::config($role))) {
            return false;
        }
        
        foreach(Role::config($role)['access'] as $child) {
            if($this->checkRoleAccess($child, $permissionName)) {
                return true;
            }
        }
        
        return false;
        
    }
    
}
