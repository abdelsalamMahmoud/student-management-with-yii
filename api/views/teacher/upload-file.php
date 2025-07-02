<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'id' => 'file-upload-form',
]);
?>

<?= $form->field($model, 'filename')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>