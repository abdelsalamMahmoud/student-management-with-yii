<?php
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use frontend\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head><meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?></head>
<body><?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => 'Teacher Dashboard',
    'brandUrl'   => Url::to(['/teacher/dashboard']),
    'options'    => ['class' => 'navbar navbar-expand-lg navbar-dark bg-success'],
]);

$items = [
    ['label'=>'Dashboard','url'=>['/teacher/dashboard']],
    ['label'=>'Create Course','url'=>['/teacher/create-course']],
];

if (!Yii::$app->user->isGuest) {
    $items[] = '<li class="nav-item">' .
        Html::a('Logout (' . Yii::$app->user->identity->username . ')',
            ['/site/logout'], [
                'class'=>'nav-link',
                'data-method'=>'post',
                'data-confirm'=>'Logout?',
            ]) .
        '</li>';
}

echo Nav::widget(['options'=>['class'=>'navbar-nav ms-auto'],'items'=>$items]);
NavBar::end();
?>

<div class="container mt-4"><?= $content ?></div>

<?php $this->endBody() ?></body></html><?php $this->endPage() ?>
