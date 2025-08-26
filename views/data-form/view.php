    <?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pasien $model */
/** @var app\models\Registrasi $model_registrasi */
/** @var app\models\DataForm $model_form */

$this->title = "Detail Pasien: " . $model_registrasi->pasien->nama;
$this->params['breadcrumbs'][] = ['label' => 'Pasien', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Register external CSS for print-friendly layout
$this->registerCssFile('@web/css/print.css', [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
]);
?>

<div class="document-container">

    <div class="logo-header" style="text-align: center;">
        <?= \yii\helpers\Html::img('@web/img/logo_bigs.png', ['alt' => 'My Logo', 'style' => 'width:180px']) ?>
    </div>
    <!-- Header -->
    <div class="document-header">
        <div class="row mx-auto">
            <div class="col-8 text-center">
                <h5><strong>PENGKAJIAN KEPERAWATAN</strong></h5>
                <h5><strong>POLIKLINIK KEBIDANAN</strong></h5>
            </div>
            <div class="col-4">
                <p>Nama Lengkap : <strong><?= $model_registrasi->pasien ? Html::encode($model_registrasi->pasien->nama) : '(Data Pasien Tidak Ditemukan)' ?> </strong></p>
                <p>Tanggal Lahir : <strong><?= $model_registrasi->pasien ? Html::encode($model_registrasi->pasien->getTanggalLahirFormatted()) : '-' ?></strong></p>
                <p>No. RM : <strong><?= Html::encode($model_registrasi->no_rekam_medis) ?></strong></p>
            </div>
        </div>
    </div>
    <hr>

    <!-- Patient Information -->
    <table style="max-width: 42%;">
        <tr>
            <td>Tanggal Pengkajian</td>
            <td>: <?= Yii::$app->formatter->asDate($model_form->create_time_at, 'dd/MM/yyyy') ?></td>
        </tr>
        <tr>
            <td>Jam Pengkajian</td>
            <td>: <?= Yii::$app->formatter->asDatetime($model_form->create_time_at, 'HH:mm') ?></td>
        </tr>
        <tr>
            <td>Poliklinik</td>
            <td>: KLINIK OBGYN</td>
        </tr>
    </table>

    <div class="pengkajian-title">
        <p><strong>Pengkajian saat datang (diisi oleh perawat)</strong></p>
    </div>

     <!-- 1-4 -->
    <table>
        <colgroup>
            <col style="width: 1%;">
            <col style="width: 21.4%;">
            <col style="width: auto;">
        </colgroup>
        <tr>
            <td>1.</td>
            <td>&nbsp;Cara masuk</td>
            <td>: 
                <?php
                // decode JSON
                $data = json_decode($model_form->data, true);

                // possible options
                $options = ['Jalan tanpa bantuan' => 'Jalan tanpa bantuan', 'Kursi tanpa bantuan' => 'Kursi tanpa bantuan', 'Tempat tidur dorong' => 'Tempat tidur dorong', 'Lain-lain' => 'Lain-lain'];

                // selected values (from JSON)
                $selected = (array) $data['cara_masuk'] ?? [];

                // render checkboxes horizontally
                foreach ($options as $key => $label) {
                    $checked = in_array($key, $selected) ? 'checked' : '';
                    echo "<label style='margin-right:9px;'>
                            <input type='checkbox' disabled $checked style='transform:translateY(3px);'> $label
                        </label>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>2.</td>
            <td>&nbsp;Anamnesis</td>
            <td>: 
                <?php
                // possible options
                $options = ['Autoanamnesis' => 'Autoanamnesis', 'Aloanamnesis' => 'Aloanemnesis'];

                // selected values (from JSON)
                $selected = (array) $data['anamnesis'] ?? [];

                // render checkboxes horizontally
                foreach ($options as $key => $label) {
                    $checked = in_array($key, $selected) ? 'checked' : '';
                    echo "<label style='margin-right:9px;'>
                            <input type='checkbox' disabled $checked style='transform:translateY(3px);'> $label
                        </label>";
                }
                ?>
                Diperoleh: 
                <?php 
                    $diperoleh = $data['diperoleh'];
                    echo $diperoleh;
                ?> &nbsp; Hubungan: 
                <?php
                    $hubungan = $data['hubungan'];
                    echo $hubungan;
                ?>
            </td> 
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
            <td>&nbsp;Alergi</td>
            <td>: 
                <?php 
                    $alergi = $data['alergi'];
                    echo $alergi;
                ?>
            </td>
        </tr>
        <tr>
            <td>3.</td>
            <td>&nbsp;Keluhan utama saat ini</td>
            <td>: 
                <?php
                    $keluhan_utama = $data['keluhan_utama'];
                    echo $keluhan_utama;
                ?>
            </td>
        </tr>
        <tr>
            <td>4.</td>
            <td>&nbsp;Pemeriksaan fisik :</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>&nbsp;a. Keadaan umum</td>
            <td>: 
                <?php
                // possible options
                $options = ['Tidak tampak sakit' => 'Tidak tampak sakit', 'Sakit ringan' => 'Sakit ringan', 'Sedang' => 'Sedang', 'Berat' => 'Berat'];

                // selected values (from JSON)
                $selected = (array) $data['keadaan_umum'] ?? [];

                // render checkboxes horizontally
                foreach ($options as $key => $label) {
                    $checked = in_array($key, $selected) ? 'checked' : '';
                    echo "<label style='margin-right:9px;'>
                            <input type='checkbox' disabled $checked style='transform:translateY(3px);'> $label
                        </label>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>&nbsp;b. Warna kulit</td>
            <td>: 
                <?php
                // possible options
                $options = ['Normal' => 'Normal', 'Sianosis' => 'Sianosis', 'Pucat' => 'Pucat', 'Kemerahan' => 'Kemerahan'];

                // selected values (from JSON)
                $selected = (array) $data['warna_kulit'] ?? [];

                // render checkboxes horizontally
                foreach ($options as $key => $label) {
                    $checked = in_array($key, $selected) ? 'checked' : '';
                    echo "<label style='margin-right:9px;'>
                            <input type='checkbox' disabled $checked style='transform:translateY(3px);'> $label
                        </label>";
                }
                ?>
            </td>
        </tr>
    </table>
    
    <!--kesadaran dll -->
    <table>
        <colgroup>
            <col style="width: 2%;">
            <col style="width: 27%;">
            <col style="width: 27%;">
            <col style="width: 21%;">
            <col style="width: 18%">
        </colgroup>
        <tr>
            <td style=></td>
            <td style="border: 1px solid black; vertical-align: top;">
                Kesadaran:
                <?php
                $options = ['Compos mentis' => 'Compos mentis', 'Apatis' => 'Apatis', 'Somnolent' => 'Somnolent', 'Sopor' => 'Sopor', 'Soporokoma' => 'Soporokoma', 'Koma' => 'Koma'];
                $selected = $data['kesadaran'] ?? null;

                foreach ($options as $key => $label) {
                    $checked = ($selected === $key) ? 'checked' : '';
                    echo "<label style='display:block; margin-bottom:4px;'>
                            <input type='radio' disabled $checked style='margin-right:6px; vertical-align:middle;'>
                            <span style='vertical-align:middle;'>$label</span>
                        </label>";
                }
                ?>
            </td>
            <td style="border: 1px solid black; vertical-align: top;">
                Tanda vital: <br>
                <input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'>TD &nbsp;&nbsp;:
                <?php 
                    $td = $data['tanda_vital_td'];
                    echo $td;
                ?>
                mmHg <br>
                <input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'>P &nbsp;&nbsp;&nbsp;&nbsp;:
                <?php 
                    $p = $data['tanda_vital_p'];
                    echo $p;
                ?>
                x/menit <br>
                <input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'>N &nbsp;&nbsp;&nbsp;&nbsp;:
                <?php 
                    $n = $data['tanda_vital_n'];
                    echo $n;
                ?>
                x/menit <br>
                <input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'>S &nbsp;&nbsp;&nbsp;&nbsp;:
                <?php 
                    $s = $data['tanda_vital_s'];
                    echo $s;
                ?>
                oC <br>
            </td>
            <td style="border: 1px solid black; vertical-align: top;">
                Fungsional: <br>
                <table>
                    <colgroup>
                        <col style="width: 65%;">
                        <col style="width: 35%;">
                    </colgroup>
                    <tr>
                        <td>1. Alat bantu</td>
                        <td>: 
                            <?php 
                                $ab = $data['fungsional_ab'];
                                echo $ab;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>2. Prothesa</td>
                        <td>: 
                            <?php 
                                $p = $data['fungsional_p'];
                                echo $p;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>3. Cacat tubuh</td>
                        <td>: 
                            <?php 
                                $ct = $data['fungsional_ct'];
                                echo $ct;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>4. ADL</td>
                        <td>: 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            $options = ['Mandiri' => 'Mandiri', 'Dibantu' => 'Dibantu'];
                            $selected = $data['fungsional_adl'] ?? null;

                            foreach ($options as $key => $label) {
                                $checked = ($selected === $key) ? 'checked' : '';
                                echo "<label style='display:block; margin-bottom:4px;'>
                                        <input type='radio' disabled $checked style='margin-right:6px; vertical-align:middle;'>
                                        <span style='vertical-align:middle;'>$label</span>
                                    </label>";
                            }
                            ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>5. Riwayat jatuh</td>
                        <td>: 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            $options = ['+' => '+', '-' => '-'];
                            $selected = $data['fungsional_rj'] ?? null;

                            foreach ($options as $key => $label) {
                                $checked = ($selected === $key) ? 'checked' : '';
                                echo "<label style='display:block; margin-bottom:4px;'>
                                        <input type='radio' disabled $checked style='margin-right:6px; vertical-align:middle;'>
                                        <span style='vertical-align:middle;'>$label</span>
                                    </label>";
                            }
                            ?>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td style="border: 1px solid black; vertical-align: top;">
                Antrapometri:
                <table>
                    <colgroup>
                        <col style="width: 65%;">
                        <col style="width: 35%;">
                    </colgroup>
                    <tr>
                        <td><input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'> Berat badan</td>
                        <td>: 
                            <?php 
                                $berat_badan = $data['berat_badan'];
                                echo $berat_badan;
                            ?> Kg
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'> Tinggi badan</td>
                        <td>:
                            <?php 
                                $tinggi_badan = $data['tinggi_badan'];
                                echo $tinggi_badan;
                            ?> Cm
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'> Panjang badan (PB)</td>
                        <td>:
                            <?php 
                                $panjang_badan = $data['panjang_badan'];
                                echo $panjang_badan;
                            ?> Cm
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'> Lingkar kepala (LK)</td>
                        <td>:
                            <?php 
                                $lingkar_kepala = $data['lingkar_kepala'];
                                echo $lingkar_kepala;
                            ?> Cm
                        </td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" checked disabled style='margin-right:6px; transform:translateY(3px);'> IMT</td>
                        <td>:
                            <?php 
                                $imt = $data['imt'];
                                echo $imt;
                            ?> Cm
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Catatan :</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2">PB & LK Khusus Pediatri</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- 4c-8 -->
    <table>
        <colgroup>
            <col style="width: 1%;">
            <col style="width: 22%;">
            <col style="width: auto;">
        </colgroup>
        <tr>
            <td></td>
            <td>c. Status gizi</td>
            <td>: 
                <?php
                // possible options
                $options = ['Ideal' => 'Ideal', 'Kurang' => 'Kurang', 'Obesitas/overweight' => 'Obesitas/overweight'];

                // selected values (from JSON)
                $selected = (array) $data['status_gizi'] ?? [];

                // render checkboxes horizontally
                foreach ($options as $key => $label) {
                    $checked = in_array($key, $selected) ? 'checked' : '';
                    echo "<label style='margin-right:9px;'>
                            <input type='checkbox' disabled $checked style='transform:translateY(3px);'> $label
                        </label>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>5.</td>
            <td>&nbsp;Riwayat penyakit sekarang</td>
            <td>:
                <?php 
                    $riwayat_penyakit_sekarang = $data['riwayat_penyakit_sekarang'];
                    echo $riwayat_penyakit_sekarang;
                ?>
            </td>
        </tr>
        <tr>
            <td>6.</td>
            <td>&nbsp;Riwayat penyakit sebelumnya</td>
            <td>:
                <?php
                // possible options
                $options = ['DM' => 'DM', 'Hipertensi' => 'Hipertensi', 'Jantung' => 'Jantung', 'JantLain-lainung' => 'Lain-lain'];

                // selected values (from JSON)
                $selected = (array) $data['riwayat_penyakit_sebelumnya'] ?? [];

                // render checkboxes horizontally
                foreach ($options as $key => $label) {
                    $checked = in_array($key, $selected) ? 'checked' : '';
                    echo "<label style='margin-right:9px;'>
                            <input type='checkbox' disabled $checked style='transform:translateY(3px);'> $label
                        </label>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>7.</td>
            <td>&nbsp;Riwayat penyakit</td>
            <td>:
                <?php
                $options = ['Tidak' => 'Tidak', 'Ya' => 'Ya'];
                $selected = $data['riwayat_penyakit'] ?? null;

                foreach ($options as $key => $label) {
                    $checked = ($selected === $key) ? 'checked' : '';
                    echo "<label style='display:inline-block; margin-bottom:4px;'>
                            <input type='radio' disabled $checked style='margin-right:3px; vertical-align:middle;'>
                            <span style='vertical-align:middle; margin-right:2px'>$label</span>
                        </label>";
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>8.</td>
            <td>&nbsp;Riwayat penyakit keluarga</td>
            <td>:
                <?php 
                    $riwayat_penyakit_keluarga = $data['riwayat_penyakit_keluarga'];
                    echo $riwayat_penyakit_keluarga;
                ?>
            </td>
        </tr>
    </table>

    <!-- 9-10 -->
    <table>
        <colgroup>
            <col style="width: 1%;">
            <col style="width: 22%;">
            <col style="width: 37%;">
            <col style="width: 19%;">
            <col style="width: 21%;">
        </colgroup>
        <tr>
            <td rowspan="2">9.</td>
            <td rowspan="2">Riwayat operasi</td>
            <td rowspan="2">:
                <?php
                $options = ['Tidak' => 'Tidak', 'Ya' => 'Ya'];
                $selected = $data['riwayat_operasi'] ?? null;

                foreach ($options as $key => $label) {
                    $checked = ($selected === $key) ? 'checked' : '';
                    echo "<label style='display:inline-block; margin-bottom:4px;'>
                            <input type='radio' disabled $checked style='margin-right:3px; vertical-align:middle;'>
                            <span style='vertical-align:middle; margin-right:2px'>$label</span>
                        </label>";
                }
                ?>
            </td>
            <td>Operasi apa ?</td>
            <td>:
                <?php 
                    $riwayat_operasi_apa = $data['riwayat_operasi_apa'];
                    echo $riwayat_operasi_apa;
                ?>
            </td>
        </tr>
        <tr>
            <td>Kapan ?</td>
            <td>:
                <?php 
                    $riwayat_operasi_tahun = $data['riwayat_operasi_tahun'];
                    echo $riwayat_operasi_tahun;
                ?>
            </td>
        </tr>
        <tr>
            <td rowspan="2">10.</td>
            <td rowspan="2">Riwayat pernah dirawat di RS</td>
            <td rowspan="2">:
                <?php
                $options = ['Tidak' => 'Tidak', 'Ya' => 'Ya'];
                $selected = $data['riwayat_dirawat_rs'] ?? null;

                foreach ($options as $key => $label) {
                    $checked = ($selected === $key) ? 'checked' : '';
                    echo "<label style='display:inline-block; margin-bottom:4px;'>
                            <input type='radio' disabled $checked style='margin-right:3px; vertical-align:middle;'>
                            <span style='vertical-align:middle; margin-right:2px'>$label</span>
                        </label>";
                }
                ?>
            </td>
            <td>Penyakit apa ?</td>
            <td>:
                <?php 
                    $riwayat_penyakit_apa = $data['riwayat_penyakit_apa'];
                    echo $riwayat_penyakit_apa;
                ?>
            </td>
        </tr>
        <tr>
            <td>Kapan ?</td>
            <td>:
                <?php 
                    $riwayat_dirawat_tahun = $data['riwayat_dirawat_tahun'];
                    echo $riwayat_dirawat_tahun;
                ?>
            </td>
        </tr>
    </table>
    
    <!-- 15 -->
    <div style="display: flex; gap: 10px; padding-top: 20px;">
        <!-- Left table -->
        <div style="flex: 4;">
            <table>
                <colgroup>
                    <col style="width: 1%;">
                    <col style="width: 17%;">
                    <col style="width: 42%;">
                    <col style="width: 20%;">
                    <col style="width: 20%;">
                </colgroup>
                <tr>
                    <td>15.</td>
                    <td colspan="3">Pengkajian resiko jatuh</td>
                </tr>
                <tr style="text-align: center;">
                    <td style="border: solid black 1px;"><strong>No</strong></td>
                    <td colspan="2" style="border: solid black 1px;"><strong>Resiko</strong></td>
                    <td style="border: solid black 1px;"><strong>Skala</strong></td>
                    <td style="border: solid black 1px;"><strong>Hasil</strong></td>
                </tr> 
                <!--1-->
                <tr>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">1</td>
                    <td rowspan="2" colspan="2" style="border: solid black 1px;">Riwayat jatuh yang baru atau dalam 3 bulan terakhir</td>
                    <td style="text-align: center; border: solid black 1px;">Tidak = 0</td>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">
                        <?php 
                            $riwayat_jatuh = $data['resiko_jatuh']['riwayat_jatuh'];
                            echo $riwayat_jatuh;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; border: solid black 1px;">Ya = 25</td>
                </tr>
                
                <!--2-->
                <tr>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">2</td>
                    <td rowspan="2" colspan="2" style="border: solid black 1px;">Diagnosa medis sekunder > 1</td>
                    <td style="text-align: center; border: solid black 1px;">Tidak = 0</td>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">
                        <?php 
                            $diagnosa_sekunder = $data['resiko_jatuh']['diagnosa_sekunder'];
                            echo $diagnosa_sekunder;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; border: solid black 1px;">Ya = 25</td>
                </tr>

                <!--3-->
                <tr>
                    <td rowspan="3" style="text-align: center; border: solid black 1px;">3</td>
                    <td rowspan="3" style="border: solid black 1px;">Alat bantu jalan :</td>
                    <td style="border: solid black 1px;">Mandiri, bedrets, dibantu perawat, kuris roda</td>
                    <td style="text-align: center; border: solid black 1px;">0</td>
                    <td rowspan="3" style="text-align: center; border: solid black 1px;">
                        <?php 
                            $alat_bantu = $data['resiko_jatuh']['alat_bantu'] ?? '';
                            $alat_bantu = preg_replace('/[^0-9]/', '', $alat_bantu); 
                            echo $alat_bantu;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border: solid black 1px;">Penopang, tongkat/walker</td>
                    <td style="text-align: center; border: solid black 1px;">15</td>
                </tr>
                <tr>
                    <td style="border: solid black 1px;">Mencengkeram furniture/sesuatu untuk topangan</td>
                    <td style="text-align: center; border: solid black 1px;">25</td>
                </tr>

                <!--4-->
                <tr>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">4</td>
                    <td rowspan="2" colspan="2" style="border: solid black 1px;">Ad akses IV atau terapi heparin lock</td>
                    <td style="text-align: center; border: solid black 1px;">Tidak = 0</td>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">
                        <?php 
                            $iv_heparin = $data['resiko_jatuh']['iv_heparin'];
                            echo $iv_heparin;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; border: solid black 1px;">Ya = 20</td>
                </tr>
                
                <!--5-->
                <tr>
                    <td rowspan="3" style="text-align: center; border: solid black 1px;">5</td>
                    <td rowspan="3" style="border: solid black 1px;">Cara berjalan/berpindah :</td>
                    <td style="border: solid black 1px;">Normal</td>
                    <td style="text-align: center; border: solid black 1px;">0</td>
                    <td rowspan="3" style="text-align: center; border: solid black 1px;">
                        <?php 
                            $berjalan = $data['resiko_jatuh']['berjalan'];
                            echo $berjalan;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border: solid black 1px;">Lemah, langkah, diseret</td>
                    <td style="text-align: center; border: solid black 1px;">10</td>
                </tr>
                <tr>
                    <td style="border: solid black 1px;">Terganggu, perlu bantuan, keseimbangan buruk</td>
                    <td style="text-align: center; border: solid black 1px;">20</td>
                </tr>

                <!--6-->
                <tr>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">6</td>
                    <td rowspan="2" style="border: solid black 1px;">Status mental :</td>
                    <td style="border: solid black 1px;">Orientasi sesuai kemampuan diri</td>
                    <td style="text-align: center; border: solid black 1px;">0</td>
                    <td rowspan="2" style="text-align: center; border: solid black 1px;">
                        <?php 
                            $status_mental = $data['resiko_jatuh']['status_mental'];
                            echo $status_mental;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="border: solid black 1px;">Lupa keterbatasan diri</td>
                    <td style="text-align: center; border: solid black 1px;">15</td>
                </tr>
                
                <tr>
                    <td colspan="4" style="text-align: center; border: solid black 1px;"><strong>Nilai total</strong></td>
                    <td style="text-align: center; border: solid black 1px;">
                        <strong>
                            <?php 
                                $nilai_total = $data['resiko_jatuh']['nilai_total'];
                                echo $nilai_total;
                            ?>
                        </strong>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Right text box -->
        <div style="flex: 1; margin-top:40px;">
            <table>
                <tr style="text-align: center; border: solid black 1px;">
                    <td>
                        <strong>Tidak beresiko : 0-24</strong>
                        <br><br>
                        <strong>Perawatan yang baik</strong>
                    </td>
                </tr>
                <tr style="text-align: center; border: solid black 1px;">
                    <td>
                        <strong>Resiko rendah : 25-44</strong>
                        <br><br>
                        <strong>Lakukan intervensi jatuh standar</strong>
                    </td>
                </tr>
                <tr style="text-align: center; border: solid black 1px;">
                    <td>
                        <strong>Resiko tinggi : >=45</strong>
                        <br><br>
                        <strong>Lakukan intervensi jatuh risiko tinggi</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section" style="padding-top: 20px">
        <table style="width:45%;">
            <colgroup>
                <col style="width:50%;">
                <col style="width:50%;">
            </colgroup>
            <tr>
                <td></td>
                <td style="text-align: center; border: solid black 1px;">Petugas</td>
            </tr>
            <tr>
                <td style="border: solid black 1px;">Tanggal / pukul</td>
                <td style="text-align: center; border: solid black 1px;">
                    <?= Yii::$app->formatter->asDatetime($model_form->create_time_at, 'dd/MM/yyyy HH:mm') ?>
                </td>
            </tr>
            <tr>
                <td style="border: solid black 1px;">Nama lengkap</td>
                <td style="text-align: center; border: solid black 1px;">
                    CONTOH PETUGAS
                </td>
            </tr>
            <tr>
                <td style="border: solid black 1px;">Tanda Tangan <br><br><br></td>
                <td style="text-align: center; border: solid black 1px;"></td>
            </tr>
        </table>
    </div>

    <!-- Print Button (hidden on print) -->
    <div class="no-print text-center" style="margin-top:20px;">
        <?= Html::button('🖨 Print', [
            'class' => 'btn btn-primary',
            'onclick' => 'window.print()',
        ]) ?>
    </div>

</div>
