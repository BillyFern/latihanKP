<?php

/** @var app\models\DataForm $dataform */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

// Register custom CSS
$this->registerCssFile('@web/css/wizard.css', [
  'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);


$actionUrl = $dataform->isNewRecord
  ? ['data-form/create']   // for new input
  : ['data-form/update', 'id_registrasi' => $dataform->id_registrasi];  // for edit
?>

<div class="wizard-container">
  <ul class="wizard-steps">
    <li class="active">
      <span class="step-index">1</span>
      <span class="step-label">Section 1</span>
    </li>
    <li>
      <span class="step-index">2</span>
      <span class="step-label">Section 2</span>
    </li>
    <li>
      <span class="step-index">3</span>
      <span class="step-label">Section 3</span>
    </li>
  </ul>
  <div class="form-data-form">
    <?php $form = ActiveForm::begin([
      'id' => 'form-data-form',
      'action' => $actionUrl,
      'method' => 'post',
    ]); ?>

    <!-- IMPORTANT: filled when user clicks the "Input" button for a row -->
    <?= $form->field($dataform, 'id_registrasi')->hiddenInput(['id' => 'formdata-id_registrasi'])->label(false) ?>

    <div class="mb-3 wizard-section active" id="section-1">
      <h3 class="mb-5 pt-2">Section 1</h3>

      <?= $form->field($dataform, 'dataFields[cara_masuk]')
        ->radioList([
          'Jalan tanpa bantuan' => 'Jalan tanpa bantuan',
          'Kursi tanpa bantuan' => 'Kursi tanpa bantuan',
          'Tempat tidur dorong' => 'Tempat tidur dorong',
          'Lain-lain' => 'Lain-lain',
        ], [
          'item' => function ($index, $label, $name, $checked, $value) {
            return '<div class="form-check-inline mt-1">
                  <input class="form-check-input mt-1" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                  <label class="form-check-label ms-2">' . $label . '</label>
                  </div>';
          }
        ])
        ->label('<strong> Cara masuk </strong>'); ?>

      <div class="row" style="max-width:65%">
        <div class="col-3">
          <?= $form->field($dataform, 'dataFields[anamnesis]')
            ->radioList([
              'Autoanamnesis' => 'Autoanamnesis',
              'Aloanamnesis'  => 'Aloanamnesis',
            ], [
              'item' => function ($index, $label, $name, $checked, $value) {
                return '<div class="form-check mt-1">
                    <input class="form-check-input mt-1" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                    <label class="form-check-label ms-2">' . $label . '</label>
                    </div>';
              }
            ])
            ->label('<strong>Anamnesis</strong>'); ?>
        </div>
        <div class="col-3 pt-4">
          <?= $form->field($dataform, 'dataFields[diperoleh]')->textInput(['class' => 'form-control', 'placeholder' => 'diperoleh'])->label('Diperoleh:', ['class' => 'mb-2'],); ?>
        </div>
        <div class="col-3 pt-4">
          <?= $form->field($dataform, 'dataFields[hubungan]')->textInput(['class' => 'form-control', 'placeholder' => 'hubungan'])->label('Hubungan:', ['class' => 'mb-2'],); ?>
        </div>
        <div class="col-3 pt-4">
          <?= $form->field($dataform, 'dataFields[alergi]')->textInput(['class' => 'form-control', 'placeholder' => 'alergi'])->label('Alergi:', ['class' => 'mb-2'],); ?>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-5">
          <?= $form->field($dataform, 'dataFields[keluhan_utama]')->textInput(['class' => 'form-control', 'placeholder' => 'keluhan utama saat ini'])->label('<strong>Keluhan utama saat ini</strong>',  ['class' => 'mb-2']); ?>
        </div>
      </div>


      <div class="form-section mt-3">
        <h6 class="section-title fw-bold">Pemeriksaan fisik</h6>

        <!-- Keadaan Umum -->
        <?= $form->field($dataform, 'dataFields[keadaan_umum]')
          ->radioList([
            'Tidak tampak sakit' => 'Tidak tampak sakit',
            'Sakit ringan' => 'Sakit ringan',
            'Sedang' => 'Sedang',
            'Berat' => 'Berat',
          ], [
            'item' => function ($index, $label, $name, $checked, $value) {
              return '<div class="form-check form-check-inline">'
                . Html::radio($name, $checked, ['value' => $value, 'class' => 'form-check-input mt-1 ms-1'])
                . '<label class="form-check-label ms-2">' . $label . '</label></div>';
            }
          ])->label('a. Keadaan umum'); ?>

        <!-- Warna Kulit -->
        <?= $form->field($dataform, 'dataFields[warna_kulit]')
          ->radioList([
            'Normal' => 'Normal',
            'Sianosis' => 'Sianosis',
            'Pucat' => 'Pucat',
            'Kemerahan' => 'Kemerahan',
          ], [
            'item' => function ($index, $label, $name, $checked, $value) {
              return '<div class="form-check form-check-inline">'
                . Html::radio($name, $checked, ['value' => $value, 'class' => 'form-check-input mt-1 ms-1'])
                . '<label class="form-check-label ms-2">' . $label . '</label></div>';
            }
          ])->label('b. Warna kulit'); ?>

        <!-- === Pemeriksaan fisik  === -->
        <div class="pf-panel mt-3 ms-4">

          <div class="row g-0 pf-grid">

            <!-- Col 1: Kesadaran -->
            <div class="col-md-2 pf-col">
              <div class="pf-title">Kesadaran:</div>
              <?php
              echo $form->field($dataform, 'dataFields[kesadaran]', [
                'options'  => ['tag' => false],          // no extra wrapper
                'template' => "{input}\n{error}",
              ])->radioList([
                'Compos mentis' => 'Compos mentis',
                'Apatis'        => 'Apatis',
                'Somnolent'     => 'Somnolent',
                'Sopor'         => 'Sopor',
                'Soporokoma'    => 'Soporokoma',
                'Koma'          => 'Koma',
              ], [
                'item' => function ($index, $label, $name, $checked, $value) {
                  return '<div class="form-check pf-radio">
                                <input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                                <label class="form-check-label">' . $label . '</label>
                              </div>';
                },
                'separator' => '',
              ])->label(false);
              ?>
            </div>

            <!-- Col 2: Tanda vital -->
            <div class="col-md-2 pf-col" style="flex: 0 0 calc(20.833%); max-width: calc(20.833%);">
              <div class="pf-title">Tanda vital:</div>

              <div class="pf-item">
                <div class="pf-key col-1">TD</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-10">
                  <?= $form->field($dataform, 'dataFields[tanda_vital_td]', [
                    'options'  => ['tag' => false],
                    'template' => "{input}\n{error}",
                  ])->textInput(['class' => 'form-control form-control-sm', 'placeholder' => 'mmHg'])->label(false); ?>
                </div>
              </div>

              <div class="pf-item">
                <div class="pf-key col-1">P</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-10">
                  <?= $form->field($dataform, 'dataFields[tanda_vital_p]', [
                    'options'  => ['tag' => false],
                    'template' => "{input}\n{error}",
                  ])->textInput(['class' => 'form-control form-control-sm', 'placeholder' => 'x/menit'])->label(false); ?>
                </div>
              </div>

              <div class="pf-item">
                <div class="pf-key col-1">N</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-10">
                  <?= $form->field($dataform, 'dataFields[tanda_vital_n]', [
                    'options'  => ['tag' => false],
                    'template' => "{input}\n{error}",
                  ])->textInput(['class' => 'form-control form-control-sm', 'placeholder' => 'x/menit'])->label(false); ?>
                </div>
              </div>

              <div class="pf-item">
                <div class="pf-key col-1">S</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-10">
                  <?= $form->field($dataform, 'dataFields[tanda_vital_s]', [
                    'options'  => ['tag' => false],
                    'template' => "{input}\n{error}",
                  ])->textInput(['class' => 'form-control form-control-sm', 'placeholder' => '°C'])->label(false); ?>
                </div>
              </div>
            </div>

            <!-- Col 3: Fungsional -->
            <div class="col-md-3 pf-col" style="flex: 0 0 calc(25.833%); max-width: calc(25.833%);">
              <div class="pf-title">Fungsional:</div>

              <div class="pf-item">
                <div class="pf-key col-5">1. Alat bantu</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-6">
                  <?= $form->field($dataform, 'dataFields[fungsional_ab]', [
                    'options' => ['tag' => false],
                    'template' => "{input}\n{error}",
                  ])->textInput(['class' => 'form-control form-control-sm'])->label(false); ?>
                </div>
              </div>

              <div class="pf-item">
                <div class="pf-key col-5">2. Prothesa</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-6">
                  <?= $form->field($dataform, 'dataFields[fungsional_p]', [
                    'options' => ['tag' => false],
                    'template' => "{input}\n{error}",
                  ])->textInput(['class' => 'form-control form-control-sm'])->label(false); ?>
                </div>
              </div>

              <div class="pf-item">
                <div class="pf-key col-5">3. Cacat tubuh</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-6">
                  <?= $form->field($dataform, 'dataFields[fungsional_ct]', [
                    'options' => ['tag' => false],
                    'template' => "{input}\n{error}",
                  ])->textInput(['class' => 'form-control form-control-sm'])->label(false); ?>
                </div>
              </div>

              <div class="pf-item">
                <div class="pf-key col-5">4. ADL</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val">
                </div>
              </div>
              <div class="pf-item ms-3">
                <?php
                echo $form->field($dataform, 'dataFields[fungsional_adl]', [
                  'options' => ['tag' => false],
                  'template' => "{input}\n{error}",
                ])->radioList([
                  'Mandiri' => 'Mandiri',
                  'Dibantu' => 'Dibantu',
                ], [
                  'item' => function ($i, $label, $name, $checked, $value) {
                    return '<label class="form-check form-check-inline pf-radio-inline">
                                  <input class="form-check-input mt-1" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                                  <span class="form-check-label">' . $label . '</span>
                                </label>';
                  },
                  'separator' => '',
                ])->label(false);
                ?>
              </div>

              <div class="pf-item">
                <div class="pf-key col-5">5. Riwayat jatuh</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val">
                </div>
              </div>
              <div class="pf-item ms-3">
                <?php
                echo $form->field($dataform, 'dataFields[fungsional_rj]', [
                  'options' => ['tag' => false],
                  'template' => "{input}\n{error}",
                ])->radioList([
                  '+' => '+',
                  '-' => '-',
                ], [
                  'item' => function ($i, $label, $name, $checked, $value) {
                    return '<label class="form-check form-check-inline pf-radio-inline">
                                    <input class="form-check-input" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                                    <span class="form-check-label">' . $label . '</span>
                                  </label>';
                  },
                  'separator' => '',
                ])->label(false);
                ?>
              </div>
            </div>

            <!-- Col 4: Antropometri + Catatan -->
            <div class="col-md-4 pf-col pf-col-last" style="flex: 0 0 calc(36.334%); max-width: calc(36.334%);">
              <div class="pf-title">Antropometri:</div>

              <div class="pf-item" style="max-width: 72%;">
                <div class="pf-key col-6">Berat badan</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-5">
                  <div class="input-group input-group-sm">
                    <?= Html::activeInput('number', $dataform, 'dataFields[berat_badan]', ['class' => 'form-control', 'step' => '0.1', 'placeholder' => 'kg']); ?>
                  </div>
                </div>
              </div>

              <div class="pf-item" style="max-width: 72%;">
                <div class="pf-key col-6">Tinggi badan</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-5">
                  <div class="input-group input-group-sm">
                    <?= Html::activeInput('number', $dataform, 'dataFields[tinggi_badan]', ['class' => 'form-control', 'step' => '0.1', 'placeholder' => 'cm']); ?>
                  </div>
                </div>
              </div>

              <div class="pf-item" style="max-width: 72%;">
                <div class="pf-key col-6">Panjang badan (PB)</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-5">
                  <div class="input-group input-group-sm">
                    <?= Html::activeInput('number', $dataform, 'dataFields[panjang_badan]', ['class' => 'form-control', 'step' => '0.1', 'placeholder' => 'cm']); ?>
                  </div>
                </div>
              </div>

              <div class="pf-item" style="max-width: 72%;">
                <div class="pf-key col-6">Lingkar kepala (LK)</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-5">
                  <div class="input-group input-group-sm">
                    <?= Html::activeInput('number', $dataform, 'dataFields[lingkar_kepala]', ['class' => 'form-control', 'step' => '0.1', 'placeholder' => 'cm']); ?>
                  </div>
                </div>
              </div>

              <div class="pf-item" style="max-width: 72%;">
                <div class="pf-key col-6">IMT</div>
                <div class="pf-sep col-1">:</div>
                <div class="pf-val col-5">
                  <?= Html::activeInput('number', $dataform, 'dataFields[imt]', [
                    'class' => 'form-control form-control-sm border-0',
                    'readonly' => true,
                    'id' => 'imt',
                  ]); ?>
                </div>
              </div>

              <div class="pf-note text-end">
                <div><strong>Catatan:</strong></div>
                <div>PB & LK</div>
                <div>Khusus Pediatri</div>
              </div>
            </div>

          </div>
        </div>
        <!-- Status Gizi -->
        <?= $form->field($dataform, 'dataFields[status_gizi]')
          ->radioList([
            'Ideal' => 'Ideal',
            'Kurang' => 'Kurang',
            'Obesitas / overweight' => 'Obesitas / overweight'
          ], [
            'item' => function ($i, $label, $name, $checked, $value) {
              return '<div class="form-check form-check-inline mt-1">'
                . Html::radio($name, $checked, ['value' => $value, 'class' => 'form-check-input ms-1'])
                . '<label class="form-check-label ms-2">' . $label . '</label></div>';
            }
          ])->label('c. Status gizi', ['class' => 'mt-3']); ?>
      </div>


      <button type="button" class="btn btn-warning next-btn float-end text-white fw-bold" style="width:110px; height:43px;">Next</button>
    </div>

    <div class="mt-3 wizard-section" id="section-2">
      <h3 class="mb-5 pt-2">Section 2</h3>
      <div class="row">
        <div class="col"><?= $form->field($dataform, 'dataFields[riwayat_penyakit_sekarang]')->textInput(['placeholder' => 'Riwayat Penyakit'])->label('Riwayat penyakit sekarang', ['class' => 'mb-2']); ?></div>
      </div>

      <?= $form->field($dataform, 'dataFields[riwayat_penyakit_sebelumnya]')
        ->checkboxList(
          ['DM' => 'DM', 'Hipertensi' => 'Hipertensi', 'Jantung' => 'Jantung', 'Lain-lain' => 'Lain-lain'],
          [
            'itemOptions' => ['class' => 'form-check-input'],
            'item' => function ($index, $label, $name, $checked, $value) {
              return Html::checkbox($name, $checked, ['value' => $value, 'class' => 'me-2']) .
                '<label class="checkbox-style me-5">' . $label . '</label>';
            }
          ]
        )
        ->label('Riwayat penyakit sebelumnya', ['class' => 'mb-2']); ?>

      <?= $form->field($dataform, 'dataFields[riwayat_penyakit]')
        ->radioList(
          ['Tidak' => 'Tidak', 'Ya' => 'Ya'],
          ['item' => function ($index, $label, $name, $checked, $value) {
            return '<div class="form-check-inline mt-1">
                  <input class="form-check-input mt-1" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                  <label class="form-check-label ms-2">' . $label . '</label>
                  </div>';
          }]
        )
        ->label('Riwayat penyakit', ['class' => 'mb-2']); ?>

      <div class="row">
        <div class="col"><?= $form->field($dataform, 'dataFields[riwayat_penyakit_keluarga]')->textInput(['placeholder' => 'Riwayat Penyakit Keluarga'])->label('Riwayat penyakit keluarga', ['class' => 'mb-2']); ?></div>
      </div>

      <div class="row">
        <div class="col-3">
          <?= $form->field($dataform, 'dataFields[riwayat_operasi]')
            ->radioList(
              ['Tidak' => 'Tidak', 'Ya' => 'Ya'],
              ['item' => function ($index, $label, $name, $checked, $value) {
                return '<div class="form-check-inline mt-2">
                    <input class="form-check-input mt-2" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                    <label class="form-check-label ms-2 mt-1">' . $label . '</label>
                    </div>';
              }]
            )
            ->label('Riwayat operasi'); ?>
        </div>
        <div class="col-9" id="riwayat-operasi-detail" style="display:none;">
          <div class="row mt-5">
            <?= $form->field($dataform, 'dataFields[riwayat_operasi_apa]')->textInput()->label('Operasi apa?'); ?></div>
          <?= $form->field($dataform, 'dataFields[riwayat_operasi_tahun]')->input('number')->label('Kapan? (tahun)'); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-3">
          <?= $form->field($dataform, 'dataFields[riwayat_dirawat_rs]')
            ->radioList(
              ['Tidak' => 'Tidak', 'Ya' => 'Ya'],
              ['item' => function ($index, $label, $name, $checked, $value) {
                return '<div class="form-check-inline mt-1">
                    <input class="form-check-input mt-2" type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>
                    <label class="form-check-label ms-2 mt-1">' . $label . '</label>
                    </div>';
              }]
            )
            ->label('Riwayat pernah dirawat di RS'); ?>
        </div>
        <div class="col-9" id="riwayat-dirawat-detail" style="display:none;">
          <div class="row mt-5">
            <?= $form->field($dataform, 'dataFields[riwayat_penyakit_apa]')->textInput()->label('Penyakit apa?'); ?></div>
          <?= $form->field($dataform, 'dataFields[riwayat_dirawat_tahun]')->input('number')->label('Kapan? (tahun)'); ?>
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

      <button type="button" class="btn btn-warning next-btn float-end text-white fw-bold" style="width:110px; height:43px;">Next</button>
      <button type="button" class="btn btn-secondary prev-btn float-end text-white fw-bold me-3" style="width:110px; height:43px;">Previous</button>
    </div>

    <div class="wizard-section" id="section-3">
      <h3 class="mb-5 pt-2">Section 3</h3>
      <?php
        $vals = $dataform->dataFields['resiko_jatuh'] ?? [];
      ?>

      <table class="table custom-risk-table table-borderless align-middle" style="max-width:70%;">
        <tbody>
          <!-- Riwayat jatuh dalam 3 bulan terakhir (select) -->
          <tr>
            <td style="width:65%;"> 
              <?= Html::tag('div', 'Riwayat jatuh dalam 3 bulan terakhir', ['class'=>'resiko-label']) ?>
            </td>
            <td style="width:15%;">
              <?= Html::dropDownList(
                  'DataForm[dataFields][resiko_jatuh][riwayat_jatuh]',
                  $vals['riwayat_jatuh'] ?? null,
                  ['0' => 'Tidak', '25' => 'Ya'],
                  ['prompt'=>'Skala','class'=>'form-select resiko-select','id'=>'resiko-riwayat_jatuh']
              ) ?>
            </td>
            <td style="width:20%;">
              <input type="text" id="hasil-riwayat_jatuh" class="form-control resiko-hasil" readonly>
            </td>
          </tr>

          <!-- Diagnosa medis sekunder > 1 (select) -->
          <tr>
            <td>
              <?= Html::tag('div', 'Diagnosa medis sekunder > 1', ['class'=>'resiko-label']) ?>
            </td>
            <td>
              <?= Html::dropDownList(
                  'DataForm[dataFields][resiko_jatuh][diagnosa_sekunder]',
                  $vals['diagnosa_sekunder'] ?? null,
                  ['0' => 'Tidak', '15' => 'Ya'],
                  ['prompt'=>'Skala','class'=>'form-select resiko-select','id'=>'resiko-diagnosa_sekunder']
              ) ?>
            </td>
            <td>
              <input type="text" id="hasil-diagnosa_sekunder" class="form-control resiko-hasil" readonly>
            </td>
          </tr>

          <!-- Alat bantu jalan (LOOKS like checkboxes but SINGLE-CHOICE) -->
          <tr>
            <td>
              <?= Html::tag('div', 'Alat bantu jalan', ['class'=>'resiko-label']) ?>
            </td>
            <td>
              <!-- In new row -->
            </td>
            <td>
              <input type="text" id="hasil-alat_bantu" class="form-control resiko-hasil" readonly>
            </td>
          </tr>

          <tr>
            <td>
              <!-- visible radio UI (user interacts with these) -->
              <div class="d-flex gap-3 flex-column">
              <?php
                $opts = [
                  '0'   => 'Mandiri, bedrest, dibantu perawat, kursi roda',
                  '15a' => 'Penopang, tongkat/walker',
                  '15b' => 'Mencengkeram furniture/sesuatu untuk topangan'
                ];
                $uiName = 'alat_bantu_ui';

                foreach ($opts as $k => $label) {
                    $safeId = 'alat_bantu_ui_' . preg_replace('/[^a-zA-Z0-9_-]/','_', $k);
                    $checked = (isset($vals['alat_bantu']) && $vals['alat_bantu'] === $k) ? 'checked' : '';
                    $onclick = "
                      // uncheck others in this group
                      document.querySelectorAll('[name={$uiName}]').forEach(cb => {
                          if(cb.id !== '{$safeId}') cb.checked = false;
                      });
                      // sync hidden field
                      document.getElementById('resiko-alat_bantu').value='{$k}';
                      document.getElementById('resiko-alat_bantu').dispatchEvent(new Event('change'));
                    ";

                    echo '<div class="form-check">'
                      . "<input type=\"checkbox\" class=\"form-check-input\" name=\"{$uiName}\" id=\"{$safeId}\" value=\"{$k}\" {$checked} onclick=\"{$onclick}\">"
                      . "<label for=\"{$safeId}\">{$label}</label>"
                      . '</div>';
                }
                ?>

              </div>

              <!-- hidden select used by your existing JS and for form submission -->
              <?= Html::dropDownList(
                  'DataForm[dataFields][resiko_jatuh][alat_bantu]',
                  $vals['alat_bantu'] ?? null,
                  $opts,
                  ['class'=>'form-select resiko-select d-none','id'=>'resiko-alat_bantu']
              ) ?>
            </td>
            <td></td>
            <td></td>
          </tr>
          <!-- Akses IV / terapi heparin lock (select) -->
          <tr>
            <td>
              <?= Html::tag('div', 'Akses IV / terapi heparin lock', ['class'=>'resiko-label']) ?>
            </td>
            <td>
              <?= Html::dropDownList(
                  'DataForm[dataFields][resiko_jatuh][iv_heparin]',
                  $vals['iv_heparin'] ?? null,
                  ['0' => 'Tidak', '20' => 'Ya'],
                  ['prompt'=>'Skala','class'=>'form-select resiko-select','id'=>'resiko-iv_heparin']
              ) ?>
            </td>
            <td>
              <input type="text" id="hasil-iv_heparin" class="form-control resiko-hasil" readonly>
            </td>
          </tr>

          <!-- Cara berjalan / berpindah (LOOKS like checkboxes but SINGLE-CHOICE) -->
          <tr>
            <td>
              <?= Html::tag('div', 'Cara berjalan/ berpindah', ['class'=>'resiko-label']) ?>
            </td>
            <td>
              <!-- new row -->
            </td>
            <td>
              <input type="text" id="hasil-berjalan" class="form-control resiko-hasil" readonly>
            </td>
          </tr>
          <tr>
            <td>
              <div class="d-flex gap-3 flex-column">
                <?php
                  $opts2 = [
                    '0'  => 'Normal',
                    '10' => 'Lemah, langkah diseret',
                    '20' => 'Terganggu, perlu bantuan, keseimbangan buruk'
                  ];
                  $uiName2 = 'berjalan_ui';

                  foreach ($opts2 as $k => $label) {
                      $safeId = 'berjalan_ui_' . preg_replace('/[^a-zA-Z0-9_-]/','_', $k);
                      $checked = (isset($vals['berjalan']) && $vals['berjalan'] === $k) ? 'checked' : '';
                      $onclick = "
                        // uncheck others in this group
                        document.querySelectorAll('[name={$uiName2}]').forEach(cb => {
                            if(cb.id !== '{$safeId}') cb.checked = false;
                        });
                        // sync hidden field
                        document.getElementById('resiko-berjalan').value='{$k}';
                        document.getElementById('resiko-berjalan').dispatchEvent(new Event('change'));
                      ";

                      echo '<div class="form-check">'
                        . "<input type=\"checkbox\" class=\"form-check-input\" name=\"{$uiName2}\" id=\"{$safeId}\" value=\"{$k}\" {$checked} onclick=\"{$onclick}\">"
                        . "<label for=\"{$safeId}\">{$label}</label>"
                        . '</div>';
                  }
                  ?>
              </div>

              <?= Html::dropDownList(
                  'DataForm[dataFields][resiko_jatuh][berjalan]',
                  $vals['berjalan'] ?? null,
                  $opts2,
                  ['class'=>'form-select resiko-select d-none','id'=>'resiko-berjalan']
              ) ?>
            </td>
            <td></td>
            <td></td>
          </tr>

          <!-- Status Mental (LOOKS like checkboxes but SINGLE-CHOICE) -->
          <tr>
            <td>
              <?= Html::tag('div', 'Status Mental', ['class'=>'resiko-label']) ?>
            </td>
            <td>
                <!--new row-->
            </td>
            <td>
              <input type="text" id="hasil-status_mental" class="form-control resiko-hasil" readonly>
            </td>
          </tr>

          <tr>
            <td>
              <div class="d-flex gap-3 flex-column">
                <?php
                  $opts3 = [
                    '0'  => 'Orientasi sesuai kemampuan diri',
                    '15' => 'Lupa keterbatasan diri'
                  ];
                  $uiName3 = 'status_mental_ui';

                  foreach ($opts3 as $k => $label) {
                      $safeId = 'status_mental_ui_' . preg_replace('/[^a-zA-Z0-9_-]/','_', $k);
                      $checked = (isset($vals['status_mental']) && $vals['status_mental'] === $k) ? 'checked' : '';
                      $onclick = "
                        // uncheck others in this group
                        document.querySelectorAll('[name={$uiName3}]').forEach(cb => {
                            if(cb.id !== '{$safeId}') cb.checked = false;
                        });
                        // sync hidden field
                        document.getElementById('resiko-status_mental').value='{$k}';
                        document.getElementById('resiko-status_mental').dispatchEvent(new Event('change'));
                      ";

                      echo '<div class="form-check">'
                        . "<input type=\"checkbox\" class=\"form-check-input\" name=\"{$uiName3}\" id=\"{$safeId}\" value=\"{$k}\" {$checked} onclick=\"{$onclick}\">"
                        . "<label for=\"{$safeId}\">{$label}</label>"
                        . '</div>';
                  }
                ?>
              </div>

              <?= Html::dropDownList(
                  'DataForm[dataFields][resiko_jatuh][status_mental]',
                  $vals['status_mental'] ?? null,
                  $opts3,
                  ['class'=>'form-select resiko-select d-none','id'=>'resiko-status_mental']
              ) ?>
            </td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td class="pt-2">
              <label class="form-label">Nilai total</label>
              <?= Html::textInput('resiko_total', $dataform->dataFields['resiko_jatuh']['nilai_total'] ?? '', [
                'class' => 'form-control',
                'id' => 'resiko-total',
                'readonly' => true
              ]) ?>
              <?= Html::activeHiddenInput($dataform, 'dataFields[resiko_jatuh][nilai_total]', ['id' => 'resiko-total-hidden']) ?>
              <small id="resiko-category" class="form-text text-muted"></small>
            </td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>

      <!-- total block unchanged -->
      <div class="row">
        <div class="col-md-4">

        </div>
      </div>

      <div class="mt-4">
        <?= Html::submitButton('submit', ['class' => 'btn btn-warning float-end text-white fw-bold', 'encode' => false, 'style' =>'width:110px; height:43px;']) ?>
        <button type="button" class="btn btn-secondary prev-btn float-end text-white fw-bold me-3" style="width:110px; height:43px;">Previous</button>
      </div>

    </div>
  </div>
</div>

<?php ActiveForm::end(); ?>

<?php
// Place this once at the bottom of the view, replacing all other registerJs() blocks in this file.
$script = <<<'JS'
(function(){
  // run at page end (no jQuery dependency)
  document.addEventListener('DOMContentLoaded', function() {
    console.log('Wizard JS loaded');

    // ----- Wizard navigation -----
    const sections = Array.from(document.querySelectorAll('.wizard-section'));
    const steps = Array.from(document.querySelectorAll('.wizard-steps li'));
    let current = 0;

    function showSection(index) {
      if (!sections.length) return;
      if (index < 0) index = 0;
      if (index >= sections.length) index = sections.length - 1;
      sections.forEach((s,i) => s.classList.toggle('active', i === index));
      steps.forEach((st,i) => {
        st.classList.remove('active');
        if (i === index) st.classList.add('active');
      });
      console.log('Now showing section', index + 1);
      current = index;
      // scroll to top of form for UX
      const top = document.querySelector('.wizard-container');
      if (top) top.scrollIntoView({behavior: 'smooth', block: 'start'});
    }

    // attach nav handlers safely
    document.querySelectorAll('.next-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (current < sections.length - 1) showSection(current + 1);
      });
    });
    document.querySelectorAll('.prev-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        if (current > 0) showSection(current - 1);
      });
    });

    // init to first section
    showSection(current);


    // ----- Risk scoring (resiko_jatuh) -----
    function updateRiskTotal() {
      let sum = 0;
      document.querySelectorAll('.resiko-select').forEach(function(s){
        // parseInt will capture leading digits even when values are '15a' etc.
        const v = parseInt(s.value, 10);
        sum += isNaN(v) ? 0 : v;
      });

      const totalEl = document.getElementById('resiko-total');
      const hiddenEl = document.getElementById('resiko-total-hidden');
      const categoryEl = document.getElementById('resiko-category');

      if (totalEl) totalEl.value = sum;
      if (hiddenEl) hiddenEl.value = sum;

      let catText = '';
      if (sum >= 0 && sum <= 24) {
        catText = "Tidak berisiko (0-24) - Perawatan yang baik";
      } else if (sum >= 25 && sum <= 44) {
        catText = "Resiko rendah (25-44) - Lakukan intervensi jatuh standar";
      } else if (sum >= 45) {
        catText = "Resiko tinggi (≥45) - Lakukan intervensi jatuh risiko tinggi";
      }
      if (categoryEl) categoryEl.textContent = catText;
    }

    // wire individual selects to update their result cell and total
    document.querySelectorAll('.resiko-select').forEach(function(sel){
      sel.addEventListener('change', function(){
        const name = sel.id; // ex: resiko-riwayat_jatuh
        const suffix = name.replace(/^resiko-/, '');
        const hasilEl = document.getElementById('hasil-' + suffix);
        if (hasilEl) {
          const num = parseInt(sel.value, 10);
          hasilEl.value = isNaN(num) ? '' : num;
        }
        updateRiskTotal();
      });
    });

    // run once to set initial outputs (if selects already have values)
    document.querySelectorAll('.resiko-select').forEach(function(sel){
      const name = sel.id;
      const suffix = name.replace(/^resiko-/, '');
      const hasilEl = document.getElementById('hasil-' + suffix);
      if (hasilEl) {
        const num = parseInt(sel.value, 10);
        hasilEl.value = isNaN(num) ? '' : num;
      }
    });
    updateRiskTotal();


    // ----- IMT calculation -----
    const beratInput = document.querySelector('input[name="DataForm[dataFields][berat_badan]"]');
    const tinggiInput = document.querySelector('input[name="DataForm[dataFields][tinggi_badan]"]');
    const imtInput = document.querySelector('input[name="DataForm[dataFields][imt]"]');

    function updateIMT() {
      const berat = parseFloat(beratInput ? beratInput.value : NaN);
      const tinggiCm = parseFloat(tinggiInput ? tinggiInput.value : NaN);
      if (!isNaN(berat) && !isNaN(tinggiCm) && tinggiCm > 0) {
        const tinggiM = tinggiCm / 100;
        const imt = berat / (tinggiM * tinggiM);
        if (imtInput) imtInput.value = imt.toFixed(2);
      } else {
        if (imtInput) imtInput.value = '';
      }
    }

    if (beratInput && tinggiInput) {
      updateIMT();
      beratInput.addEventListener('input', updateIMT);
      tinggiInput.addEventListener('input', updateIMT);
    }


    // ----- fill id_registrasi from URL if present (useful for page-based create) -----
    // Only set if hidden field exists and currently empty.
    const idField = document.getElementById('formdata-id_registrasi');
    if (idField && !idField.value) {
      try {
        const params = new URLSearchParams(window.location.search);
        const idParam = params.get('id_registrasi') || params.get('id'); // try both
        if (idParam) {
          idField.value = idParam;
          console.log('id_registrasi filled from URL:', idParam);
        }
      } catch (e) {
        // ignore if URLSearchParams not supported (very old browsers)
      }
    }

    // ----- modal fallback: if you still have a modal (not used when page-based), copy trigger data-id into hidden input -----
    const modalEl = document.getElementById('ModalInputForm');
    if (modalEl && bootstrap && typeof bootstrap.Modal === 'function') {
      modalEl.addEventListener('show.bs.modal', function(event) {
        const trigger = event.relatedTarget;
        if (!trigger) return;
        const regId = trigger.getAttribute('data-id');
        if (idField && regId) idField.value = regId;
      });
    }

    // ready
    console.log('Wizard JS initialization complete');
  });
})();
JS;

$this->registerJs($script, \yii\web\View::POS_END);
?>