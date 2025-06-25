<?php
namespace backend\controllers;

use Yii;
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
            'verbs' => [ 'class' => VerbFilter::class, 'actions' => ['delete-course' => ['POST']] ],
        ];
    }

    public function actionDashboard()
    {
        $students = User::find()->where(['role' => 'student'])->count();
        $teachers = User::find()->where(['role' => 'teacher'])->count();
        $courses = Course::find()->count();
        $registrations = Registration::find()->count();

        return $this->render('dashboard', compact('students', 'teachers', 'courses', 'registrations'));
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
