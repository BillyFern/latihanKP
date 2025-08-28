<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
\kartik\select2\Select2Asset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css", [
        'crossorigin' => 'anonymous',
    ]); ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        // tampilkan navbar selain di halaman login
        if (!(Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'login')) {
            NavBar::begin([
                'brandLabel' => Html::img('@web/img/logo3.png', [
                    'alt' => Yii::$app->name,
                    'style' => 'height:40px;',
                ]),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-expand-md custom-navbar',
                ],
            ]);

            // kalau bukan di dashboard, tampilkan menu pasien & registrasi
            if (!(Yii::$app->controller->id === 'site' && Yii::$app->controller->action->id === 'dashboard')) {
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
                    'items' => [
                        ['label' => 'pasien', 'url' => ['/pasien/index']],
                        ['label' => 'registrasi', 'url' => ['/registrasi/index']],
                    ],
                    'activateParents' => true,
                ]);
            }

            // selalu tampilkan logout di kanan
            echo Nav::widget([
    'options' => ['class' => 'navbar-nav ms-auto'],
    'items' => [
        Yii::$app->user->isGuest
            ? ['label' => 'Login', 'url' => ['/site/login']]
            : '<li class="nav-item">'
                . Html::button(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    [
                        'class' => 'btn btn-danger text-white px-3 py-1 ms-2',
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#ModalLogout'
                    ]
                )
                . '</li>'
    ],
]);


            NavBar::end();
        }
        ?>
    </header>


    <?php
    // CSS khusus untuk navbar
    $this->registerCss("
    .custom-navbar {
        background-color: #0f2557; /* biru tua */
        padding: 0.5rem 1rem;
    }
    .custom-navbar .navbar-brand img {
        max-height: 40px;
    }
    .custom-navbar .navbar-nav .nav-link {
        color: #fff;
        font-weight: 500;
        margin-right: 15px;
        border-radius: 8px 8px 0 0;
        padding: 6px 12px;
    }
    .custom-navbar .navbar-nav .nav-link.active,
    .custom-navbar .navbar-nav .nav-link:hover {
        background-color: #fff;
        color: #0f2557 !important;
    }
    @media (max-width: 768px) {
        .custom-navbar .navbar-nav .nav-link {
            margin: 5px 0;
        }
    }
");
    ?>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>

            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>
<?php
use yii\bootstrap5\Modal;

Modal::begin([
    'id' => 'ModalLogout',
    'options' => ['class' => 'fade'],
    'dialogOptions' => ['class' => 'modal-dialog-centered'],
    'closeButton' => false,
]);
?>
<div class="text-center p-4">
    <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center"
             style="width: 80px; height: 80px; border: 4px solid #0f2557;">
            <i class="fas fa-sign-out-alt text-primary" style="font-size: 2.5rem;"></i>
        </div>
    </div>

    <h5 class="fw-bold mb-2">Konfirmasi Logout</h5>
    <p class="text-muted">Apakah Anda yakin ingin keluar dari aplikasi?</p>

    <?= Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form']) ?>
    <div class="d-flex justify-content-center gap-2 mt-3">
        <button type="submit" class="btn btn-danger px-4">
            Ya, Logout
        </button>
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
            Batal
        </button>
    </div>
    <?= Html::endForm() ?>
</div>
<?php Modal::end(); ?>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>