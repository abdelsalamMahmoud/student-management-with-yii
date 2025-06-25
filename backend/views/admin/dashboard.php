<?php
$this->title = 'Admin Dashboard';
?>

<h1 class="pb-4 pt-4">Welcome to Admin Dashboard</h1>

<div class="row">
    <div class="col-md-3">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h5>Total Students</h5>
                <h3><?= $students ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5>Total Teachers</h5>
                <h3><?= $teachers ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white mb-3">
            <div class="card-body">
                <h5>Total Courses</h5>
                <h3><?= $courses ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white mb-3">
            <div class="card-body">
                <h5>Total Registrations</h5>
                <h3><?= $registrations ?></h3>
            </div>
        </div>
    </div>
</div>
