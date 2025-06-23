<?php

namespace frontend\controllers;

use common\models\Course;
use common\models\Registration;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class StudentController extends Controller
{
    public function beforeAction($action)
    {
        $this->layout = 'student'; // will use views/layouts/student.php
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['dashboard'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role === 'student';
                        },
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


}
