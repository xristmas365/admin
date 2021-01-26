<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article}}`.
 */
class m210125_090911_create_article_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%article}}', [
            'id'              => $this->primaryKey(),
            'section_id'      => $this->integer(),
            'title'           => $this->string(),
            'slug'            => $this->string(),
            'description'     => $this->text(),
            'content'         => $this->text(),
            'seo_description' => $this->string(),
            'seo_keywords'    => $this->string(),
            'draft'           => $this->boolean()->notNull()->defaultValue(false),
            'created_at'      => $this->integer(10),
            'updated_at'      => $this->integer(10),
            'created_by'      => $this->integer(),
            'updated_by'      => $this->integer(),
        ]);
        
        $this->addForeignKey('fk-article-section', '{{%article}}', 'section_id', '{{%section}}', 'id', 'SET NULL', 'NO ACTION');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }
}
