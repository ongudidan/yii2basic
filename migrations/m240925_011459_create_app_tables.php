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
        // Create user table
        $this->createTable('{{%user}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'username' => $this->string()->notNull()->unique(),
            'verification_token' => $this->string()->defaultValue(null),
            'auth_key' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Create RBAC tables
        $this->createTable('{{%auth_rule}}', [
            'name' => $this->string()->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ]);

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
            'user_id' => $this->string()->notNull(), // Changed to string
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY ([[item_name]]) REFERENCES {{%auth_item}} ([[name]])' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        // Create student table
        $this->createTable('{{%student}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'user_id' => $this->string()->notNull(), // Changed to string
            'admission_no' => $this->string()->notNull(),
            'first_name' => $this->string()->notNull(),
            'middle_name' => $this->string(),
            'last_name' => $this->string()->notNull(),
            'gender' => $this->string(),
            'religion' => $this->string(),
            'date_of_birth' => $this->string(), // Unix timestamp
            'email' => $this->string(),
            'phone' => $this->string(),
            'address' => $this->text(),
            'status' => $this->string(20)->defaultValue('active'), // active, inactive
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY (id)', // Primary key for custom ID
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        // Create guardian table
        $this->createTable('{{%guardian}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'user_id' => $this->string()->notNull(), // Changed to string
            'student_id' => $this->string()->notNull(), // Changed to string
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'relation' => $this->string(), // father, mother, guardian
            'address' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY (id)', // Primary key for custom ID
            'FOREIGN KEY ([[student_id]]) REFERENCES {{%student}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        // Create staff table
        $this->createTable('{{%staff}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'user_id' => $this->string()->notNull(), // Changed to string
            'staff_no' => $this->string()->notNull(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'email' => $this->string()->unique(),
            'phone' => $this->string(),
            'address' => $this->text(),
            'position' => $this->string(), // e.g., teacher, admin
            'status' => $this->string(20)->defaultValue('active'), // active, inactive
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY (id)', // Primary key for custom ID
            'FOREIGN KEY ([[user_id]]) REFERENCES {{%user}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        // Create class table
        $this->createTable('{{%class}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'name' => $this->string()->notNull(),
            'section' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY (id)', // Primary key for custom ID
        ]);

        // Create attendance table
        $this->createTable('{{%attendance}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'student_id' => $this->string()->defaultValue(null), // Changed to string
            'staff_id' => $this->string()->defaultValue(null), // Changed to string
            'class_id' => $this->string()->notNull(),
            'date' => $this->integer()->notNull(), // Unix timestamp
            'status' => $this->string(20)->defaultValue('present'), // present, absent, late
            'remarks' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY (id)', // Primary key for custom ID
            'FOREIGN KEY ([[student_id]]) REFERENCES {{%student}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[staff_id]]) REFERENCES {{%staff}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[class_id]]) REFERENCES {{%class}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        // Create student_class table
        $this->createTable('{{%student_class}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'student_id' => $this->string()->notNull(), // Changed to string
            'class_id' => $this->string()->notNull(), // Changed to string
            'enrollment_date' => $this->integer(), // Unix timestamp
            'academic_year' => $this->string(), // e.g., 2023-2024
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY (id)', // Primary key for custom ID
            'FOREIGN KEY ([[student_id]]) REFERENCES {{%student}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
            'FOREIGN KEY ([[class_id]]) REFERENCES {{%class}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);

        // Create fee_invoice table
        $this->createTable('{{%fee_invoice}}', [
            'id' => $this->string()->notNull()->unique(), // Custom string ID
            'student_id' => $this->string()->notNull(), // Changed to string
            'invoice_date' => $this->integer()->notNull(), // Unix timestamp
            'amount_due' => $this->decimal(10, 2)->notNull(),
            'amount_paid' => $this->decimal(10, 2)->defaultValue(0),
            'status' => $this->string(20)->defaultValue('unpaid'), // unpaid, paid, overdue
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY (id)', // Primary key for custom ID
            'FOREIGN KEY ([[student_id]]) REFERENCES {{%student}} ([[id]]) ' .
                $this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fee_invoice}}');
        $this->dropTable('{{%student_class}}');
        $this->dropTable('{{%attendance}}');
        $this->dropTable('{{%class}}');
        $this->dropTable('{{%staff}}');
        $this->dropTable('{{%guardian}}');
        $this->dropTable('{{%student}}');
        $this->dropTable('{{%auth_assignment}}');
        $this->dropTable('{{%auth_item_child}}');
        $this->dropTable('{{%auth_item}}');
        $this->dropTable('{{%auth_rule}}');
        $this->dropTable('{{%user}}');
    }

    protected function buildFkClause($delete = '', $update = '')
    {
        return implode(' ', ['', $delete, $update]);
    }
}
