<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = "Inicio";
?>
<div class="container">
    <div class="center-align">
        <img class="logoindex" src="<?=Url::to('@web/images/slogan.svg')?>">
        <h5>Realiza tu pedido desde tu propio teléfono</h5>
        <div class="jumbotron">
            <div class="row center">
                <div class="row"></div>
                <div class="col s6">
                    <div class="row center">
                        <h5 class="header col s12 light">Busca restaurantes</h5>
                        <a href="<?=Url::to('@web/')?>site/restaurantes" class="btn-large pulse btn-floating waves-effect waves-light indigo"><i class="material-icons right">search</i></a>
                    </div>
                </div>
                <div class="col s6">
                    <div class="row center">
                        <h5 class="header col s12 light">¿Qué es Servit?</h5>
                        <a href="<?=Url::to('@web/')?>site/informacion" class="btn-large pulse btn-floating waves-effect waves-light indigo"><i class="material-icons right">info_outline</i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
