<?php

use yii\helpers\Html;

$this->title = 'My Courses';
?>
<h1>My Courses & Grades</h1>

<table class="table">
    <thead>
    <tr>
        <th>Course</th>
        <th>Teacher</th>
        <th>Grades</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td><?= Html::encode($registration->course->title) ?></td>
            <td><?= Html::encode($registration->course->teacher->username ?? 'N/A') ?></td>
            <td>
                <?php if (!empty($registration->grades)): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($registration->grades as $grade): ?>
                            <li>
                                <?= Html::encode($grade->grade_type) ?>:
                                <strong><?= Html::encode($grade->grade_value) ?></strong>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <em>No grades yet</em>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
