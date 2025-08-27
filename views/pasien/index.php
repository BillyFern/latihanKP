<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\PasienSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Pasien $model */ // Untuk modal create

$this->title = 'List Data Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasien-index">

    <div class="card shadow-sm p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><?= Html::encode($this->title) ?></h5>
            <div>
                <?= Html::button('<i class="fa fa-plus"></i> Tambah Data Pasien', [
                    'class' => 'btn btn-primary',
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#modal-create-pasien'
                ]) ?>
            </div>
        </div>

        <!-- Search bar -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
        </div>

        <?php // Modal untuk create ?>
        <?php Modal::begin([
            'id' => 'modal-create-pasien',
            'title' => '<h5>Tambah Pasien Baru</h5>',
            'size' => Modal::SIZE_LARGE,
        ]); ?>
            <?= $this->render('_form', ['model' => $model]) ?>
        <?php Modal::end(); ?>

        <!-- Tabel pasien -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No. Rekam Medis</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>NIK</th>
                        <th>Dibuat Pada</th>
                        <th>Diubah Pada</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->getModels() as $pasien): ?>
                        <tr>
                            <td><?= Html::encode($pasien->no_rekam_medis) ?></td>
                            <td><?= Html::encode($pasien->nama) ?></td>
                            <td><?= Html::encode($pasien->getTanggalLahirFormatted()) ?></td>
                            <td><?= Html::encode($pasien->nik) ?></td>
                            <td><?= Yii::$app->formatter->asDate($pasien->create_time_at, 'php:d/m/Y') ?></td>
                            <td><?= Yii::$app->formatter->asDate($pasien->update_time_at, 'php:d/m/Y') ?></td>
                            <td class="text-center">
                                <?= Html::a('<i class="fa fa-eye"></i>', ['view', 'id_pasien' => $pasien->id_pasien], [
                                    'class' => 'btn btn-info btn-sm',
                                    'title' => 'Detail'
                                ]) ?>

                                <!-- Tombol Edit (pakai modal) -->
                                <?= Html::button('<i class="fa-solid fa-pen"></i>', [
                                    'class' => 'btn btn-warning btn-sm',
                                    'title' => 'Ubah',
                                    'data-bs-toggle' => 'modal',
                                    'data-bs-target' => '#modal-update-pasien-' . $pasien->id_pasien,
                                ]) ?>

                                <!-- Tombol Delete (pakai modal konfirmasi) -->
                                <button type="button" class="btn btn-danger btn-sm" 
                                    data-bs-toggle="modal" data-bs-target="#modal-delete-pasien-<?= $pasien->id_pasien ?>">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <?php // Modal Edit ?>
                                <?php Modal::begin([
                                    'id' => 'modal-update-pasien-' . $pasien->id_pasien,
                                    'title' => '<h5>Ubah Data Pasien: ' . Html::encode($pasien->nama) . '</h5>',
                                    'size' => Modal::SIZE_LARGE,
                                ]); ?>
                                    <?= $this->render('_form', ['model' => $pasien]) ?>
                                <?php Modal::end(); ?>

                                <?php // Modal Konfirmasi Delete ?>
                                <div class="modal fade" id="modal-delete-pasien-<?= $pasien->id_pasien ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-center p-4" style="border-radius: 12px;">
                                            <div class="modal-body">

                                                <!-- Lingkaran tanda seru -->
                                                <div style="
                                                    width: 90px; height: 90px; margin: 0 auto 20px auto;
                                                    border-radius: 50%; border: 5px solid #f1c40f;
                                                    display: flex; align-items: center; justify-content: center;
                                                    font-size: 40px; color: #f1c40f; font-weight: bold;">
                                                    !
                                                </div>

                                                <h4 class="mb-3">Penghapusan Data</h4>
                                                <p>Apakah Anda yakin ingin menghapus data pasien <b><?= Html::encode($pasien->nama) ?></b>?</p>

                                                <div class="d-flex justify-content-center gap-2 mt-3">
                                                    <!-- Tombol YA HAPUS -->
                                                    <?= Html::a('Ya, Hapus', ['delete', 'id_pasien' => $pasien->id_pasien], [
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

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            <?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>
        </div>
    </div>
</div>
