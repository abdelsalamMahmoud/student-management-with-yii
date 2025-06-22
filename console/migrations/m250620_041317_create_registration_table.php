<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%registration}}`.
 */
class m250620_041317_create_registration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%registration}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer()->notNull(),
            'course_id' => $this->integer()->notNull(),
            'registered_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-registration-student', 'registration', 'student_id', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk-registration-course', 'registration', 'course_id', 'course', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%registration}}');
    }
}
