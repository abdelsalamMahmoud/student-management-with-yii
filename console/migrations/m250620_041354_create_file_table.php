<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m250620_041354_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'uploaded_by' => $this->integer()->notNull(),
            'filename' => $this->string()->notNull(),
            'filepath' => $this->string()->notNull(),
            'type' => $this->string(),
            'course_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk-file-uploader', 'file', 'uploaded_by', 'user', 'id', 'CASCADE');
        $this->addForeignKey('fk-file-course', 'file', 'course_id', 'course', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%file}}');
    }
}
