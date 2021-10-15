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
 * Handles the creation of table `{{%user_payment}}`.
 */
class m210817_134618_create_user_card_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_card}}', [
            'id'      => $this->primaryKey(),
            'user_id' => $this->integer(),
            'source'  => $this->string(),
            'brand'   => $this->string(),
            'country' => $this->string(),
            'number'  => $this->string(),
        ]);
        
        $this->addForeignKey('fk-user_card-user', '{{%user_card}}', 'user_id', '{{%user}}', 'id');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_card}}');
    }
}
