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
 * Handles the creation of table `{{%contact}}`.
 */
class m210908_070314_create_contact_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contact}}', [
            'id'         => $this->primaryKey(),
            'email'      => $this->string(),
            'name'       => $this->string(),
            'subject'    => $this->string(),
            'text'       => $this->text(),
            'ip'         => $this->string(),
            'host'       => $this->text(),
            'agent'      => $this->text(),
            'created_at' => $this->integer(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contact}}');
    }
}
