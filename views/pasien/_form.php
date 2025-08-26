<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Pasien $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pasien-form">

    <?php $form = ActiveForm::begin([
        // --- PERBAIKAN KUNCI DI SINI ---
        // 'action' diatur secara dinamis.
        // Jika model adalah record baru, action-nya ke 'pasien/create'.
        // Jika bukan, action-nya ke 'pasien/update' dengan menyertakan id_pasien.
        'action' => $model->isNewRecord ? ['pasien/create'] : ['pasien/update', 'id_pasien' => $model->id_pasien],
        'method' => 'post',
    ]); ?>

    <?php // Logika untuk menampilkan No Rekam Medis hanya saat update ?>
    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'no_rekam_medis')->textInput([
            'readonly' => true,
            'class' => 'form-control bg-light'
        ]) ?>
    <?php else: ?>
        <div class="alert alert-info">
            Nomor Rekam Medis akan di-generate otomatis setelah data disimpan.
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'nama')->textInput([
        'maxlength' => true, 
        'placeholder' => 'Masukkan nama lengkap pasien'
    ]) ?>

    <?= $form->field($model, 'tanggal_lahir')->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'Pilih tanggal lahir',
            'autocomplete' => 'off'
        ],
        'clientOptions' => [
            'changeYear' => true,
            'changeMonth' => true,
            'yearRange' => '1920:' . date('Y'),
            'maxDate' => 'today'
        ]
    ]) ?>

    <?= $form->field($model, 'nik')->textInput([
        'maxlength' => 16,
        'placeholder' => 'Masukkan NIK 16 digit',
        'type' => 'number'
    ]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan Pasien Baru' : 'Simpan Perubahan', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
