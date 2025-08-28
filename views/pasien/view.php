<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pasien $model */

$this->title = 'Detail Registrasi';
$this->params['breadcrumbs'][] = ['label' => 'Registrasi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pasien-view">

    <!-- Tombol kembali -->
    <div class="mb-3">
        <?= Html::a('Kembali ke Registrasi', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <!-- Card utama -->
    <div class="card shadow-sm border border-primary">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0">Informasi Dasar Pasien</h5>

            <!-- Tombol Update & Delete -->
            <div>
                <?= Html::a('Update', ['update', 'id_pasien' => $model->id_pasien], ['class' => 'btn btn-sm btn-warning me-2']) ?>
                
                <button type="button" class="btn btn-sm btn-danger" 
                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                    Delete
                </button>
            </div>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">ID Registrasi</div>
                <div class="col-md-8"><?= Html::encode($model->id_pasien) ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nomor Registrasi</div>
                <div class="col-md-8"><?= Html::encode($model->no_rekam_medis) ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nomor Mahasiswa</div>
                <div class="col-md-8"><?= Html::encode($model->no_rekam_medis) ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Nama</div>
                <div class="col-md-8 d-flex align-items-center">
                    <?= Html::encode($model->nama) ?>
                    <?= Html::a('Edit', ['update', 'id_pasien' => $model->id_pasien], ['class' => 'btn btn-sm btn-light ms-2']) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Tanggal Lahir</div>
                <div class="col-md-8 d-flex align-items-center">
                    <?= Yii::$app->formatter->asDate($model->tanggal_lahir, 'php:d/m/Y') ?>
                    <?= Html::a('Edit', ['update', 'id_pasien' => $model->id_pasien], ['class' => 'btn btn-sm btn-light ms-2']) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">NIK</div>
                <div class="col-md-8 d-flex align-items-center">
                    <?= Html::encode($model->nik) ?>
                    <?= Html::a('Edit', ['update', 'id_pasien' => $model->id_pasien], ['class' => 'btn btn-sm btn-light ms-2']) ?>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Dibuat oleh</div>
                <div class="col-md-8"><?= Html::encode($model->create_by) ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Waktu buat</div>
                <div class="col-md-8"><?= Yii::$app->formatter->asDatetime($model->create_time_at, 'php:d/m/Y H:i:s') ?></div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Terakhir update</div>
                <div class="col-md-8"><?= Yii::$app->formatter->asDatetime($model->update_time_at, 'php:d/m/Y H:i:s') ?></div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4" style="border-radius: 12px;">
      <div class="modal-body">

        <!-- Lingkaran tanda seru -->
        <div style="
            width: 90px;
            height: 90px;
            margin: 0 auto 20px auto;
            border-radius: 50%;
            border: 5px solid #f1c40f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #f1c40f;
            font-weight: bold;
        ">
          !
        </div>

        <h4 class="mb-3">Penghapusan Data</h4>
        <p>Apakah Anda yakin ingin menghapus data pasien ini?</p>

        <div class="d-flex justify-content-center gap-2 mt-3">

            <!-- Tombol YA HAPUS -->
            <?= Html::a('Ya, Hapus', ['delete', 'id_pasien' => $model->id_pasien], [
                'class' => 'btn',
                'style' => 'background-color:#e74c3c;color:white;padding:8px 20px;font-weight:bold;',
                'data-method' => 'post',
                'data-confirm' => false,
            ]) ?>

            <!-- Tombol BATAL -->
            <button type="button" class="btn btn-secondary"
                style="background-color:#7f8c8d;color:white;padding:8px 20px;font-weight:bold;"
                data-bs-dismiss="modal">
                Batal
            </button>
        </div>

      </div>
    </div>
  </div>
</div>
