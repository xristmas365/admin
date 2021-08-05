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
            'topic_id'        => $this->integer(),
            'title'           => $this->string(),
            'slug'            => $this->string(),
            'description'     => $this->text(),
            'content'         => $this->text(),
            'seo_description' => $this->string(),
            'seo_keywords'    => $this->string(),
            'visits'          => $this->integer()->defaultValue(0),
            'created_at'      => $this->integer(10),
            'updated_at'      => $this->integer(10),
            'created_by'      => $this->integer(),
            'updated_by'      => $this->integer(),
            'published_at'    => $this->integer(),
        ]);
        
        $this->addForeignKey('fk-article-topic', '{{%article}}', 'topic_id', '{{%topic}}', 'id', 'SET NULL', 'NO ACTION');
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%article}}');
    }
}
