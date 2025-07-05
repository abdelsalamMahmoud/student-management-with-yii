<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\Registration;
use yii\web\NotFoundHttpException;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use Yii;

class RegistrationController extends Controller
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
        $registrations = Registration::find()->with(['user', 'course'])->all();
        return array_map(function ($registration) {
            return [
                'id' => $registration->id,
                'user' => [
                    'id' => $registration->user->id,
                    'username' => $registration->user->username,
                ],
                'course' => [
                    'id' => $registration->course->id,
                    'title' => $registration->course->title,
                ],
                'enrolled_at' => $registration->enrolled_at,
            ];
        }, $registrations);
    }

    public function actionView($id)
    {
        $registration = $this->findModel($id);
        return [
            'id' => $registration->id,
            'user' => [
                'id' => $registration->user->id,
                'username' => $registration->user->username,
            ],
            'course' => [
                'id' => $registration->course->id,
                'title' => $registration->course->title,
            ],
            'enrolled_at' => $registration->enrolled_at,
        ];
    }

    public function actionCreate()
    {
        $registration = new Registration();
        $registration->load(Yii::$app->request->post(), '');
        if ($registration->save()) {
            Yii::$app->response->setStatusCode(201);
            return [
                'id' => $registration->id,
                'user_id' => $registration->user_id,
                'course_id' => $registration->course_id,
                'enrolled_at' => $registration->enrolled_at,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $registration->getErrors()];
    }

    public function actionUpdate($id)
    {
        $registration = $this->findModel($id);
        $registration->load(Yii::$app->request->post(), '');
        if ($registration->save()) {
            return [
                'id' => $registration->id,
                'user_id' => $registration->user_id,
                'course_id' => $registration->course_id,
                'enrolled_at' => $registration->enrolled_at,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $registration->getErrors()];
    }

    public function actionDelete($id)
    {
        $registration = $this->findModel($id);
        if ($registration->delete()) {
            Yii::$app->response->setStatusCode(204);
            return null;
        }
        throw new \yii\web\ServerErrorHttpException('Failed to delete the registration.');
    }

    protected function findModel($id)
    {
        if (($model = Registration::find()->where(['id' => $id])->with(['user', 'course'])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested registration does not exist.');
    }
}