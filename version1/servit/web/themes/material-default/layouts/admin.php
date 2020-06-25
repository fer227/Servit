<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/**
 * @var $this \yii\base\View
 * @var $content string
 */
// $this->registerAssetBundle('app');
?>
<?php $this->beginPage(); ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

        <title><?php echo Html::encode($this->title); ?></title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- CSS  -->
        <link href="<?php echo $this->theme->baseUrl ?>/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
        <link href="<?php echo $this->theme->baseUrl ?>/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <nav class="red lighten-1" role="navigation">
        <div class="container">
            <div class="nav-wrapper">
                <a id="logo-container" href="<?=Url::to(['site/index'])?>" class="brand-logo">
                    <img class="logoNav" src="<?=Url::to('@web/images/logo_blanco.svg')?>">
                </a>
                <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
                <?php
                echo Menu::widget([
                    'options' => ['id' => "nav", 'class' => 'right hide-on-med-and-down'],
                    'linkTemplate' => '<a href="{url}"><b>{label}</b></a>',
                    'items' => [
                        Yii::$app->user->isGuest ? (
                        ['label' => 'Home', 'url' => ['/site/index']]
                        ) : (
                        ['label' => 'Home', 'url' => ['/site/menu-propietario']]
                        ),
                        Yii::$app->user->isGuest ? (
                        ['label' => 'Iniciar sesión', 'url' => ['/site/login'], 'template' => '<a class="indigo-text text-lighten-1" href="{url}">{label}</a>', 'options' => ['class' => 'btn-small white botonLogin']]
                        ) : (
                        ['label' => 'Salir (' . Yii::$app->user->identity->username . ')', 'template' => '<a class="indigo-text text-lighten-1" href="{url}">{label}</a>', 'url' => ['site/logout'], 'options' => ['class' => 'btn-small white botonLogin']]
                        )
                        /*['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['site/logout'], 'visible' => !Yii::$app->user->isGuest, 'linkOptions' => ['data-method' => 'post']],*/
                    ],
                ]);
                ?>
                <?php
                echo Menu::widget([
                    'options' => ['id' => "nav-mobile", 'class' => 'sidenav'],
                    'linkTemplate' => '<a href="{url}"><b>{label}</b></a>',
                    'items' => [
                        Yii::$app->user->isGuest ? (
                        ['label' => 'Home', 'url' => ['/site/index']]
                        ) : (
                        ['label' => 'Home', 'url' => ['/site/menu-propietario']]
                        ),
                        Yii::$app->user->isGuest ? (
                        ['label' => 'Iniciar sesión', 'url' => ['/site/login'], 'template' => '<a class="indigo-text text-lighten-1" href="{url}">{label}</a>',]
                        ) : (
                        ['label' => 'Salir (' . Yii::$app->user->identity->username . ')', 'template' => '<a class="indigo-text text-lighten-1" href="{url}">{label}</a>', 'url' => ['site/logout']]
                        )
                        /*['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['site/logout'], 'visible' => !Yii::$app->user->isGuest, 'linkOptions' => ['data-method' => 'post']],*/
                    ],
                ]);
                ?>

            </div>
        </div>
    </nav>
    <main>

        <div class="col s12 m12">
            <?php echo $content; ?>
        </div>

    </main>
    <?php if ( Yii::$app->user->isGuest): ?>

        <footer class="red lighten-1">
            <div class="container">
                <div class="row">
                    <div class="col 12">
                        <h5 class="white-text">Otros sitios de interés</h5>
                        <ul>
                            <li><a class="white-text" href="#!">Sobre nosotros</a></li>
                            <li><a class="white-text" href="#!">Política de datos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    <?php endif; ?>

    <!--  Scripts-->
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="<?php echo $this->theme->baseUrl ?>/js/materialize.js"></script>
    <script src="<?php echo $this->theme->baseUrl ?>/js/init.js"></script>

    <?php $this->endBody() ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>M.AutoInit()</script>
    </body>
    </html>
<?php $this->endPage(); ?>