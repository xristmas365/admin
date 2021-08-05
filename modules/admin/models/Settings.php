<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

class Settings extends Model
{
    
    //public function init()
    //{
    //    //$file = Yii::getAlias('@app/config/settings.json');
    //    //$content = Json::decode(file_get_contents($file));
    //    //foreach($content as $key => $value) {
    //    //    $this->{$key} = $value;
    //    //}
    //    //dd($this->attributes());
    //    parent::init();
    //}
    
    public function attributes()
    {
        //$class = new \ReflectionClass($this);
        $names = [];
        //foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
        //    if (!$property->isStatic()) {
        //        $names[] = $property->getName();
        //    }
        //}
        $file = Yii::getAlias('@app/config/settings.json');
        $content = Json::decode(file_get_contents($file));
        foreach($content as $key => $value) {
            $names[] = $key;
        }
        
        return $names;
    }
}
