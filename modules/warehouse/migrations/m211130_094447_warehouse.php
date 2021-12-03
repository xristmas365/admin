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
 * Class m211130_094447_warehouse
 */
class m211130_094447_warehouse extends Migration
{
    /**
     * {@inheritdoc}
     */
 
    public function safeUp()
    {
        $this->createTable('{{%warehouse}}', [
            'id'      => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name'    => $this->string(),
            'zip'     => $this->string(6),
            'city'    => $this->string(),
            'address' => $this->string(),
            'state'   => $this->string(2),
            'active'  => $this->boolean()->notNull()->defaultValue(true),
        ]);
    
        $this->addForeignKey('fk-warehouse-user', '{{%warehouse}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%warehouse}}');
    }
}
