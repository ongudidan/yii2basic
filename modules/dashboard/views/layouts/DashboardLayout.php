<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\DashboardAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

DashboardAsset::register($this);

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
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <div class="main-wrapper">

        <?= $this->render('components/_header') ?>
        <?= $this->render('components/_sidebar') ?>

        <main id="main" class="flex-shrink-0" role="main">
            <div class="page-wrapper">
                <div class="content container-fluid">
                    <?= $this->render('components/_page-header') ?>
                    <?php
                    // Display flash messages if any are set
                    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                        echo '<div class="alert alert-' . $key . ' alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>' . $message . '
        </div>';
                    }
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>