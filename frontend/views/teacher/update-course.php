<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = $model->isNewRecord ? 'Create Course' : 'Update Course';
?>

<h1><?= $this->title ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'description')->textarea() ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
