<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container center-align">
    <h4 class="indigo-text text-darken-4"><?php echo $mensaje; ?></h4>
    <div class="row"></div>
    <h5>Mientras te traen la cuenta, ¿Por qué no completas nuestra encuesta de satisfacción?</h5>
    <h5>¡Ayúdanos a mejorar!</h5>
    <div class="row"></div>
    <div class="row">
        <a href="<?=Url::to(['/site/valoracion'])?>" class="btn-large btn-large waves-effect indigo">
            <i class="large right material-icons">poll</i>Ir a la valoración
        </a>
    </div>
    <div class="row">
        <a href="<?=Url::to(['/site/index'])?>" class="btn-large btn-large waves-effect indigo">
            <i class="large right material-icons">watch_later</i>Más tarde
        </a>
    </div>
</div>
