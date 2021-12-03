<?php
/**
 * @author    Ann Kononovich <anna.kononovich@gmail.com>
 * @package   Admin AX project
 * @version   2.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */



namespace app\modules\warehouse\models\query;

use Yii;

use yii\db\ActiveQuery;
use app\modules\warehouse\models\Warehouse;

/**
 * This is the ActiveQuery class for [[Warehouse]].
 *
 * @see Warehouse
 */
class WarehouseQuery extends ActiveQuery
{
    
    public function myActive()
    {
        return $this->my()->andWhere([
            'active'  => true,
        ]);
    }
    
    public function my()
    {
        return $this->andWhere([
            'user_id' => Yii::$app->user->id,
        ]);
    }
    
    /**
     * {@inheritdoc}
     * @return Warehouse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
    
    /**
     * {@inheritdoc}
     * @return Warehouse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
