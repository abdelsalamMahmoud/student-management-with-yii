<?php

namespace backend\controllers\api;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
}
