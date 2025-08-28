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


$this->registerCssFile(
    'https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css',
    ['depends' => [\kartik\select2\Select2Asset::class]]
);

$this->title = 'Registrasi Pasien';
$this->params['breadcrumbs'][] = $this->title;
// Register CSS
$this->registerCssFile('@web/css/registrasi-custom.css');
?>
<div class="position-fixed top-0 end-0 mt-5 me-3" style="z-index: 1055; width: 350px;">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
</div>
<!-- Main Content -->
<div class="container-fluid">
    <div class="main-content">
        <!-- Header Section -->
        <div class="content-header">
            <h1 class="p-4">List Data Pasien</h1>
            <div class="subtitle p-4"><?= count($registrasi) ?> available doctors</div>
        </div>

        <!-- Actions Bar -->
        <div class="actions-bar">
            <div class="search-container">
                <?= Html::beginForm(['registrasi/index'], 'get') ?>
                    <div class="input-group">
                        <?= Html::textInput('q', Yii::$app->request->get('q'), [
                            'class' => 'form-control',
                            'placeholder' => 'Search'
                        ]) ?>
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                <?= Html::endForm() ?>
            </div>
            
            <?= Html::button('<i class="fas fa-plus me-2"></i>Tambah Data Pasien', [
                'class' => 'btn btn-add-patient',
                'data-bs-toggle' => 'modal',
                'data-bs-target' => '#ModalInputRegistrasi'
            ]) ?>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                       <tr>
                          <th class="fw-bold">ID Registrasi</th>
                          <th class="fw-bold">Nomor Registrasi</th>
                          <th class="fw-bold">Nomor Rekam Medis</th>
                          <th class="fw-bold">Nama Pasien</th>
                          <th class="fw-bold">Tanggal Lahir</th>
                          <th class="fw-bold">NIK</th>
                          <th class="fw-bold text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrasi as $index => $registrator): ?>
                            <?php 
                                $dataExists = in_array($registrator->id_registrasi, $existingDataIds);
                            ?>
                            <tr>
                                <td>
                                    <strong><?= Html::encode($registrator->id_registrasi) ?></strong>
                                </td>
                                <td>
                                    <span >
                                        <?= Html::encode($registrator->no_registrasi) ?>
                                    </span>
                                </td>
                                <td>
                                    <span >
                                        <?= Html::encode($registrator->no_rekam_medis) ?>
                                    </span>
                                </td>
                                <td>
                                    <div >
                                        <span class="status-indicator <?= $dataExists ? 'status-active' : 'status-pending' ?>"></span>
                                        
                                            <?= $registrator->pasien ? Html::encode($registrator->pasien->nama) : '(Data Pasien Tidak Ditemukan)' ?>
                                    </div>
                                </td>
                                <td>
                                    <?= $registrator->pasien ? Html::encode($registrator->pasien->getTanggalLahirFormatted()) : '-' ?>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <?= $registrator->pasien ? Html::encode($registrator->pasien->nik) : '-' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
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
                                    </div>
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
                'pagination' => $pagination,
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
<?php
    $js = <<<JS
$('.btn-delete').on('click', function(){
    let id = $(this).data('id');
    $('#delete-id').val(id); // kirim ke hidden input
    $('#deleteModal').modal('show');
});

// Auto close alert setelah 3 detik
setTimeout(function() {
    $('.alert').alert('close');
}, 3000);
JS;
    $this->registerJs($js);
    ?>
<!-- Modals Section -->
<?php Modal::begin([
    'id' => 'ModalInputRegistrasi',
    'title' => '<i class="fas fa-user-plus me-2"></i>Tambahkan Registrasi Pasien',
    'size' => Modal::SIZE_LARGE,
    'options' => ['class' => 'fade'],
    'headerOptions' => ['class' => 'modal-header-custom'],
]); ?>
<div id="registrasiFormContent">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'ModalEditRegistrasi',
    'title' => '<i class="fas fa-user-edit me-2"></i>Edit Registrasi Pasien',
    'size' => Modal::SIZE_LARGE,
    'options' => ['class' => 'fade'],
]); ?>
<div id="editRegistrasiFormContent">
    <!-- This content will be loaded via AJAX -->
</div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'ModalDelete', 
    'options' => ['class' => 'fade'],
    'dialogOptions' => ['class' => 'modal-dialog-centered'],
    'closeButton' => false, // 🔑 agar modal di tengah
]); ?>
<div class="text-center p-4">
    <!-- Ikon Warning -->
    <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center" 
             style="width: 80px; height: 80px; border: 4px solid #FFD700;">
            <i class="fas fa-exclamation text-warning" style="font-size: 2.5rem;"></i>
        </div>
    </div>

    <!-- Judul & Pesan -->
    <h5 class="fw-bold mb-2">Penghapusan Data</h5>
    <p class="text-muted">Apakah Anda yakin ingin menghapus data ini?</p>

    <!-- Tombol Aksi -->
    <form id="delete-form" method="post" action="">
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
        <div class="d-flex justify-content-center gap-2 mt-3">
            <button type="submit" class="btn btn-danger px-4">
                Ya, hapus
            </button>
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                Batal
            </button>
        </div>
    </form>
</div>
<?php Modal::end(); ?>



<?php
// Register FontAwesome
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');

$script = <<< JS
// Add loading animation
function showLoading() {
    if (!document.querySelector('.loading-overlay')) {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay';
        overlay.innerHTML = '<div class="spinner"></div>';
        document.body.appendChild(overlay);
    }
}

function hideLoading() {
    const overlay = document.querySelector('.loading-overlay');
    if (overlay) {
        overlay.remove();
    }
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

// $(document).on('click', '[data-bs-target="#ModalEditRegistrasi"]', function() {
//     var id = $(this).data('id');
//     showLoading();
    
//     $.get('index.php?r=registrasi/update', { id: id }, function(data) {
//         var container = $('#editRegistrasiFormContent');
//         container.html(data);
//         hideLoading();
//     }).fail(function() {
//         hideLoading();
//         alert('Terjadi kesalahan saat memuat data');
//     });
// });

// Enhanced table animations
$('.table-custom tbody tr').hover(
    function() {
        $(this).addClass('shadow-lg');
    },
    function() {
        $(this).removeClass('shadow-lg');
    }
);

// Search enhancement
$('input[name="q"]').on('input', function() {
    const searchTerm = $(this).val().toLowerCase();
    if (searchTerm === '') return;
    
    $('.table-custom tbody tr').each(function() {
        const rowText = $(this).text().toLowerCase();
        if (rowText.includes(searchTerm)) {
            $(this).show().addClass('highlight');
        } else {
            $(this).hide();
        }
    });
});

// Initialize tooltips
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

JS;
$this->registerJs($script);
?>