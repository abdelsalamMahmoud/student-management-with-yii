<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\Grade;
use yii\web\NotFoundHttpException;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use Yii;

class GradeController extends Controller
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
        $grades = Grade::find()->with(['user', 'course'])->all();
        return array_map(function ($grade) {
            return [
                'id' => $grade->id,
                'user' => [
                    'id' => $grade->user->id,
                    'username' => $grade->user->username,
                ],
                'course' => [
                    'id' => $grade->course->id,
                    'title' => $grade->course->title,
                ],
                'grade' => $grade->grade,
                'assigned_at' => $grade->assigned_at,
            ];
        }, $grades);
    }

    public function actionView($id)
    {
        $grade = $this->findModel($id);
        return [
            'id' => $grade->id,
            'user' => [
                'id' => $grade->user->id,
                'username' => $grade->user->username,
            ],
            'course' => [
                'id' => $grade->course->id,
                'title' => $grade->course->title,
            ],
            'grade' => $grade->grade,
            'assigned_at' => $grade->assigned_at,
        ];
    }

    public function actionCreate()
    {
        $grade = new Grade();
        $grade->load(Yii::$app->request->post(), '');
        if ($grade->save()) {
            Yii::$app->response->setStatusCode(201);
            return [
                'id' => $grade->id,
                'user_id' => $grade->user_id,
                'course_id' => $grade->course_id,
                'grade' => $grade->grade,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $grade->getErrors()];
    }

    public function actionUpdate($id)
    {
        $grade = $this->findModel($id);
        $grade->load(Yii::$app->request->post(), '');
        if ($grade->save()) {
            return [
                'id' => $grade->id,
                'user_id' => $grade->user_id,
                'course_id' => $grade->course_id,
                'grade' => $grade->grade,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $grade->getErrors()];
    }

    public function actionDelete($id)
    {
        $grade = $this->findModel($id);
        if ($grade->delete()) {
            Yii::$app->response->setStatusCode(204);
            return null;
        }
        throw new \yii\web\ServerErrorHttpException('Failed to delete the grade.');
    }

    protected function findModel($id)
    {
        if (($model = Grade::find()->where(['id' => $id])->with(['user', 'course'])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested grade does not exist.');
    }
}