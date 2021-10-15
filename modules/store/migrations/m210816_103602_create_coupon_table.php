<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coupon}}`.
 */
class m210816_103602_create_coupon_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coupon}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(),
            'value'      => $this->integer(),
            'token'      => $this->string(),
            'created_by' => $this->integer(),
            'start_date' => $this->integer(),
            'end_date'   => $this->integer(),
            'active'     => $this->boolean()->notNull()->defaultValue(true),
            'deleted'    => $this->boolean()->notNull()->defaultValue(false),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%coupon}}');
    }
}
