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
        // KUNCI PERBAIKAN: Menentukan action agar data dikirim ke controller yang benar
        'action' => ['pasien/create'],
        'method' => 'post',
    ]); ?>

    <?php 
        // errorSummary bisa sangat membantu untuk debugging jika ada error validasi
        // echo $form->errorSummary($model); 
    ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'no_rekam_medis')->textInput(['readonly' => true, 'class' => 'form-control bg-light']) ?>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            Nomor Rekam Medis akan di-generate otomatis setelah menyimpan data.
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan nama lengkap pasien']) ?>

    <?= $form->field($model, 'tanggal_lahir')->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'Pilih tanggal lahir'
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
        'type' => 'number' // Memastikan input hanya angka di mobile
    ]) ?>

    <?php 
        // Field-field audit tidak lagi diperlukan di sini.
        // TimestampBehavior dan BlameableBehavior di model Pasien akan mengisinya secara otomatis.
    ?>

    <div class="form-group mt-3">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan Pasien Baru' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
// Script validasi NIK Anda sudah bagus dan bisa tetap digunakan.
document.addEventListener('DOMContentLoaded', function() {
    const nikInput = document.querySelector('input[name="Pasien[nik]"]');
    if (nikInput) {
        nikInput.addEventListener('input', function() {
            // Hanya izinkan angka
            this.value = this.value.replace(/[^0-9]/g, '');
            // Batasi hingga 16 digit
            if (this.value.length > 16) {
                this.value = this.value.slice(0, 16);
            }
        });
    }
});
</script>
