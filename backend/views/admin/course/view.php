<?php
use yii\helpers\Html;

$this->title = $model->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<p><strong>Description:</strong> <?= Html::encode($model->description) ?></p>
<p><strong>Teacher:</strong> <?= Html::encode($model->teacher->username ?? '-') ?></p>

<p>
    <?= Html::a('Edit', ['course-update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    <?= Html::a('Delete', ['delete-course', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data-method' => 'post',
        'data-confirm' => 'Are you sure?',
    ]) ?>
    <?= Html::a('Back to List', ['course-index'], ['class' => 'btn btn-secondary']) ?>
