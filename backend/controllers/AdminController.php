<?php
namespace backend\controllers;

use common\components\AccessRule;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Course;
use common\models\Registration;

class AdminController extends Controller
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
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionDashboard()
    {
        $studentCount = User::find()->where(['role' => 'student'])->count();
        $teacherCount = User::find()->where(['role' => 'teacher'])->count();
        $courseCount = Course::find()->count();
        $registrationCount = Registration::find()->count();

        return $this->render('dashboard', [
            'labels' => ['Students', 'Teachers', 'Courses', 'Registrations'],
            'data' => [$studentCount, $teacherCount, $courseCount, $registrationCount],
        ]);
    }


    public function actionCourseIndex()
    {
        $courses = Course::find()->with('teacher')->all();
        return $this->render('course/index', compact('courses'));
    }

    public function actionCourseView($id)
    {
        return $this->render('course/view', ['model' => $this->findCourse($id)]);
    }

    public function actionCourseCreate()
    {
        $model = new Course();
        $model->teacher_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['course-view', 'id' => $model->id]);
        }

        return $this->render('course/create', compact('model'));
    }

    public function actionCourseUpdate($id)
    {
        $model = $this->findCourse($id);
        $teachers = User::find()->where(['role' => 'teacher'])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['course-view', 'id' => $model->id]);
        }

        return $this->render('course/update', compact('model', 'teachers'));
    }

    public function actionDeleteCourse($id)
    {
        $this->findCourse($id)?->delete();
        return $this->redirect(['course-index']);
    }

    protected function findCourse($id)
    {
        return Course::findOne($id) ?? throw new NotFoundHttpException('Course not found.');
    }
}
