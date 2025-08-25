<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\PasienSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Pasien $model */

$this->title = 'Data Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasien-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4"><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="body-content">
        <p>
            <?= Html::button('Tambah Pasien Baru', [
                'class' => 'btn btn-success mb-3',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modal-create-pasien'
            ]) ?>
        </p>

        <?php Modal::begin([
            'id' => 'modal-create-pasien',
            'title' => '<h5>Tambah Pasien Baru</h5>',
            'size' => Modal::SIZE_LARGE,
        ]); ?>
        
        <?= $this->render('_form', [
            // Menggunakan model yang dikirim dari actionIndex di controller
            'model' => $model, 
        ]) ?>

        <?php Modal::end(); ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No. Rekam Medis</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>NIK</th>
                        <th>Dibuat Pada</th>
                        <th>Diubah Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->getModels() as $pasien): ?>
                        <tr>
                            <td><?= Html::encode($pasien->no_rekam_medis) ?></td>
                            <td><?= Html::encode($pasien->nama) ?></td>
                            <td><?= Html::encode($pasien->getTanggalLahirFormatted()) ?></td>
                            <td><?= Html::encode($pasien->nik) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($pasien->create_time_at, 'php:d/m/Y H:i:s') ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($pasien->update_time_at, 'php:d/m/Y H:i:s') ?></td>
                            <td>
                                <?= Html::a('<i class="fa-solid fa-eye"></i>', ['view', 'id_pasien' => $pasien->id_pasien], ['class' => 'btn btn-primary btn-sm', 'title' => 'Lihat']) ?>
                                <?= Html::a('<i class="fa-solid fa-pen"></i>', ['update', 'id_pasien' => $pasien->id_pasien], ['class' => 'btn btn-warning btn-sm', 'title' => 'Ubah']) ?>
                                <?= Html::a('<i class="fa-solid fa-trash"></i>', ['delete', 'id_pasien' => $pasien->id_pasien], [
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

        <?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]) ?>

    </div>
</div>
