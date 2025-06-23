<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

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
            [['uploaded_by', 'course_id'], 'required'],
            [['uploaded_by', 'course_id', 'created_at'], 'integer'],
            [['filename'], 'file',
                'skipOnEmpty' => false,
                'extensions' => 'pdf, doc, docx, jpg, png, jpeg',
                'maxSize' => 10 * 1024 * 1024,
                'checkExtensionByMimeType' => true
            ],
            [['filepath', 'type'], 'string', 'max' => 255],
            [['created_at'], 'default', 'value' => time()],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $file = UploadedFile::getInstance($this, 'filename');
            if ($file) {
                $this->filename = $file->baseName; // Original name
                $this->type = $file->type;
                $newName = Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $this->filepath = '/uploads/' . $newName;

                $path = Yii::getAlias('@frontend/web/uploads/') . $newName;
                return $file->saveAs($path);
            }
        }
        return false;
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
