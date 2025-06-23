<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Create Course';
?>
<h1><?= $this->title ?></h1>
<?php $f = ActiveForm::begin(); ?>
<?= $f->field($model,'title')->textInput(); ?>
<?= $f->field($model,'description')->textarea(); ?>
<div class="form-group"><?= Html::submitButton('Create',['class'=>'btn btn-success']); ?></div>
<?php ActiveForm::end(); ?>
