<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\PasienSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Pasien $model */

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

        <?php Modal::begin([
            'id' => 'modal-create-pasien',
            'title' => '<h5>Tambah Pasien Baru</h5>',
            'size' => Modal::SIZE_LARGE,
        ]); ?>
        
        <?= $this->render('_form', [
            'model' => $model, 
        ]) ?>

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
                                <?= Html::a('<i class="fa fa-pen"></i>', ['update', 'id_pasien' => $pasien->id_pasien], [
                                    'class' => 'btn btn-warning btn-sm',
                                    'title' => 'Ubah'
                                ]) ?>
                                <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id_pasien' => $pasien->id_pasien], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'title' => 'Hapus',
                                    'data' => [
                                        'confirm' => 'Apakah Anda yakin ingin menghapus data pasien ini?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
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
