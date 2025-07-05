<?php
namespace api\controllers;

use yii\rest\Controller;
use common\models\File;
use yii\web\NotFoundHttpException;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;

class FileController extends Controller
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
        $files = File::find()->with(['course', 'teacher'])->all();
        return array_map(function ($file) {
            return [
                'id' => $file->id,
                'course' => [
                    'id' => $file->course->id,
                    'title' => $file->course->title,
                ],
                'teacher' => [
                    'id' => $file->teacher->id,
                    'username' => $file->teacher->username,
                ],
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
                'uploaded_at' => $file->uploaded_at,
            ];
        }, $files);
    }

    public function actionView($id)
    {
        $file = $this->findModel($id);
        return [
            'id' => $file->id,
            'course' => [
                'id' => $file->course->id,
                'title' => $file->course->title,
            ],
            'teacher' => [
                'id' => $file->teacher->id,
                'username' => $file->teacher->username,
            ],
            'file_name' => $file->file_name,
            'file_path' => $file->file_path,
            'uploaded_at' => $file->uploaded_at,
        ];
    }

    public function actionCreate()
    {
        $file = new File();
        $file->load(Yii::$app->request->post(), '');
        $uploadedFile = UploadedFile::getInstanceByName('file');
        if ($uploadedFile) {
            $file->file_name = $uploadedFile->name;
            $file->file_path = 'uploads/' . time() . '_' . $uploadedFile->name;
            $uploadedFile->saveAs(Yii::getAlias('@api/web/' . $file->file_path));
        }
        if ($file->save()) {
            Yii::$app->response->setStatusCode(201);
            return [
                'id' => $file->id,
                'course_id' => $file->course_id,
                'teacher_id' => $file->teacher_id,
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $file->getErrors()];
    }

    public function actionUpdate($id)
    {
        $file = $this->findModel($id);
        $file->load(Yii::$app->request->post(), '');
        $uploadedFile = UploadedFile::getInstanceByName('file');
        if ($uploadedFile) {
            $file->file_name = $uploadedFile->name;
            $file->file_path = 'uploads/' . time() . '_' . $uploadedFile->name;
            $uploadedFile->saveAs(Yii::getAlias('@api/web/' . $file->file_path));
        }
        if ($file->save()) {
            return [
                'id' => $file->id,
                'course_id' => $file->course_id,
                'teacher_id' => $file->teacher_id,
                'file_name' => $file->file_name,
                'file_path' => $file->file_path,
            ];
        }
        Yii::$app->response->setStatusCode(422);
        return ['errors' => $file->getErrors()];
    }

    public function actionDelete($id)
    {
        $file = $this->findModel($id);
        $filePath = Yii::getAlias('@api/web/' . $file->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        if ($file->delete()) {
            Yii::$app->response->setStatusCode(204);
            return null;
        }
        throw new \yii\web\ServerErrorHttpException('Failed to delete the file.');
    }

    protected function findModel($id)
    {
        if (($model = File::find()->where(['id' => $id])->with(['course', 'teacher'])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested file does not exist.');
    }
}