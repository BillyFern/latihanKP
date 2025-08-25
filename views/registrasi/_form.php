<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="registrasi-form">
    <?php $form = ActiveForm::begin([
        'id' => 'registrasi-form',
        'action' => ['registrasi/create'], // points to create action
        'method' => 'post',
    ]); ?>
    
    <?= $form->field($model, 'nama_pasien')->textInput() ?>
    <?= $form->field($model, 'tanggal_lahir')->input('date') ?>
    <?= $form->field($model, 'nik')->input('number', ['min' => 0]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
