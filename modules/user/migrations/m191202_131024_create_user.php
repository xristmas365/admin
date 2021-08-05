<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

use yii\db\Migration;
use app\modules\user\models\Role;

/**
 * Class m191202_131024_create_user
 */
class m191202_131024_create_user extends Migration
{
    
    public $tableUser = '{{%user}}';
    
    public $tableAuth = '{{%auth}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableUser, [
            'id'            => $this->primaryKey(),
            'email'         => $this->string()->notNull()->unique(),
            'password'      => $this->string(60),
            'blocked'       => $this->boolean()->notNull()->defaultValue(false),
            'confirmed'     => $this->boolean()->notNull()->defaultValue(false),
            'auth_key'      => $this->string(32),
            'role'          => $this->integer()->notNull()->defaultValue(Role::USER),
            'name'          => $this->string(32)->notNull(),
            'company'       => $this->string(),
            'slug'          => $this->string(),
            'phone'         => $this->string(16),
            'address'       => $this->string(60),
            'city'          => $this->string(32),
            'state'         => $this->string(2),
            'zip'           => $this->string(5),
            'created_at'    => $this->integer(10),
            'updated_at'    => $this->integer(10),
            'last_login_at' => $this->integer(10),
        ]);
        
        $this->createIndex('idx-user-auth', $this->tableUser, 'auth_key');
        
        /**
         * User
         */
        $this->insert($this->tableUser, [
            'email'      => 'demo@ax.com',
            'password'   => Yii::$app->security->generatePasswordHash('axdemo*&'),
            'auth_key'   => Yii::$app->security->generateRandomString(),
            'name'       => 'Demo',
            'company'    => 'Demo Company',
            'slug'       => 'demo-company',
            'zip'        => '90025',
            'phone'      => '(123) 123-1234',
            'role'       => Role::USER,
            'state'      => 'CA',
            'city'       => 'Los Angeles',
            'created_at' => time(),
            'updated_at' => time(),
            'confirmed'  => true,
        ]);
        
        /**
         * Admin
         */
        $this->insert($this->tableUser, [
            'email'      => 'admin@ax.com',
            'password'   => Yii::$app->security->generatePasswordHash('axadmin*&'),
            'auth_key'   => Yii::$app->security->generateRandomString(),
            'name'       => 'Admin',
            'zip'        => '90025',
            'state'      => 'CA',
            'city'       => 'Los Angeles',
            'phone'      => '(123) 123-1234',
            'role'       => Role::DEVELOPER,
            'created_at' => time(),
            'updated_at' => time(),
            'confirmed'  => true,
        ]);
        
        $this->createTable($this->tableAuth, [
            'id'        => $this->primaryKey(),
            'user_id'   => $this->integer()->notNull(),
            'source'    => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);
        
        $this->addForeignKey('fk-auth-user', $this->tableAuth, 'user_id', $this->tableUser, 'id', 'CASCADE', 'CASCADE');
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableAuth);
        $this->dropTable($this->tableUser);
    }
}
