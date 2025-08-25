<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var app\models\Registrasi[] $registrasi */
/** @var yii\data\Pagination $pagination */
/** @var app\models\Registrasi $model */
/** @var app\models\DataForm $dataform */
/** @var array $existingDataIds */

$this->title = 'Halaman Registrasi Pasien';
?>

<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Data Registrasi Pasien</h1>
    </div>

    <div class="body-content">
        <?= Html::button('Tambah Registrasi', [
            'class' => 'btn btn-primary mb-3', // 'float-end' has been removed
            'data-bs-toggle' => 'modal',
            'data-bs-target' => '#ModalInputRegistrasi'
        ]) ?>
        
        <?php Modal::begin([
            'id' => 'ModalInputRegistrasi',
            'title' => '<h5>Tambahkan Registrasi Pasien</h5>',
            'size' => Modal::SIZE_LARGE,
        ]); ?>

        <div id="registrasiFormContent">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>

        <?php Modal::end(); ?>
        <div>
            <div class="col-md-4">
                <?= Html::beginForm(['registrasi/index'], 'get') ?>
                    <div class="input-group">
                        <?= Html::textInput('q', Yii::$app->request->get('q'), [
                            'class' => 'form-control',
                            'placeholder' => 'Cari pasien (nama/NIK)...'
                        ]) ?>
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                <?= Html::endForm() ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No. Registrasi</th>
                        <th>No. Rekam Medis</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>NIK</th>
                        <th>Dibuat Oleh</th>
                        <th>Dibuat Pada</th>
                        <th>Diubah Oleh</th>
                        <th>Diubah Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrasi as $registrator): ?>
                        <?php 
                            $dataExists = in_array($registrator->id_registrasi, $existingDataIds);
                        ?>
                        <tr>
                            <td><?= Html::encode($registrator->no_registrasi) ?></td>
                            <td><?= Html::encode($registrator->no_rekam_medis) ?></td>
                            
                            <!-- Mengambil data dari relasi 'pasien' -->
                            <td><?= $registrator->pasien ? Html::encode($registrator->pasien->nama) : '(Data Pasien Tidak Ditemukan)' ?></td>
                            <td><?= $registrator->pasien ? Html::encode($registrator->pasien->getTanggalLahirFormatted()) : '-' ?></td>
                            <td><?= $registrator->pasien ? Html::encode($registrator->pasien->nik) : '-' ?></td>
                            
                            <td><?= Html::encode($registrator->create_by) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($registrator->create_time_at, 'php:d/m/Y H:i:s') ?></td>
                            <td><?= Html::encode($registrator->update_by) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($registrator->update_time_at, 'php:d/m/Y H:i:s') ?></td>
                            <td>
                                <?php if (!$dataExists): ?>
                                    <?= Html::button('<i class="fa-solid fa-plus"></i>', [
                                        'class' => 'btn btn-success btn-sm',
                                        'title' => 'Input Data Form',
                                        'data-id' => $registrator->id_registrasi, 
                                        'data-bs-toggle' => 'modal',
                                        'data-bs-target' => '#ModalInputForm'
                                    ]) ?>
                                <?= Html::button('<i class="fa-solid fa-pen"></i>', [
                                    'class' => 'btn btn-warning btn-sm',
                                    'title' => 'Edit Registrasi',
                                    'data-id' => $registrator->id_registrasi, 
                                    'data-bs-toggle' => 'modal',
                                    'data-bs-target' => '#ModalEditRegistrasi'
                                ]) ?>
                                <?= Html::button('<i class="fa-solid fa-trash"></i>', [
                                    'class' => 'btn btn-danger btn-sm delete-btn',
                                    'title' => 'Delete Registrasi',
                                    'data-id' => $registrator->id_registrasi, 
                                    'data-bs-toggle' => 'modal',
                                    'data-bs-target' => '#ModalDeleteRegistrasi'
                                ]) ?>
                                <?php else: ?>
                                    <?= Html::a('<i class="fa-solid fa-eye"></i>', 
                                        ['data-form/view', 'id_registrasi' => $registrator->id_registrasi], 
                                        [
                                            'class' => 'btn btn-primary btn-sm',
                                            'title' => 'View Data Form',
                                        ]) 
                                    ?>
                                    <?= Html::button('<i class="fa-solid fa-pen"></i>', [
                                        'class' => 'btn btn-warning btn-sm',
                                        'title' => 'Edit Data Form',
                                        'data-id' => $registrator->id_registrasi, 
                                        'data-bs-toggle' => 'modal',
                                        'data-bs-target' => '#ModalEditForm'
                                    ]) ?>
                                    <?= Html::button('<i class="fa-solid fa-trash"></i>', [
                                        'class' => 'btn btn-danger btn-sm delete-btn',
                                        'title' => 'Hapus Data Form',
                                        'data-id' => $registrator->id_registrasi, 
                                        'data-bs-toggle' => 'modal',
                                        'data-bs-target' => '#ModalDelete'
                                    ]) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?= LinkPager::widget(['pagination' => $pagination]) ?>

        <!-- Modals -->
        <?php Modal::begin(['id' => 'ModalInputForm', 'title' => '<h5>Input Form Data</h5>', 'size' => Modal::SIZE_LARGE]); ?>
        <div id="formDataContent">
            <?= $this->render('_form_data', ['dataform' => $dataform]) ?>
        </div>
        <?php Modal::end(); ?>

        <?php Modal::begin(['id' => 'ModalEditForm', 'title' => '<h5>Edit Form Data</h5>', 'size' => Modal::SIZE_LARGE]); ?>
        <div id="editDataContent"></div>
        <?php Modal::end(); ?>


        <?php Modal::begin([
            'id' => 'ModalDelete', 
             'title' => '<h5>Konfirmasi Hapus</h5>'
        ]); ?>
        <p>Apakah Anda yakin ingin menghapus data ini?</p>
      
        <form id="delete-form" method="post" action="">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
            <div class="text-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
        <?php Modal::end(); ?>
    </div>
