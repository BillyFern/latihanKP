<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Pasien $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pasien-form p-4 bg-white rounded shadow-sm" style="max-width: 700px; margin: auto;">

    <?php $form = ActiveForm::begin([
        'action' => $model->isNewRecord ? ['pasien/create'] : ['pasien/update', 'id_pasien' => $model->id_pasien],
        'method' => 'post',
    ]); ?>

    <h5 class="mb-4 fw-bold">Informasi Dasar Pasien</h5>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'no_rekam_medis')->textInput([
            'readonly' => true,
            'class' => 'form-control bg-light',
        ]) ?>
    <?php else: ?>
        <div class="alert alert-info">
            Nomor Rekam Medis akan di-generate otomatis setelah data disimpan.
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'nama')->textInput([
        'maxlength' => true, 
        'placeholder' => 'Nama Lengkap',
    ]) ?>

    <?= $form->field($model, 'tanggal_lahir')->widget(DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'DD/MM/YYYY',
            'autocomplete' => 'off',
        ],
        'clientOptions' => [
            'changeYear' => true,
            'changeMonth' => true,
            'yearRange' => '1920:' . date('Y'),
            'maxDate' => 'today'
        ]
    ]) ?>

    <?= $form->field($model, 'nik')->textInput([
        'maxlength' => 16,
        'placeholder' => 'Nomor Induk Kependudukan',
        'type' => 'number',
    ]) ?>

    <div class="form-group text-end mt-4">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan Perubahan', [
            'class' => 'btn btn-warning px-4 py-2'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// CSS untuk tampilan modern tanpa center
$this->registerCss("
    .pasien-form .form-control {
        border-radius: 6px;
        padding: 10px;
        box-shadow: none;
        border: 1px solid #ced4da;
        text-align: left; /* Rata kiri */
    }
    .pasien-form .form-control:focus {
        border-color: #f0ad4e;
        box-shadow: 0 0 0 0.2rem rgba(240, 173, 78, 0.25);
    }
    .pasien-form .alert-info {
        font-size: 0.9rem;
        padding: 8px 12px;
        text-align: left; /* Rata kiri */
    }
    .pasien-form .field-pasien-nama label,
    .pasien-form .field-pasien-tanggal_lahir label,
    .pasien-form .field-pasien-nik label,
    .pasien-form .field-pasien-no_rekam_medis label {
        text-align: left; /* Label rata kiri */
        display: block;
        width: 100%;
        font-weight: 500;
    }
");
?>
