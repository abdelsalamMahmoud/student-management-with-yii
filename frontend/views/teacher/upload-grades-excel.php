<?php
$this->title = 'Upload Grades via Excel';
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<h1><?= $this->title ?> for Course #<?= Html::encode($course_id) ?></h1>
<p>You can extend this to parse and import grades from an Excel file.</p>
