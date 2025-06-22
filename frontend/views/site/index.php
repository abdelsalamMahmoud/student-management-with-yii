<?php

/** @var yii\web\View $this */

$this->title = 'Student Management';
?>
<div class="container py-5">
    <div class="row align-items-center">
        <!-- Text Section -->
        <div class="col-md-6 text-center text-md-start">
            <h1 class="display-4 fw-bold mb-4">Welcome to Your Student Management System</h1>
            <p class="lead mb-4">
                A powerful platform to manage students, teachers, courses, and schedules – all in one place.
            </p>
            <ul class="list-unstyled mb-4">
                <li>✅ Track student performance</li>
                <li>✅ Manage attendance and grades</li>
                <li>✅ Assign teachers and monitor progress</li>
            </ul>
            <p class="text-muted">Start organizing your educational institution efficiently today.</p>
        </div>

        <!-- Image Section -->
        <div class="col-md-6 text-center">
            <img src="<?= Yii::getAlias('@web') ?>/images/school_software_1.png"
                 alt="Student Management" class="img-fluid" style="max-height: 400px;">
        </div>
    </div>
</div>
