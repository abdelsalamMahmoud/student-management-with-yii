<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class TeacherController extends Controller
{
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
                            return \Yii::$app->user->identity->role === 'teacher';
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
}
