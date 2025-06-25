<?php

namespace frontend\controllers;

use common\components\AccessRule;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['teacher'],
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

    public function actionViewCourse($id)
    {
        $model = Course::findOne($id);
        return $this->render('view-course', ['model' => $model]);
    }

    public function actionUpdateCourse($id)
    {
        $model = $this->findCourse($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-course', 'id' => $model->id]);
        }

        return $this->render('update-course', compact('model'));
    }

    public function actionDeleteCourse($id)
    {
        $course = Course::findOne($id);

        if ($course && $course->teacher_id == Yii::$app->user->id) {
            $course->delete();
            Yii::$app->session->setFlash('success', 'Course deleted successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'You are not allowed to delete this course.');
        }

        return $this->redirect(['dashboard']);
    }

    protected function findCourse($id)
    {
        return Course::findOne($id) ?? throw new NotFoundHttpException('Course not found.');
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

            if ($model->upload() && $model->save(false)) {
                Yii::$app->session->setFlash('success', 'File uploaded successfully!');
                return $this->redirect(['dashboard']);
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

}
