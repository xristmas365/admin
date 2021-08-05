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
 * Handles the creation of table `{{%catalog}}`.
 */
class m200626_090117_create_catalog_table extends Migration
{
    
    public $table = '{{%catalog}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id'            => $this->bigPrimaryKey(),
            'root'          => $this->integer(),
            'lft'           => $this->integer()->notNull(),
            'rgt'           => $this->integer()->notNull(),
            'lvl'           => $this->smallInteger(5)->notNull(),
            'name'          => $this->string(60)->notNull(),
            'icon'          => $this->string(255),
            'slug'          => $this->string(255),
            'icon_type'     => $this->smallInteger(1)->notNull()->defaultValue(1),
            'child_allowed' => $this->boolean()->notNull()->defaultValue(true),
            'active'        => $this->boolean()->notNull()->defaultValue(true),
            'selected'      => $this->boolean()->notNull()->defaultValue(false),
            'disabled'      => $this->boolean()->notNull()->defaultValue(false),
            'readonly'      => $this->boolean()->notNull()->defaultValue(false),
            'visible'       => $this->boolean()->notNull()->defaultValue(true),
            'collapsed'     => $this->boolean()->notNull()->defaultValue(false),
            'movable_u'     => $this->boolean()->notNull()->defaultValue(true),
            'movable_d'     => $this->boolean()->notNull()->defaultValue(true),
            'movable_l'     => $this->boolean()->notNull()->defaultValue(true),
            'movable_r'     => $this->boolean()->notNull()->defaultValue(true),
            'removable'     => $this->boolean()->notNull()->defaultValue(true),
            'removable_all' => $this->boolean()->notNull()->defaultValue(true),
        ]);
        $this->createIndex('tree_NK1', $this->table, 'root');
        $this->createIndex('tree_NK2', $this->table, 'lft');
        $this->createIndex('tree_NK3', $this->table, 'rgt');
        $this->createIndex('tree_NK4', $this->table, 'lvl');
        $this->createIndex('tree_NK5', $this->table, 'active');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%catalog}}');
    }
}
