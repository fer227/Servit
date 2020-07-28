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
  <nav class="red lighten-1" role="navigation">
    <div class="container">
      <div class="nav-wrapper">
          <a id="logo-container" href="<?=Url::to(['site/index'])?>" class="brand-logo center">
              <img class="logoMain" src="<?=Url::to('@web/images/logo_blanco.svg')?>">
          </a>
          <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          <?php
          echo Menu::widget([
              'options' => ['id' => "nav-mobile", 'class' => 'sidenav'],
              'linkTemplate' => '<a href="{url}"><b>{label}</b></a>',
              'items' => [
                  ['label' => "Restaurantes", 'url' => ['site/index'], 'template' => '<a href="{url}"><i class="material-icons indigo-text">home</i>{label}</a>', 'visible' => !Yii::$app->user->isGuest],
                  ['label' => 'Perfil', 'url' => ['site/perfil'], 'template' => '<a href="{url}"><i class="material-icons indigo-text">person</i>{label}</a>' ,'visible' => !Yii::$app->user->isGuest],
                  ['label' => 'Valoraciones', 'url' => ['site/valoraciones'], 'template' => '<a href="{url}"><i class="material-icons indigo-text">star_half</i>{label}</a>', 'visible' => !Yii::$app->user->isGuest],
                  ['template' => '<div class="divider"></div>', 'visible' => !Yii::$app->user->isGuest],
                  Yii::$app->user->isGuest ? (
                  ['label' => 'Iniciar sesión', 'url' => ['/site/login'], 'template' => '<a class="indigo-text text-lighten-1" href="{url}">{label}</a>',]
                  ) : (
                  ['label' => 'Cerrar sesión', 'template' => '<a href="{url}"><i class="material-icons indigo-text">power_settings_new</i>{label}</a>', 'url' => ['site/logout']]
                  )
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