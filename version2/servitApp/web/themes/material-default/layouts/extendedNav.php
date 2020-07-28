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

    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- CSS  -->
    <link href="<?php echo $this->theme->baseUrl ?>/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="<?php echo $this->theme->baseUrl ?>/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<body>
<?php $this->beginBody() ?>
<nav class="red lighten-1 nav-extended" role="navigation">
    <div class="container">
        <div class="nav-wrapper">
            <a id="logo-container" href="<?=Url::to(['site/menu'])?>" class="brand-logo center">
                <img class="logoMain" src="<?=Url::to('@web/images/logo_blanco.svg')?>">
            </a>
        </div>
    </div>
    <div class="nav-content">
        <ul class="tabs tabs-transparent tabs-fixed-width">
            <li class="tab"><a id="tab_carta" class="active" href="#test1">La carta</a></li>
            <li class="tab"><a id="tab_pedido" href="#test2">Mi pedido</a></li>
            <li class="tab"><a id="tab_cuenta" href="#test3">Cuenta</a></li>
        </ul>
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
