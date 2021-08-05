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
 * Handles the creation of table `{{%article_section}}`.
 */
class m210125_090138_create_topic_table extends Migration
{
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%topic}}', [
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
        $this->dropTable('{{%topic}}');
    }
}
