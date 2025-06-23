<?php

use yii\helpers\Html;

$this->title = 'Courses Overview';
?>
<h1><?= $this->title ?></h1>
<p>Here are your courses and enrolled students:</p>
<table class="table">
    <thead>
    <tr>
        <th>Course</th>
        <th>Students</th>
        <th>Upload Assignment</th>
        <th>Grades</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= Html::encode($course->title) ?></td>
            <td><?= $course->registrations ? count($course->registrations) : 0 ?></td>
            <td><?= Html::a('Upload', ['upload-file','course_id'=>$course->id], ['class'=>'btn btn-sm btn-info']) ?></td>
            <td><?= Html::a('Manage Grades', ['students','course_id'=>$course->id], ['class'=>'btn btn-sm btn-warning']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>