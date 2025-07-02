<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Available Courses';
?>
<h1>Available Courses</h1>
<table class="table">
    <thead>
    <tr>
        <th>Course</th>
        <th>Teacher</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= Html::encode($course->title) ?></td>
            <td><?= Html::encode($course->teacher->username ?? 'N/A') ?></td>
            <td>
                <?= Html::a('Register', ['register', 'id' => $course->id], ['class' => 'btn btn-success']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
