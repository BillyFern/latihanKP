<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\PasienSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Pasien $model */ // Ini untuk modal 'create'

$this->title = 'List Data Pasien';
$this->params['breadcrumbs'][] = $this->title;

// Register CSS sama seperti Registrasi
$this->registerCssFile('@web/css/registrasi-custom.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
?>

<!-- Main Content -->
<div class="container-fluid">
    <div class="main-content">
        
        <!-- Header Section -->
        <div class="content-header">
            <h1><?= Html::encode($this->title) ?></h1>
            <div class="subtitle"><?= $dataProvider->getTotalCount() ?> total pasien</div>
        </div>

        <!-- Actions Bar -->
        <div class="actions-bar">
            <!-- Search -->
            <div class="search-container">
                <?= Html::beginForm(['pasien/index'], 'get') ?>
                    <div class="input-group">
                        <?= Html::textInput('q', Yii::$app->request->get('q'), [
                            'class' => 'form-control',
                            'placeholder' => 'Search pasien...'
                        ]) ?>
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                <?= Html::endForm() ?>
            </div>

            <!-- Tambah -->
            <?= Html::button('<i class="fas fa-plus me-2"></i>Tambah Data Pasien', [
                'class' => 'btn btn-add-patient',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#modal-create-pasien'
            ]) ?>
        </div>

        <!-- Modal Tambah Pasien -->
        <?php Modal::begin([
            'id' => 'modal-create-pasien',
            'title' => '<i class="fas fa-user-plus me-2"></i>Tambah Pasien Baru',
            'size' => Modal::SIZE_LARGE,
            'options' => ['class' => 'fade'],
            'headerOptions' => ['class' => 'modal-header-custom'],
        ]); ?>
        
        <?= $this->render('_form', [
            'model' => $model, 
        ]) ?>

        <?php Modal::end(); ?>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th class="fw-bold">No. Rekam Medis</th>
                            <th class="fw-bold">Nama Pasien</th>
                            <th class="fw-bold">Tanggal Lahir</th>
                            <th class="fw-bold">NIK</th>
                            <th class="fw-bold">Dibuat Pada</th>
                            <th class="fw-bold">Diubah Pada</th>
                            <th class="fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataProvider->getModels() as $pasien): ?>
                            <tr>
                                <td><?= Html::encode($pasien->no_rekam_medis) ?></td>
                                <td><?= Html::encode($pasien->nama) ?></td>
                                <td><?= Html::encode($pasien->getTanggalLahirFormatted()) ?></td>
                                <td class="text-muted"><?= Html::encode($pasien->nik) ?></td>
                                <td><?= Yii::$app->formatter->asDate($pasien->create_time_at, 'php:d/m/Y') ?></td>
                                <td><?= Yii::$app->formatter->asDate($pasien->update_time_at, 'php:d/m/Y') ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <?= Html::a('<i class="fas fa-eye"></i>', ['view', 'id_pasien' => $pasien->id_pasien], [
                                            'class' => 'btn btn-action btn-primary',
                                            'title' => 'Detail'
                                        ]) ?>
                                        
                                        <?= Html::button('<i class="fas fa-edit"></i>', [
                                            'class' => 'btn btn-action btn-warning',
                                            'title' => 'Ubah',
                                            'data-bs-toggle' => 'modal',
                                            'data-bs-target' => '#modal-update-pasien-' . $pasien->id_pasien,
                                        ]) ?>
                                        
                                        <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id_pasien' => $pasien->id_pasien], [
                                            'class' => 'btn btn-action btn-danger',
                                            'title' => 'Hapus',
                                            'data' => [
                                                'confirm' => 'Apakah Anda yakin ingin menghapus data pasien ini?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </div>

                                    <!-- Modal Update Pasien -->
                                    <?php Modal::begin([
                                        'id' => 'modal-update-pasien-' . $pasien->id_pasien,
                                        'title' => '<i class="fas fa-user-edit me-2"></i>Ubah Data Pasien: ' . Html::encode($pasien->nama),
                                        'size' => Modal::SIZE_LARGE,
                                        'options' => ['class' => 'fade'],
                                    ]); ?>
                                    
                                    <?= $this->render('_form', [
                                        'model' => $pasien, 
                                    ]) ?>

                                    <?php Modal::end(); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
                'options' => ['class' => 'pagination justify-content-center'],
                'linkOptions' => ['class' => 'page-link'],
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'disabled',
                'prevPageLabel' => '<i class="fas fa-chevron-left"></i>',
                'nextPageLabel' => '<i class="fas fa-chevron-right"></i>',
            ]) ?>
        </div>

    </div>
</div>
