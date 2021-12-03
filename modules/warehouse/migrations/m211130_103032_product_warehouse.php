<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\db\Migration;

/**
 * Class m211130_103032_product_warehouse
 */
class m211130_103032_product_warehouse extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_warehouse}}', [
            'id'            => $this->primaryKey(),
            'product_id'    => $this->integer(),
            'warehouse_id'  => $this->integer(),
            'quantity'      => $this->float(2)->notNull(),
            'status'        => $this->smallInteger(1),
            'price'         => $this->float(2),
            'total'         => $this->float(2),
            'created_at'    => $this->integer()
        ]);
    
        $this->addForeignKey('fk-product_warehouse-product', '{{%product_warehouse}}', 'product_id', '{{%product}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_warehouse-warehouse', '{{%product_warehouse}}', 'warehouse_id', '{{%warehouse}}', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_warehouse}}');
    }

    
}
