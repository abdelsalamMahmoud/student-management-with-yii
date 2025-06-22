<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grade".
 *
 * @property int $id
 * @property int $registration_id
 * @property float $grade_value
 * @property string|null $grade_type
 * @property int|null $added_by
 * @property int|null $created_at
 *
 * @property User $addedBy
 * @property Registration $registration
 */
class Grade extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['added_by', 'created_at'], 'default', 'value' => null],
            [['grade_type'], 'default', 'value' => 'final'],
            [['registration_id', 'grade_value'], 'required'],
            [['registration_id', 'added_by', 'created_at'], 'integer'],
            [['grade_value'], 'number'],
            [['grade_type'], 'string', 'max' => 255],
            [['added_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['added_by' => 'id']],
            [['registration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Registration::class, 'targetAttribute' => ['registration_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration_id' => 'Registration ID',
            'grade_value' => 'Grade Value',
            'grade_type' => 'Grade Type',
            'added_by' => 'Added By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[AddedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddedBy()
    {
        return $this->hasOne(User::class, ['id' => 'added_by']);
    }

    /**
     * Gets query for [[Registration]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegistration()
    {
        return $this->hasOne(Registration::class, ['id' => 'registration_id']);
    }

}
