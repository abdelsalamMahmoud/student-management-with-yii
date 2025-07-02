<?php

use yii\helpers\Html;

$this->title = 'Files for ' . $course->title;
?>

    <h2><?= Html::encode($this->title) ?></h2>

<?php if (!empty($files)): ?>
    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <?= Html::encode($file->filename) ?>
                <?= Html::a('Download', ['download', 'id' => $file->id], ['class' => 'btn btn-sm btn-success']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p><em>No files available for this course.</em></p>
<?php endif; ?>