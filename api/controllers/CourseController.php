<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\Course;
use yii\web\NotFoundHttpException;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use Yii;

class CourseController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $courses = Course::find()->with('teacher')->all();
        return array_map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'teacher' => [
                    'id' => $course->teacher->id,
                    'username' => $course->teacher->username,
                ],
            ];
        }, $courses);
    }

    public function actionView($id)
    {
        $course = $this->findModel($id);
        return [
            'id' => $course->id,
            'title' => $course->title,
            'description' => $course->description,
            'teacher' => [
                'id' => $course->teacher->id,
                'username' => $course->teacher->username,
            ],
        ];
    }

    public function actionCreate()
    {
        $course = new Course();
        $course->load(Yii::$app->request->post(), '');
        if ($course->save()) {
            Yii::$app->response->setStatusCode(201);
            return [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'teacher_id' => $course->teacher_id,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $course->getErrors()];
    }

    public function actionUpdate($id)
    {
        $course = $this->findModel($id);
        $course->load(Yii::$app->request->post(), '');
        if ($course->save()) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'teacher_id' => $course->teacher_id,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $course->getErrors()];
    }

    public function actionDelete($id)
    {
        $course = $this->findModel($id);
        if ($course->delete()) {
            Yii::$app->response->setStatusCode(204);
            return null;
        }
        throw new \yii\web\ServerErrorHttpException('Failed to delete the course.');
    }

    protected function findModel($id)
    {
        if (($model = Course::find()->where(['id' => $id])->with('teacher')->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested course does not exist.');
    }
}