</div>

<?php
$script = <<< JS
function initModalForm(container) {
    // IMT calculation
    function updateIMT() {
        var berat = parseFloat($(container).find('input[name="DataForm[dataFields][berat_badan]"]').val());
        var tinggiCm = parseFloat($(container).find('input[name="DataForm[dataFields][tinggi_badan]"]').val());
        var imtInput = $(container).find('input[name="DataForm[dataFields][imt]"]');

        if (!isNaN(berat) && !isNaN(tinggiCm) && tinggiCm > 0) {
            var tinggiM = tinggiCm / 100;
            var imt = berat / (tinggiM * tinggiM);
            imtInput.val(imt.toFixed(2));
        } else {
            imtInput.val('');
        }
    }

    $(container).on('input', 'input[name="DataForm[dataFields][berat_badan]"], input[name="DataForm[dataFields][tinggi_badan]"]', updateIMT);
    updateIMT();

    // Risiko Jatuh calculation
    function updateRiskRow(sel) {
        var tr = $(sel).closest('tr'); 
        var out = tr.find('.resiko-hasil'); 
        if (out.length) {
            var val = $(sel).val() || "0";
            var num = parseInt(val, 10); 
            out.val(num);
        }
    }

    function updateRiskTotal() {
        var sum = 0;
        $(container).find('.resiko-select').each(function() {
            sum += parseInt($(this).val() || '0', 10);
        });
        $(container).find('#resiko-total').val(sum);
        $(container).find('#resiko-total-hidden').val(sum);
    }

    $(container).find('.resiko-select').each(function(){
        var sel = this;
        $(sel).off('change').on('change', function(){
            updateRiskRow(sel);
            updateRiskTotal();
        });
        // set initial value
        updateRiskRow(sel);
    });
    updateRiskTotal();
}


$(document).on('click', '[data-bs-target="#ModalEditForm"]', function() {
    var id = $(this).data('id');
    $.get('index.php?r=data-form/edit', { id_registrasi: id }, function(data) {
        var container = $('#editDataContent');
        container.html(data);

        // initialize calculations on the new content
        initModalForm(container);
    });
});

$(document).on('click', '[data-bs-target="#ModalDelete"]', function() {
    var id = $(this).data('id');
    $('#delete-form').attr('action', 'index.php?r=data-form/delete&id_registrasi=' + id);
});
JS;
$this->registerJs($script);
?>
