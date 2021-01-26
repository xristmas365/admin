<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%article_section}}`.
 */
class m210125_090138_create_section_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%section}}', [
            'id'      => $this->primaryKey(),
            'name'    => $this->string(),
            'slug'    => $this->string(),
            'home'    => $this->boolean()->notNull()->defaultValue(true),
            'visible' => $this->boolean()->notNull()->defaultValue(true),
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%section}}');
    }
}
