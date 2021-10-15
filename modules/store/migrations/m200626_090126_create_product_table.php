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
 * Handles the creation of table `{{%product}}`.
 */
class m200626_090126_create_product_table extends Migration
{
    
    public $table = '{{%product}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'catalog_id'  => $this->integer(),
            'title'       => $this->string(60),
            'description' => $this->string(255),
            'content'     => $this->text(),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
            'created_by'  => $this->integer(),
            'updated_by'  => $this->integer(),
            'keywords'    => $this->string(255),
            'slug'        => $this->string(255)->unique(),
            'price'       => $this->money(),
            'active'      => $this->boolean()->defaultValue(true),
            'new'         => $this->boolean()->defaultValue(false),
            'popular'     => $this->boolean()->defaultValue(false),
        ]);
        
        $this->addForeignKey('fk-catalog-product', $this->table, 'catalog_id', '{{%catalog}}', 'id', 'SET NULL');
        $this->createIndex('idx-product-slug', $this->table, 'slug');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
