<?php
use yii\helpers\Html;

$this->title = 'All Courses';
?>

<h1><?= $this->title ?></h1>
<p><?= Html::a('Create Course', ['course-create'], ['class' => 'btn btn-success']) ?></p>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>Name</th><th>Teacher</th><th>Created</th><th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($courses as $course): ?>
        <tr>
            <td><?= Html::encode($course->title) ?></td>
            <td><?= Html::encode($course->teacher->username ?? '-') ?></td>
            <td><?= Yii::$app->formatter->asDate($course->created_at) ?></td>
            <td>
                <?= Html::a('View', ['course-view', 'id' => $course->id], ['class' => 'btn btn-sm btn-info']) ?>
                <?= Html::a('Edit', ['course-update', 'id' => $course->id], ['class' => 'btn btn-sm btn-warning']) ?>
                <?= Html::a('Delete', ['delete-course', 'id' => $course->id], [
                    'class' => 'btn btn-sm btn-danger',
                    'data-method' => 'post',
                    'data-confirm' => 'Are you sure?'
                ]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>