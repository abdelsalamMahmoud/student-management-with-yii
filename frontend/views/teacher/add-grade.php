<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Assign Grade';
?>
<h1><?= $this->title ?></h1>
<?php $f = ActiveForm::begin(); ?>
<?= $f->field($model,'grade_value')->textInput(['type'=>'number','step'=>'0.01']); ?>
<?= $f->field($model,'grade_type')->textInput(); ?>
<div class="form-group"><?= Html::submitButton('Save Grade',['class'=>'btn btn-primary']); ?></div>
<?php ActiveForm::end(); ?>
