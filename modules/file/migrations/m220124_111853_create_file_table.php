<?php
/**
 * @author    Ann Kononovich <anna.kononovich@gmail.com>
 * @package   Admin AX project
 * @version   2.0
 * @copyright Copyright (c) 2022, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m220124_111853_create_file_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(255),
            'size'        => $this->integer(),
            'ext'         => $this->string(10),
            'url'         => $this->string(),
            'created_at'  => $this->integer(),
            'created_by'  => $this->integer(),
            'uploaded_at' => $this->integer(),
            'uploaded_by' => $this->integer(),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%file}}');
    }
}
