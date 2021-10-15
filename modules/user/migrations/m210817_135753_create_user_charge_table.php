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
 * Handles the creation of table `{{%user_charge}}`.
 */
class m210817_135753_create_user_charge_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_charge}}', [
            'id'         => $this->primaryKey(),
            'user_id'    => $this->integer(),
            'order_id'   => $this->integer(),
            'card_id'    => $this->integer(),
            'stripe_id'  => $this->string(),
            'amount'     => $this->float(),
            'paid'       => $this->boolean(),
            'created_at' => $this->integer(),
        ]);
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_charge}}');
    }
}
