<?php
/** @var app\models\DataForm $dataform */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$actionUrl = $dataform->isNewRecord
    ? ['data-form/create']   // for new input
    : ['data-form/update', 'id_registrasi' => $dataform->id_registrasi];  // for edit
?>

<div class="form-data-form">
<?php $form = ActiveForm::begin([
    'id' => 'form-data-form',
    'action' => $actionUrl, 
    'method' => 'post',
]); ?>

<!-- IMPORTANT: filled when user clicks the "Input" button for a row -->
<?= $form->field($dataform, 'id_registrasi')->hiddenInput(['id' => 'formdata-id_registrasi'])->label(false) ?>

<div class="mb-3">
  <h5 class="mb-2">Pengkajian saat datang (Diisi oleh Perawat)</h5>

  <?= $form->field($dataform, 'dataFields[cara_masuk]')
      ->checkboxList([
          'Jalan tanpa bantuan' => 'Jalan tanpa bantuan',
          'Kursi tanpa bantuan' => 'Kursi tanpa bantuan',
          'Tempat tidur dorong' => 'Tempat tidur dorong',
          'Lain-lain' => 'Lain-lain',
      ], [
        'itemOptions' => ['class' => 'form-check-input'], 
        'item' => function ($index, $label, $name, $checked, $value){
          return '<label class="checkbox-radio-style">' .
                Html::checkbox($name, $checked, ['value' => $value, 'class' => 'single-checkbox']) .
                ' ' . $label . '</label>';
        }])
      ->label('1. Cara masuk'); ?>

  <?= $form->field($dataform, 'dataFields[anamnesis]')
      ->checkboxList([
          'Autoanamnesis' => 'Autoanamnesis',
          'Aloanamnesis'  => 'Aloanamnesis',
      ], ['itemOptions' => ['class' => 'form-check-input'], 
      'item' => function($index, $label, $name, $checked, $value){
        return '<label class="checkbox-radio-style">' .
               Html::checkbox($name, $checked, ['value' => $value, 'class' => 'single-checkbox']) .
               ' ' . $label . '</label>';
      }])
      ->label('2. Anamnesis'); ?>

  <div class="row">
    <div class="col-6">
      <?= $form->field($dataform, 'dataFields[diperoleh]')->textInput()->label('Diperoleh'); ?>
    </div>
        <div class="col-6">
      <?= $form->field($dataform, 'dataFields[hubungan]')->textInput()->label('Hubungan'); ?>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <?= $form->field($dataform, 'dataFields[alergi]')->textInput()->label('Alergi'); ?>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <?= $form->field($dataform, 'dataFields[keluhan_utama]')->textInput()->label('3. Keluhan utama saat ini'); ?>
    </div>
  </div>


  <div class="border rounded p-3 mt-3">
    <h6 class="mb-3">4. Pemeriksaan fisik</h6>

    <?= $form->field($dataform, 'dataFields[keadaan_umum]')
        ->checkBoxList([
            'Tidak tampak sakit' => 'Tidak tampak sakit',
            'Sakit ringan' => 'Sakit ringan',
            'Sedang' => 'Sedang',
            'Berat' => 'Berat',
        ], ['itemOptions' => ['class' => 'form-check-input'], 
        'item' => function($index, $label, $name, $checked, $value){
          return '<label class="checkbox-radio-style">' .
                Html::checkbox($name, $checked, ['value' => $value, 'class' => 'single-checkbox']) .
                ' ' . $label . '</label>';
      }])
      ->label('a. Keadaan Umum'); ?>

    <?= $form->field($dataform, 'dataFields[warna_kulit]')
        ->checkBoxList([
            'Normal' => 'Normal',
            'Sianosis' => 'Sianosis',
            'Pucat' => 'Pucat',
            'Kemerahan' => 'Kemerahan',
        ], ['itemOptions' => ['class' => 'form-check-input'],'item' => function($index, $label, $name, $checked, $value){
          return '<label class="checkbox-radio-style">' .
                Html::checkbox($name, $checked, ['value' => $value, 'class' => 'single-checkbox']) .
                ' ' . $label . '</label>';
      }])
      ->label('b. Warna Kulit'); ?>

    <?= $form->field($dataform, 'dataFields[kesadaran]')
        ->radioList([
            'Compos mentis' => 'Compos mentis',
            'Apatis' => 'Apatis',
            'Somnolen' => 'Somnolen',
            'Sopor' => 'Sopor',
            'Subkomma' => 'Subkomma',
            'Koma' => 'Koma',
        ], ['itemOptions' => ['class' => 'form-check-input'], 'separator' => '  '])
        ->label('Kesadaran'); ?>

    <div class="row mt-2">
        <label>Tanda vital</label>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[tanda_vital_td]')->textInput(['placeholder' => 'mmHg'])->label('TD'); ?></div>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[tanda_vital_n]')->textInput(['placeholder' => 'x/menit'])->label('Nadi'); ?></div>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[tanda_vital_p]')->textInput(['placeholder' => 'x/menit'])->label('P'); ?></div>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[tanda_vital_s]')->textInput(['placeholder' => '°C'])->label('Suhu'); ?></div>
    </div>

    <div class="row mt-2">
        <label>Fungsional</label>
        <div class="col-md-4"><?= $form->field($dataform, 'dataFields[fungsional_ab]')->textInput()->label('Alat bantu'); ?></div>
        <div class="col-md-4"><?= $form->field($dataform, 'dataFields[fungsional_p]')->textInput()->label('Prothesa'); ?></div>
        <div class="col-md-4"><?= $form->field($dataform, 'dataFields[fungsional_ct]')->textInput()->label('Cacat tubuh'); ?></div>
        <div class="col-md-6">
            <?= $form->field($dataform, 'dataFields[fungsional_adl]')
                ->radioList([
                    'Mandiri' => 'Mandiri',
                    'Dibantu' => 'Dibantu',
                ], ['itemOptions' => ['class' => 'form-check-input'], 'separator' => '  '])
                ->label('ADL'); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($dataform, 'dataFields[fungsional_rj]')
                ->radioList([
                    '+' => '+',
                    '-' => '-',
                ], ['itemOptions' => ['class' => 'form-check-input'], 'separator' => '  '])
                ->label('Riwayat jatuh'); ?>
        </div>
    </div>

    <div class="row mt-2">
        <label>Antrapometri</label>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[berat_badan]')->input('number', ['step' => '0.1'])->label('Berat (kg)'); ?></div>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[tinggi_badan]')->input('number', ['step' => '0.1'])->label('Tinggi (cm)'); ?></div>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[panjang_badan]')->input('number', ['step' => '0.1'])->label('Panjang badan (cm)'); ?></div>
        <div class="col-md-3"><?= $form->field($dataform, 'dataFields[lingkar_kepala]')->input('number', ['step' => '0.1'])->label('Lingkar kepala (cm)'); ?></div>
    </div>

    <!-- New row for IMT -->
    <div class="row mt-2">
        <div class="col-md-3">
            <?= $form->field($dataform, 'dataFields[imt]')
                ->input('number', ['readonly' => true, 'id' => 'imt'])
                ->label('IMT'); ?>
        </div>
    </div>

    <?= $form->field($dataform, 'dataFields[status_gizi]')
        ->checkboxList([
            'Ideal'=>'Ideal',
            'Kurang'=>'Kurang','
            Obesitas/overweight'=>'Obesitas / overweight'
        ], ['itemOptions' => ['class'=>'form-check-input'], 
        'item' => function($index, $label, $name, $checked, $value){
          return '<label class="checkbox-radio-style">' .
                Html::checkbox($name, $checked, ['value' => $value, 'class' => 'single-checkbox']) .
                ' ' . $label . '</label>';
        }]) ->label('c. Status gizi'); ?>
  </div>

  <div class="border rounded p-3 mt-3">
    <h6 class="mb-3">Riwayat</h6>

    <div class="row">
      <div class="col"><?= $form->field($dataform, 'dataFields[riwayat_penyakit_sekarang]')->textInput()->label('5. Riwayat penyakit sekarang'); ?></div>
    </div>

    <?= $form->field($dataform, 'dataFields[riwayat_penyakit_sebelumnya]')
        ->checkboxList(['DM'=>'DM','Hipertensi'=>'Hipertensi','Jantung'=>'Jantung','Lain-lain'=>'Lain-lain'],
        ['itemOptions' => ['class'=>'form-check-input'], 
        'item' => function($index, $label, $name, $checked, $value){
          return '<label class="checkbox-radio-style">' .
                Html::checkbox($name, $checked, ['value' => $value, 'class' => 'single-checkbox']) .
                ' ' . $label . '</label>';
        }])
        ->label('6. Riwayat penyakit sebelumnya'); ?>

    <?= $form->field($dataform, 'dataFields[riwayat_penyakit]')
        ->radioList(['Tidak'=>'Tidak','Ya'=>'Ya'], ['separator'=>'  '])
        ->label('7. Riwayat penyakit'); ?>

    <div class="row">
      <div class="col"><?= $form->field($dataform, 'dataFields[riwayat_penyakit_keluarga]')->textInput()->label('8. Riwayat penyakit keluarga'); ?></div>
    </div>

    <?= $form->field($dataform, 'dataFields[riwayat_operasi]')
        ->radioList(
            ['Tidak'=>'Tidak','Ya'=>'Ya'], 
            ['separator'=>'  ', 'id' => 'riwayat-operasi-radio'])
        ->label('9. Riwayat operasi'); ?>

    <div id="riwayat-operasi-detail" style="display:none;">
        <div class="row">
            <div class="col-md-6"><?= $form->field($dataform, 'dataFields[riwayat_operasi_apa]')->textInput()->label('Operasi apa?'); ?></div>
            <div class="col-md-6"><?= $form->field($dataform, 'dataFields[riwayat_operasi_tahun]')->input('number')->label('Kapan? (tahun)'); ?></div>
        </div>
    </div>

    <?= $form->field($dataform, 'dataFields[riwayat_dirawat_rs]')
        ->radioList(['Tidak'=>'Tidak','Ya'=>'Ya'], 
        ['separator'=>'  ', 'id' => 'riwayat-dirawat-radio'])
        ->label('10. Riwayat pernah dirawat di RS'); ?>

    <div id="riwayat-dirawat-detail" style="display:none;">
        <div class="row">
            <div class="col-md-6"><?= $form->field($dataform, 'dataFields[riwayat_penyakit_apa]')->textInput()->label('Penyakit apa?'); ?></div>
            <div class="col-md-6"><?= $form->field($dataform, 'dataFields[riwayat_dirawat_tahun]')->input('number')->label('Kapan? (tahun)'); ?></div>
        </div>
    </div>

    <?php
    // Register a small JS snippet
    $script = <<< JS
        function toggleOperasiFields() {
            if ($('input[name="DataForm[dataFields][riwayat_operasi]"]:checked').val() === 'Ya') {
                $('#riwayat-operasi-detail').show();
            } else {
                $('#riwayat-operasi-detail').hide();
            }
        }
        function toggleDirawatFields() {
            if ($('input[name="DataForm[dataFields][riwayat_dirawat_rs]"]:checked').val() === 'Ya') {
                $('#riwayat-dirawat-detail').show();
            } else {
                $('#riwayat-dirawat-detail').hide();
            }
        }

        // Run on page load
        toggleDirawatFields();
        toggleOperasiFields();
        // Run on change
        $(document).on('change', 'input[name="DataForm[dataFields][riwayat_operasi]"]', toggleOperasiFields);
        $(document).on('change', 'input[name="DataForm[dataFields][riwayat_dirawat_rs]"]', toggleDirawatFields);
    JS;
    $this->registerJs($script);
    ?>
  </div>
