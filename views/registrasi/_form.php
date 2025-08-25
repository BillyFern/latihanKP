<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Pasien;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2; // Menggunakan widget Select2 untuk dropdown pencarian

/** @var yii\web\View $this */
/** @var app\models\Registrasi $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="registrasi-form">

    <?php $form = ActiveForm::begin([
        'id' => 'registrasi-form',
        'action' => ['registrasi/create'], // Form ini akan dikirim ke action 'create'
        'method' => 'post',
    ]); ?>

    <?php
    // Menyiapkan data pasien untuk dropdown.
    // Formatnya adalah: 'no_rekam_medis' => 'no_rekam_medis - nama_pasien'
    $pasienList = ArrayHelper::map(Pasien::find()->orderBy('nama')->asArray()->all(), 'no_rekam_medis', function($model) {
        return $model['no_rekam_medis'] . ' - ' . $model['nama'];
    });
    ?>

    <?= $form->field($model, 'no_rekam_medis')->widget(Select2::class, [
        'data' => $pasienList,
        'options' => ['placeholder' => 'Ketik untuk mencari No. RM atau Nama Pasien...'],
        'pluginOptions' => [
            'allowClear' => true // Menambahkan tombol (x) untuk menghapus pilihan
        ],
    ])->label('Pilih Pasien') ?>

    <!-- 
        Field 'no_registrasi' tidak perlukan di sini karena akan 
        di-generate secara otomatis oleh model saat data disimpan.
    -->

    <div class="form-group mt-4">
        <?= Html::submitButton('Simpan Registrasi', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// CATATAN:
// Widget Select2 adalah bagian dari ekstensi kartik-v. Pastikan Anda sudah menginstalnya:
// composer require kartik-v/yii2-widget-select2
?>
