<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use common\models\Course;
use common\models\File;
use common\models\Registration;
use common\models\Grade;

class TeacherController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => fn() => Yii::$app->user->identity->role === 'teacher',
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = 'teacher';
        return parent::beforeAction($action);
    }

    public function actionDashboard()
    {
        $courses = Course::find()
            ->where(['teacher_id' => Yii::$app->user->id])
            ->with('registrations')
            ->all();

        return $this->render('dashboard', compact('courses'));
    }

    public function actionCreateCourse()
    {
        $model = new Course();
        $model->teacher_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['dashboard']);
        }

        return $this->render('create-course', compact('model'));
    }

    public function actionStudents($course_id)
    {
        $course = Course::findOne(['id' => $course_id, 'teacher_id' => Yii::$app->user->id]);
        $registrations = Registration::find()
            ->where(['course_id' => $course_id])
            ->with('student')
            ->all();

        return $this->render('students', compact('course', 'registrations'));
    }

    public function actionUploadFile($course_id)
    {
        $model = new File();
        $model->course_id = $course_id;
        $model->uploaded_by = Yii::$app->user->id;

        if (Yii::$app->request->isPost) {
            $model->filename = UploadedFile::getInstance($model, 'filename');

            if ($model->filename && $model->validate()) {

                $newName = Yii::$app->security->generateRandomString() . '.' . $model->filename->extension;
                $filePath = 'uploads/' . $newName;
                $fullPath = Yii::getAlias('@webroot/') . $filePath;

                if ($model->filename->saveAs($fullPath)) {
                    $model->filepath = '/' . $filePath;
                    $model->type = $model->filename->type;

                    if ($model->save(false)) {
                        Yii::$app->session->setFlash('success', 'File uploaded successfully!');
                        return $this->redirect(['dashboard']);
                    }
                }
            }

            Yii::$app->session->setFlash('error', 'Upload failed: ' . print_r($model->errors, true));
        }

        return $this->render('upload-file', ['model' => $model]);
    }

    public function actionAddGrade($registration_id)
    {
        $model = new Grade();
        $model->registration_id = $registration_id;
        $model->added_by = Yii::$app->user->id;
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['dashboard']);
        }

        return $this->render('add-grade', compact('model'));
    }

    public function actionUploadGradesExcel($course_id)
    {
        return $this->render('upload-grades-excel', compact('course_id'));
    }
}
