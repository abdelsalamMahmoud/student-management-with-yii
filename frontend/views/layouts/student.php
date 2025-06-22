<?php

/** @var \yii\web\View $this */
/** @var string $content */

use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?php
    NavBar::begin([
        'brandLabel' => 'Student Dashboard',
        'brandUrl' => \yii\helpers\Url::to(['/student/dashboard']),
        'options' => ['class' => 'navbar navbar-expand-lg navbar-dark bg-primary'],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Dashboard', 'url' => ['/student/dashboard']],
            ['label' => 'Available Courses', 'url' => ['/student/available-courses']],
            ['label' => 'My Courses', 'url' => ['/student/my-courses']],
            ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
        ],
    ]);

    NavBar::end();
    ?>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>