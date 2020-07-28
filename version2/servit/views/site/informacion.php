<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = "Información";
?>

<div class="container">
    <div class="row center col 12">
        <img class="logoindex2" src="<?=Url::to('@web/images/isotipo.svg')?>">
        <h4>¿Qué es Servit?</h4>
        <h6>
            Servit es un sistema software diseñado para mejorar la organización y el rendimiento de tu negocio.<br><br> Está compuesto por dos elementos:
        </h6>
    </div>

    <div class="row center col 12">
        <div class="col s6">
            <h2>
                <i class="large material-icons indigo-text">language</i>
            </h2>
            <h4>Nuestra web</h4>
            <h6>Desde donde podrás gestionar tu restaurante al completo</h6>
        </div>

        <div class="col s6">
            <h2>
                <i class="large material-icons indigo-text">phone_android</i>
            </h2>
            <h4>Aplicación móvil</h4>
            <h6>Desde donde los clientes harán sus pedidos y tus camareros organizar su trabajo</h6>
        </div>
    </div>

    <div class="row"></div>
    <div class="row"></div>

    <div class="divider"></div>

    <div class="row"></div>
    <div class="row"></div>

    <h3 class="center">¿Cómo mejoramos tu restaurante?</h3>
    <h6 class="center">Nuestro software cuenta con diferentes módulos que harán que tu restaurante marque la diferencia</h6>

    <div class="row center-align">
        <div class="col s6">
            <h2>
                <i class="large material-icons red-text text-lighten-1">cloud_done</i>
            <h4>Virtualízate</h4>
            <h6>Incorpora la tecnología a tu restaurante. Disfruta de tener una carta virtual. Ofrece a tus clientes una nueva experiencia.</h6>
        </div>
        <div class="col s6">
            <h2>
                <i class="large material-icons red-text text-lighten-1">people</i>
            </h2>
            <h4>Empleados</h4>
            <h6>Reparte el trabajo entre tus empleados. Con nuestra App, tus trabajadores serán más eficientes y se sentirán más cómodos.</h6>
        </div>
    </div>
    <div class="row center-align">
        <div class="col s6">
            <h2>
                <i class="large material-icons red-text text-lighten-1">settings</i>
            </h2>
            <h4>Personaliza</h4>
            <h6>Desde tener tu carta con los productos y menús que quieras, hasta dividir tu restaurante en zonas y mesas. Representa tu restaurante en nuestro sistema tal y como es.</h6>
        </div>
        <div class="col s6">
            <h2>
                <i class="large material-icons red-text text-lighten-1">timeline</i>
            </h2>
            <h4>Informes</h4>
            <h6>Controla los ingresos que genera tu local. Nuestros novedosos informes sobre mesas te harán saber cuáles son las que mejor experiencia están dando a los clientes.</h6>
        </div>
    </div>

    <div class="row"></div>
    <div class="row"></div>

    <div class="divider"></div>

    <div class="row"></div>
    <div class="row"></div>

    <h3 class="center">¿A qué esperas?</h3>
    <h6 class="center">Contacta con nosotros e infórmate más a fondo, sin ningún compromiso. ¡Te esperamos!</h6>
    <div class="row"></div>
    <div class="center-align">
    <a href="<?=Url::to('@web/')?>site/register" class="btn-large waves-effect waves-light red lighten-1"><i class="material-icons right">contact_mail</i>Contacta</a>
    </div>
    <div class="row"></div>
    <div class="row"></div>

</div>
