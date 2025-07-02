<?php
use yii\helpers\Html;

$this->title = "Students in {$course->title}";
?>
<h1><?= Html::encode($this->title) ?></h1>

<table class="table">
    <thead>
    <tr>
        <th>Student</th>
        <th>Registered At</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td><?= Html::encode($registration->student->username) ?></td>
            <td><?= Yii::$app->formatter->asDatetime($registration->registered_at) ?></td>
            <td>
                <?= Html::a('Add Grade', ['add-grade', 'registration_id' => $registration->id], ['class' => 'btn btn-sm btn-primary']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
