<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property int $uploaded_by
 * @property string $filename
 * @property string $filepath
 * @property string|null $type
 * @property int|null $course_id
 * @property int|null $created_at
 *
 * @property Course $course
 * @property User $uploadedBy
 */
class File extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'course_id', 'created_at'], 'default', 'value' => null],
            [['uploaded_by', 'filename', 'filepath'], 'required'],
            [['uploaded_by', 'course_id', 'created_at'], 'integer'],
            [['filename', 'filepath', 'type'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['uploaded_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['uploaded_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uploaded_by' => 'Uploaded By',
            'filename' => 'Filename',
            'filepath' => 'Filepath',
            'type' => 'Type',
            'course_id' => 'Course ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }

    /**
     * Gets query for [[UploadedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUploadedBy()
    {
        return $this->hasOne(User::class, ['id' => 'uploaded_by']);
    }

}
