<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\helpers\Url;

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
    <nav class="red lighten-1 nav-extended" role="navigation">
        <div class="container">
            <div class="nav-wrapper">
                <a id="logo-container" href="<?=Url::to(['camarero/index'])?>" class="brand-logo center">
                    <img class="logoMain" src="<?=Url::to('@web/images/logo_blanco.svg')?>">
                </a>
                <?php
                echo Menu::widget([
                    'linkTemplate' => '<a href="{url}"><b>{label}</b></a>',
                    'items' => [
                        ['url' => ['camarero/index'], 'template' => '<a href="{url}"><i class="material-icons">autorenew</i>{label}</a>', 'visible' => !Yii::$app->user->isGuest, 'active' => false],
                    ],
                ]);
                ?>
            </div>
            <div class="nav-content">
                <ul class="tabs tabs-transparent tabs-fixed-width">
                    <li class="tab"><a class="active" href="#test1">Mis mesas</a></li>
                    <li class="tab"><a href="#test2">Todas</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main>

        <div class="col s12 m12">
            <?php echo $content; ?>
        </div>

    </main>

    <!--  Scripts-->
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="<?php echo $this->theme->baseUrl ?>/js/materialize.js"></script>
    <script src="<?php echo $this->theme->baseUrl ?>/js/init.js"></script>

    <?php $this->endBody() ?>
    <script>M.AutoInit()</script>
    </body>
    </html>
<?php $this->endPage(); ?>