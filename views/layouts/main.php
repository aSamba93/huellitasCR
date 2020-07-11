<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/font.css" >  
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Galada&display=swap" >
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <nav>
            <?php
            NavBar::begin([
                'brandLabel' => Html::img('fotosMascotas/Prueba4.png', ['class' => 'nav__logo'], ['alt' => Yii::$app->name]),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'nav__menu navbar-default navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'nav__submenu navbar-nav navbar-right'],
                'items' => [
                        ['label' => ' Registro de Mascotas', 'url' => ['/site/create'], 'visible' => !(Yii::$app->user->isGuest)],
                        ['label' => ' Registro de Usuarios ', 'url' => ['/site/register'], 'visible' => !(Yii::$app->user->isGuest)],
                        ['label' => ' Adopciones', 'url' => ['/site/adoption'], 'visible' => (Yii::$app->user->isGuest)],
                        ['label' => ' Donaciones', 'url' => ['/site/donation'], 'visible' => (Yii::$app->user->isGuest)],
                        ['label' => ' About', 'url' => ['/site/about'], 'visible' => (Yii::$app->user->isGuest)],
                        ['label' => ' Contacto', 'url' => ['/site/contact'], 'visible' => (Yii::$app->user->isGuest)],
                ],
            ]);
            NavBar::end();
            ?>
        </nav>
        <section class="container--pagina">
            <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],])?>
            <?= Alert::widget() ?>
            <?= $content ?>  
            
            <aside class="container__socialbar">
                <?php
                Html::beginForm();
                echo Nav::widget([                
                    'items' => [
                        Yii::$app->user->isGuest ?
                        (                       
                            Html::beginForm(['/site/login'], 'post') .
                            Html::submitButton('', ["class" => "socialbar__icon icon-user-plus"]) .
                            Html::endForm()
                        ) :
                        (
                            Html::beginForm(['/site/logout'], 'post') .
                            Html::submitButton('', ["class" => "socialbar__icon icon-user-minus"]) .
                            Html::endForm()
                        )
                    ],
                ]);
                Html::endForm();
                ?>
                <a href="https://www.facebook.com/AsocHuellitasCostaRica/" class="socialbar__icon icon-facebook" target="_blank"></a>
                <a href="https://www.twitter.com/" class="socialbar__icon icon-twitter" target="_blank"></a>
                <a href="https://www.youtube.com/channel/UCJC7n8sLjDUkPvQalT3IY-Q" class="socialbar__icon icon-youtube" target="_blank"></a>
                <a href="https://www.instagram.com/" class="socialbar__icon icon-instagram" target="_blank"></a>            
            </aside>
        </section>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
