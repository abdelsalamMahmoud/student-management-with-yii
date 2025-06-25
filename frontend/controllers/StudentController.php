<?php

namespace frontend\controllers;

use common\components\AccessRule;
use common\models\Course;
use common\models\File;
use common\models\Registration;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class StudentController extends Controller
{
    public function beforeAction($action)
    {
        $this->layout = 'student';
        return parent::beforeAction($action);
    }

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
                        'roles' => ['student'],
                    ],
                ],
            ],
        ];
    }

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    public function actionAvailableCourses()
    {
        $studentId = Yii::$app->user->id;

        $registeredCourseIds = Registration::find()
            ->select('course_id')
            ->where(['student_id' => $studentId])
            ->column();

        $courses = Course::find()
            ->where(['not in', 'id', $registeredCourseIds])
            ->with('teacher') // if relation defined
            ->all();

        return $this->render('available-courses', [
            'courses' => $courses,
        ]);
    }


    public function actionRegister($id)
    {
        $registration = new Registration();
        $registration->student_id = Yii::$app->user->id;
        $registration->course_id = $id;
        $registration->registered_at = time();
        $registration->save();

        return $this->redirect(['student/my-courses']);
    }

    public function actionMyCourses()
    {
        $studentId = Yii::$app->user->id;

        $registrations = Registration::find()
            ->where(['student_id' => $studentId])
            ->with(['course.teacher', 'grades']) // eager load grades
            ->all();

        return $this->render('my-courses', [
            'registrations' => $registrations,
        ]);
    }

    public function actionCourseFiles($id)
    {
        $studentId = Yii::$app->user->id;

        $isEnrolled = Registration::find()
            ->where(['course_id' => $id, 'student_id' => $studentId])
            ->exists();

        if (!$isEnrolled) {
            throw new \yii\web\ForbiddenHttpException("You are not enrolled in this course.");
        }

        $course = Course::findOne($id);
        if (!$course) {
            throw new \yii\web\NotFoundHttpException("Course not found.");
        }

        $files = $course->files;

        return $this->render('course_files', [
            'course' => $course,
            'files' => $files,
        ]);
    }

    public function actionDownload($id)
    {
        $file = File::findOne($id);
        if (!$file) {
            throw new \yii\web\NotFoundHttpException('File not found.');
        }

        $course = $file->course;

        if (!$this->isStudentEnrolledInCourse($course->id)) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to access this file.');
        }

        $path = Yii::getAlias('@frontend/web' . $file->filepath);
        if (!file_exists($path)) {
            throw new \yii\web\NotFoundHttpException('The file does not exist on the server.');
        }

        return Yii::$app->response->sendFile($path, $file->filename);
    }

    protected function isStudentEnrolledInCourse($courseId)
    {
        return Registration::find()
            ->where(['course_id' => $courseId, 'student_id' => Yii::$app->user->id])
            ->exists();
    }


}
