<?php

$this->title = 'Admin Dashboard';
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js', ['position' => \yii\web\View::POS_END]);
?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">System Statistics</h1>


        <div class="row text-center mb-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-light p-3 shadow rounded">
                    <h4><?= $data[0] ?></h4>
                    <p>Students</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-light p-3 shadow rounded">
                    <h4><?= $data[1] ?></h4>
                    <p>Teachers</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-light p-3 shadow rounded">
                    <h4><?= $data[2] ?></h4>
                    <p>Courses</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-light p-3 shadow rounded">
                    <h4><?= $data[3] ?></h4>
                    <p>Registrations</p>
                </div>
            </div>
        </div>

  
        <div class="card p-4 shadow rounded">
            <canvas id="adminChart" style="max-height: 400px;"></canvas>
        </div>
    </div>

<?php
$jsLabels = json_encode($labels);
$jsData = json_encode($data);

$this->registerJs("
    const ctx = document.getElementById('adminChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: $jsLabels,
            datasets: [{
                label: 'System Stats',
                data: $jsData,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Overview of Platform Stats'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
");
?>