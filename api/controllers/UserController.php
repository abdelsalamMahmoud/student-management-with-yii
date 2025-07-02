<?php
namespace api\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User'; // Ensure this points to a valid model
}