</div>

<hr class="my-3">

<h5 class="mb-2">15. Pengkajian Resiko Jatuh</h5>
<table class="table table-bordered align-middle">
  <thead class="table-light">
    <tr>
      <th style="width:40px;">No</th>
      <th>Resiko</th>
      <th style="width:220px;">Skala</th>
      <th style="width:120px;">Hasil</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $risikoFields = [
        ['label'=>'Riwayat jatuh dalam 3 bulan terakhir','name'=>'riwayat_jatuh','options'=>['0'=>'Tidak = 0','25'=>'Ya = 25']],
        ['label'=>'Diagnosa medis sekunder > 1','name'=>'diagnosa_sekunder','options'=>['0'=>'Tidak = 0','15'=>'Ya = 15']],
        ['label' => 'Alat bantu jalan','name' => 'alat_bantu','options' => [
            '0'   => 'Tidak/Bedrest/Perabot = 0',
            '15a' => 'Penopang, tongkat, walker = 15',
            '15b' => 'Mencengkeram furniture/sesuatu untuk topangan = 15'
        ]],
        ['label'=>'Akses IV / terapi heparin lock','name'=>'iv_heparin','options'=>['0'=>'Tidak = 0','20'=>'Ya = 20']],
        ['label'=>'Berjalan/berpindah','name'=>'berjalan','options'=>['0'=>'Normal = 0','10'=>'Gangguan ringan = 10','20'=>'Terganggu/perlu bantuan/keseimbangan buruk = 20']],
        ['label'=>'Status mental','name'=>'status_mental','options'=>['0'=>'Orientasi sesuai kemampuan diri = 0','15'=>'Lupa keterbatasan diri = 15']],
    ];
    foreach ($risikoFields as $i => $field): 
        $value = $dataform->dataFields['resiko_jatuh'][$field['name']] ?? null;
        $options = $field['options']; // ✅ restore $options
    ?>
      <tr>
        <td><?= $i + 1 ?></td>
        <td><?= $field['label'] ?></td>
        <td>
          <?= $form->field($dataform, "dataFields[resiko_jatuh][{$field['name']}]")
              ->dropDownList($options, [
                  'class'=>'form-select resiko-select',
                  'id'=>'resiko-' . $field['name'],
                  'value' => $value
              ])
              ->label(false) ?>
        </td>
        <td>
          <input class="form-control resiko-hasil" id="hasil-<?= $field['name'] ?>" readonly>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>


