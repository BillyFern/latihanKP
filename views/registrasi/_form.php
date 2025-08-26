<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Pasien;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Registrasi $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="registrasi-form">

    <?php 
    // Set form action dynamically: 'create' for new record, 'update' for existing
    $action = $model->isNewRecord 
        ? ['registrasi/create'] 
        : ['registrasi/update', 'id' => $model->id_registrasi];

    $form = ActiveForm::begin([
        'id' => 'registrasi-form',
        'action' => $action,
        'method' => 'post',
        'options' => ['data-pjax' => true], // optional if using PJAX
    ]); 
    ?>

    <?php
    // Prepare pasien dropdown data
    $pasienList = ArrayHelper::map(
        Pasien::find()->orderBy('nama')->asArray()->all(), 
        'no_rekam_medis', 
        function($model) {
            return $model['no_rekam_medis'] . ' - ' . $model['nama'];
        }
    );
    ?>

    <?= $form->field($model, 'no_rekam_medis')->widget(Select2::class, [
        'data' => $pasienList,
        'options' => [
            'placeholder' => 'Ketik untuk mencari No. RM atau Nama Pasien...',
            'value' => $model->no_rekam_medis, // preselect current value
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Pilih Pasien') ?>

    <div class="form-group mt-4">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan Registrasi' : 'Update Registrasi', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
// NOTE:
// 1. This form now works for both creating and updating.
// 2. Preselects the current pasien when editing.
// 3. Make sure kartik-v select2 extension is installed:
//    composer require kartik-v/yii2-widget-select2
?>
