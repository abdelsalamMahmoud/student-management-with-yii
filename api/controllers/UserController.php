<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use Yii;

class UserController extends Controller
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
        $users = User::find()->all();
        return array_map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        }, $users);
    }

    /**
     * View a single user
     * GET /user/{id}
     */
    public function actionView($id)
    {
        $user = $this->findModel($id);
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ];
    }

    public function actionCreate()
    {
        $user = new User();
        $user->load(Yii::$app->request->post(), '');
        if ($user->save()) {
            Yii::$app->response->setStatusCode(201);
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        } else {
            Yii::$app->response->setStatusCode(422);
            return ['errors' => $user->getErrors()];
        }
    }

    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $user->load(Yii::$app->request->post(), '');
        if ($user->save()) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        } else {
            Yii::$app->response->setStatusCode(422);
            return ['errors' => $user->getErrors()];
        }
    }

    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        if ($user->delete()) {
            Yii::$app->response->setStatusCode(204); // No Content
            return null;
        } else {
            throw new \yii\web\ServerErrorHttpException('Failed to delete the user.');
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested user does not exist.');
    }
}