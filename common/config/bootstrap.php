<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@api', dirname(dirname(__DIR__)).'/api');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

//Yii::setAlias('@apiUrl', getenv('API_HOST_INFO') . getenv('API_BASE_URL'));

