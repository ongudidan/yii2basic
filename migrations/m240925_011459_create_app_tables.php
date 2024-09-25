<?php

use yii\db\Migration;

/**
 * Class m240925_011459_create_app_tables
 */
class m240925_011459_create_app_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'verification_token' => $this->string()->defaultValue(null),

            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Create RBAC tables in correct order
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string()->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ]);

        // Create auth_item table
        $this->createTable('{{%auth_item}}', [
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            'KEY rule_name (rule_name)',
            'KEY type (type)',
        ]);

        // Create auth_item_child table
        $this->createTable('{{%auth_item_child}}', [
            'parent' => $this->string()->notNull(),
            'child' => $this->string()->notNull(),
            'PRIMARY KEY (parent, child)',
            'KEY child (child)',
            'FOREIGN KEY ([[parent]]) REFERENCES {{%auth_item}} ([[name]]) ' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[child]]) REFERENCES {{%auth_item}} ([[name]]) ' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string()->notNull(),
            'user_id' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY ([[item_name]]) REFERENCES {{%auth_item}} ([[name]])' .
            $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop RBAC tables
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%user}}');

    }

    protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }
    
}
