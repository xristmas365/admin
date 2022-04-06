<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%email}}`.
 */
class m220406_120028_add_column_to_email_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('email_template', 'template_key', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