<div class="row">
  <div class="col-md-4 ms-auto">
    <label class="form-label">Nilai total</label>
    <?= Html::textInput('resiko_total', $dataform->dataFields['resiko_jatuh']['nilai_total'] ?? '', [
        'class'=>'form-control',
        'id'=>'resiko-total',
        'readonly'=>true
    ]) ?>
    <?= Html::activeHiddenInput($dataform, 'dataFields[resiko_jatuh][nilai_total]', ['id'=>'resiko-total-hidden']) ?>

    <small id="resiko-category" class="form-text text-muted"></small>
  </div>
</div>



<div class="mt-4">
  <?= Html::submitButton('<i class="fa-solid fa-save"></i> Simpan', ['class' => 'btn btn-success', 'encode' => false]) ?>
</div>

<?php ActiveForm::end(); ?>
</div>

<?php
// Small helper JS: copy per-row id_registrasi into hidden field & compute risk total
$this->registerJs(<<<JS
// When the Input button opens the modal, copy its data-id into the hidden field
var modalEl = document.getElementById('ModalInputForm');
if (modalEl) {
  modalEl.addEventListener('show.bs.modal', function (event) {
    var trigger = event.relatedTarget;
    if (!trigger) return;
    var regId = trigger.getAttribute('data-id');
    var target = document.getElementById('formdata-id_registrasi');
    if (target && regId) target.value = regId;
  });
}

// Risiko jatuh scoring
function updateRiskRow(selectId, hasilId) {
  var sel = document.getElementById(selectId);
  var out = document.getElementById(hasilId);
  if (sel && out) out.value = parseInt(sel.value || '0', 10);
}
function updateRiskTotal() {
  var sum = 0;
  document.querySelectorAll('.resiko-select').forEach(function(s){ sum += parseInt(s.value || '0', 10); });
  var total = document.getElementById('resiko-total');
  var hidden = document.getElementById('resiko-total-hidden');
  var category = document.getElementById('resiko-category');

  if (total) total.value = sum;
  if (hidden) hidden.value = sum;

  let catText = '';
  if (sum >= 0 && sum <= 24) {
    catText = "Tidak berisiko (0-24) - Perawatan yang baik";
  } else if (sum >= 25 && sum <= 44) {
    catText = "Resiko rendah (25-44) - Lakukan intervensi jatuh standar";
  } else if (sum >= 45) {
    catText = "Resiko tinggi (≥45) - Lakukan intervensi jatuh risiko tinggi";
  }

  if (category) category.textContent = catText;
}
document.querySelectorAll('.resiko-select').forEach(function(sel){
  sel.addEventListener('change', function(){
    var id = sel.id.replace('resiko','hasil');
    updateRiskRow(sel.id, id);
    updateRiskTotal();
  });
});
// initialize outputs on load
document.querySelectorAll('.resiko-select').forEach(function(sel){
  var id = sel.id.replace('resiko','hasil');
  updateRiskRow(sel.id, id);
});
updateRiskTotal();
JS);

$this->registerJs(<<<JS
function updateIMT() {
    var berat = parseFloat($('input[name="DataForm[dataFields][berat_badan]"]').val());
    var tinggiCm = parseFloat($('input[name="DataForm[dataFields][tinggi_badan]"]').val());
    var imtInput = $('input[name="DataForm[dataFields][imt]"]');

    if (!isNaN(berat) && !isNaN(tinggiCm) && tinggiCm > 0) {
        var tinggiM = tinggiCm / 100;
        var imt = berat / (tinggiM * tinggiM);
        imtInput.val(imt.toFixed(2));
        $('#imt-section').show();
    } else {
        imtInput.val('');
        $('#imt-section').hide();
    }
}

// run on page load (modal content already in DOM)
updateIMT();

// run whenever berat/tinggi changes
$(document).on('input', 'input[name="DataForm[dataFields][berat_badan]"], input[name="DataForm[dataFields][tinggi_badan]"]', updateIMT);

// also refresh when the modal is shown (in case fields are prefilled)
$(document).on('shown.bs.modal', '#ModalInputForm', updateIMT);
JS);

$this->registerJs(<<<JS
$(document).on('change', '.single-checkbox', function() {
    $('.single-checkbox').not(this).prop('checked', false);
});
JS);
?>


