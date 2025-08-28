<?php
use yii\helpers\Html;

$this->title = 'Dashboard';
?>

<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow-lg p-5 text-center" style="border-radius: 12px; max-width:600px;">
        <h2 class="fw-bold mb-3">Selamat Datang Di Klinik Obgyn</h2>
        <p class="text-muted mb-4">Sistem Informasi Klinik Untuk Registrasi Pasien</p>

        <div class="d-flex justify-content-center gap-2">
            <?= Html::a('Registrasi', ['registrasi/index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Pasien', ['pasien/index'], ['class' => 'btn btn-warning text-white']) ?>
        </div>
    </div>
</div>
