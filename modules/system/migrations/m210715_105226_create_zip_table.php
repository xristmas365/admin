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
 * Handles the creation of table `{{%zip}}`.
 */
class m210715_105226_create_zip_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%zip}}', [
            'id'    => $this->primaryKey(),
            'zip'   => $this->string(5),
            'state' => $this->string(2),
            'city'  => $this->string(255),
        ]);
        
        $this->createIndex('idx-zip', '{{%zip}}', 'zip');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%zip}}');
    }
}
