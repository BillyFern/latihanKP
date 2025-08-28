<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow-lg border-primary rounded-3 p-4" style="width: 380px;">
        
        <!-- Logo -->
        <div class="text-center mb-3">
            <?= Html::img('@web/img/logo_bigs.png', [
                'alt' => 'Logo',
                'style' => 'height: 60px;',
            ]) ?>
        </div>

        <!-- Judul -->
        <h5 class="text-center fw-bold mb-4">Login your account!</h5>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'needs-validation'],
        ]); ?>

        <!-- Email / Username -->
        <?= $form->field($model, 'usernameOrEmail', [
            'options' => ['class' => 'mb-3'],
        ])->textInput([
            'placeholder' => 'Email',
            'class' => 'form-control',
        ])->label(false) ?>

        <!-- Password -->
        <?= $form->field($model, 'password', [
            'options' => ['class' => 'mb-3'],
        ])->passwordInput([
            'placeholder' => 'Password',
            'class' => 'form-control',
        ])->label(false) ?>

        <!-- Tombol -->
        <div class="d-grid">
            <?= Html::submitButton('Login', [
                'class' => 'btn btn-warning fw-bold text-white',
                'style' => 'border-radius: 6px;',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
