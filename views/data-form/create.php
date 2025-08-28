<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataform app\models\DataForm */

$this->title = 'Form Keperawatan';
$this->params['breadcrumbs'][] = ['label' => 'Data Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-form-create">

    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= \yii\widgets\Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
            'options' => ['class' => 'breadcrumb-custom'],
        ]) ?>
    </div>

    <?= $this->render('..\registrasi\_form_data', [
        'dataform' => $dataform,
    ]) ?>
</div>
