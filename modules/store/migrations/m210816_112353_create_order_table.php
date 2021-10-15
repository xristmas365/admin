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
 * Handles the creation of table `{{%order}}`.
 */
class m210816_112353_create_order_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id'              => $this->primaryKey(),
            'coupon_id'       => $this->integer(),
            'created_at'      => $this->integer(),
            'created_by'      => $this->integer(),
            'sum'             => $this->float(2),
            'coupon_discount' => $this->float(2),
            'tax'             => $this->float(2),
            'total'           => $this->float(2),
            'status'          => $this->integer(),
        ]);
        
        Yii::$app->db->createCommand('ALTER SEQUENCE order_id_seq RESTART WITH 1000000;')->execute();
        
        $this->createTable('{{%order_product}}', [
            'id'              => $this->primaryKey(),
            'order_id'        => $this->integer(),
            'product_id'      => $this->integer(),
            'price'           => $this->float(2),
            'coupon_discount' => $this->float(2),
            'tax'             => $this->float(2),
            'quantity'        => $this->integer(),
            'sum'             => $this->float(2),
        ]);
        
        $this->addForeignKey('fk-order_product-order', '{{%order_product}}', 'order_id', '{{%order}}', 'id', 'CASCADE');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_product}}');
        $this->dropTable('{{%order}}');
    }
}
