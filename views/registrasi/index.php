<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\widgets\LinkPager;

\kartik\select2\Select2Asset::register($this);
$this->registerCssFile(
    'https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css',
    ['depends' => [\kartik\select2\Select2Asset::class]]
);


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
                        <th>Dibuat Pada</th>
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
                            
                            <td><?= Yii::$app->formatter->asDatetime($registrator->create_time_at, 'php:d/m/Y H:i:s') ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($registrator->update_time_at, 'php:d/m/Y H:i:s') ?></td>
                            <td>
                                <?php if (!$dataExists): ?>
                                <?= Html::a('<i class="fa-solid fa-plus"></i>', 
                                    ['data-form/create', 'id_registrasi' => $registrator->id_registrasi], 
                                    [
                                        'class' => 'btn btn-success btn-sm',
                                        'title' => 'Input Data Form',
                                    ]
                                ) ?>
                                <?= Html::button('<i class="fa-solid fa-pen"></i>', [
                                    'class' => 'btn btn-warning btn-sm edit-btn',
                                    'title' => 'Edit Registrasi',
                                    'data-id' => $registrator->id_registrasi, 
                                    'data-bs-toggle' => 'modal',
                                    'data-bs-target' => '#ModalEditRegistrasi'
                                ]) ?>
                                <?= Html::button('<i class="fa-solid fa-trash"></i>', [
                                    'class' => 'btn btn-danger btn-sm delete-btn-registrasi',
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
                                    <?= Html::a('<i class="fa-solid fa-pen"></i>', 
                                        ['data-form/update', 'id_registrasi' => $registrator->id_registrasi], 
                                        [
                                            'class' => 'btn btn-warning btn-sm',
                                            'title' => 'Edit Data Form',
                                        ]
                                    ) ?>
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

        <?php Modal::begin(['id' => 'ModalEditRegistrasi','title' => '<h5>Edit Registrasi Pasien</h5>','size' => Modal::SIZE_LARGE,
        ]); ?>
        <div id="editRegistrasiFormContent">
            <!-- This content will be loaded via AJAX -->
        </div>
        <?php Modal::end(); ?>

        <?php Modal::begin([
            'id' => 'ModalDeleteRegistrasi',
            'title' => '<h5>Konfirmasi Hapus</h5>',
        ]); ?>
            <p>Apakah Anda yakin ingin menghapus registrasi ini?</p>
            <form id="delete-form-registrasi" method="post" action="">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        <?php Modal::end(); ?>
        <!-- Modals -->
        <?php Modal::begin(['id' => 'ModalInputForm', 'title' => '<h5>Input Form Data</h5>', 'size' => Modal::SIZE_LARGE]); ?>
        <div id="formDataContent">
            <?= $this->render('_form_data', ['dataform' => $dataform]) ?>
        </div>
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
$script = <<<JS
// --- existing modal form helpers (unchanged)
function initModalForm(container) {
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
    $(container).off('input.imt').on('input.imt', 'input[name="DataForm[dataFields][berat_badan]"], input[name="DataForm[dataFields][tinggi_badan]"]', updateIMT);
    updateIMT();

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
        $(sel).off('change.resiko').on('change.resiko', function(){
            updateRiskRow(sel);
            updateRiskTotal();
        });
        updateRiskRow(sel);
    });
    updateRiskTotal();
}


// --- helper: initialize Select2 only for .select2-init inside a container
function initSelect2In(container, modalSelector) {
    var \$c = $(container);
    \$c.find('select.select2-init').each(function(){
        var \$s = $(this);
        // destroy prior instance only on this element
        if (\$s.data('select2')) {
            try { \$s.select2('destroy'); } catch(e) {}
        }
        var opts = {
            width: '100%',
            allowClear: true,
            placeholder: \$s.data('placeholder') || \$s.attr('placeholder') || 'Select...',
            theme: 'bootstrap-5'
        };
        if (modalSelector) {
            opts.dropdownParent = $(modalSelector);
        }
        try {
            \$s.select2(opts);
        } catch(e) {
            console.error('Select2 init error:', e, \$s);
        }
    });
}

// --- EDIT modal: load form via AJAX on show, then init Select2 + any form logic
$('#ModalEditRegistrasi').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var container = $('#editRegistrasiFormContent');

    container.html('<p>Loading...</p>');

    $.get('index.php?r=registrasi/update', { id: id })
    .done(function(data) {
        // remove any select2 inside this container first (precaution)
        container.find('select.select2-init').each(function(){
            if ($(this).data('select2')) {
                try { $(this).select2('destroy'); } catch(e) {}
            }
        });

        container.html(data);

        // initialize select2 inside the edit modal
        initSelect2In(container, '#ModalEditRegistrasi');

        // initialize other JS-driven features in the loaded form
        if (typeof initModalForm === 'function') {
            try { initModalForm(container); } catch(e) { console.warn(e); }
        }
    })
    .fail(function(xhr) {
        container.html('<div class="text-danger">Failed to load form (HTTP ' + xhr.status + ')</div>');
        console.error(xhr.responseText || xhr.statusText);
    });
});

// --- CREATE modal: create form is server-rendered into #registrasiFormContent
// initialize select2 for create form on page load, and re-init when modal opens
$(function() {
    initSelect2In($('#registrasiFormContent'), '#ModalInputRegistrasi');
});
$('#ModalInputRegistrasi').on('shown.bs.modal', function() {
    initSelect2In($('#registrasiFormContent'), '#ModalInputRegistrasi');
});

// --- when edit/create modals hide, destroy select2 instances inside them to avoid duplicates
$('#ModalEditRegistrasi, #ModalInputRegistrasi, #ModalInputForm').on('hidden.bs.modal', function() {
    $(this).find('select.select2-init').each(function(){
        if ($(this).data('select2')) {
            try { $(this).select2('destroy'); } catch(e) {}
        }
    });
});

// --- existing handlers for loading DataForm edit and delete (unchanged)

$(document).on('click', '[data-bs-target="#ModalDelete"]', function() {
    var id = $(this).data('id');
    $('#delete-form').attr('action', 'index.php?r=data-form/delete&id_registrasi=' + id);
});

$(document).on('click', '.delete-btn', function () {
    let id = $(this).data('id');
    $('#confirmDelete').data('id', id);
});


$(document).on('click', '[data-bs-target="#ModalDeleteRegistrasi"]', function() {
    var id = $(this).data('id');
    $('#delete-form-registrasi').attr('action', 'index.php?r=registrasi/delete&id=' + id);
});

$(document).on('click', '.delete-btn-registrasi', function () {
    let id = $(this).data('id');
    $('#confirmDelete').data('id', id);
});

JS;
$this->registerJs($script);
?>
