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
 * Handles the creation of table `{{%page}}`.
 */
class m200625_193344_create_page_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%page}}', [
            'id'              => $this->primaryKey(),
            'title'           => $this->string(),
            'description'     => $this->string(),
            'content'         => $this->text(),
            'created_at'      => $this->integer(),
            'updated_at'      => $this->integer(),
            'created_by'      => $this->integer(),
            'updated_by'      => $this->integer(),
            'seo_keywords'    => $this->string(),
            'seo_description' => $this->string(),
            'slug'            => $this->string(),
            'draft'           => $this->boolean()->defaultValue(false),
        ]);
        
        $this->addForeignKey('fk-page-creator', '{{%page}}', 'created_by', 'user', 'id', 'SET NULL');
        $this->addForeignKey('fk-page-updater', '{{%page}}', 'updated_by', 'user', 'id', 'SET NULL');
        
        $this->createIndex('idx', '{{%page}}', 'slug');
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }
}
