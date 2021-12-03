<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\warehouse\models\query;

use yii\db\ActiveQuery;
use app\modules\warehouse\models\ProductWarehouse;

/**
 * This is the ActiveQuery class for [[ProductWarehouse]].
 *
 * @see ProductWarehouse
 */
class ProductWarehouseQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductWarehouse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductWarehouse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
