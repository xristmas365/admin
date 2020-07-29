<?php
/**
 * m191215_132627_create_storage_table.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

use yii\db\Migration;

/**
 * Handles the creation of table `{{%storage}}`.
 */
class m191215_132627_create_storage_table extends Migration
{
    
    public $table = '{{%storage}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id'         => $this->primaryKey(),
            'model_id'   => $this->integer(),
            'model_name' => $this->string(255),
            'path'       => $this->string(255),
            'base_url'   => $this->string(255),
            'type'       => $this->string(32),
            'size'       => $this->integer(),
            'name'       => $this->string(255),
            'created_at' => $this->integer(10),
            'created_by' => $this->integer(),
        ]);
        
        $this->createIndex('idx-storage-src', $this->table, ['model_id', 'model_name']);
        $this->addForeignKey('fk-storage-user', $this->table, 'created_by', 'user', 'id', 'SET NULL');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
