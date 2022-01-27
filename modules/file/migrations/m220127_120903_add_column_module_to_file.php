<?php

use yii\db\Migration;

/**
 * Class m220127_120903_add_column_module_to_file
 */
class m220127_120903_add_column_module_to_file extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('file', 'model', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220127_120903_add_column_module_to_file cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220127_120903_add_column_module_to_file cannot be reverted.\n";

        return false;
    }
    */
}
