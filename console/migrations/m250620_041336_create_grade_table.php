<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%grade}}`.
 */
class m250620_041336_create_grade_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%grade}}', [
            'id' => $this->primaryKey(),
            'registration_id' => $this->integer()->notNull(),
            'grade_value' => $this->decimal(5,2)->notNull(),
            'grade_type' => $this->string()->defaultValue('final'),
            'added_by' => $this->integer(), // teacher id (optional)
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk-grade-registration', 'grade', 'registration_id', 'registration', 'id', 'CASCADE');
        $this->addForeignKey('fk-grade-added-by', 'grade', 'added_by', 'user', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%grade}}');
    }
}
