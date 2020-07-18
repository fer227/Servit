<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="container">
    <div class="row"></div>
    <div class="row">
        <div class="col s6">
            <h4 class="nombreRest"><?php echo Html::encode($restaurante->getAttribute('nombre')); ?></h4>
            <div class="row">
                <div class="padtags">
                <?php foreach($etiquetas as $key=>$value2): ?>
                    <div class="chip">
                        <?php echo Html::encode($value2->getAttribute('nombre')); ?>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <div class="contenidoCard">
                <?php if ($restaurante->telefono != 0): ?>
                    <p>-Teléfono de contacto: <?php echo Html::encode($restaurante->getAttribute('telefono')); ?></p>
                <?php else: ?>
                    <p>-Teléfono no disponible</p>
                <?php endif;?>
                <?php if ($restaurante->direccion != null): ?>
                    <p>-Dirección del restaurante: <?php echo Html::encode($restaurante->getAttribute('direccion')); ?></p>
                <?php else: ?>
                    <p>-Dirección no disponible</p>
                <?php endif;?>
                <div class="row"></div>
                <p>El horario se muestra en formato 24 horas:</p>
                <p>-Hora de apertura: <?php echo Html::encode($hora_apertura); ?></p>
                <p>-Hora de cierre: <?php echo Html::encode($hora_cierre); ?></p>
            </div>
        </div>
        <div class="col s4">
            <img class="imgRestConcreto" src="<?=Url::to('@web/')?><?php echo $restaurante->ruta; ?>">
            <div class="center-align padAcceder">
                <?php $form = ActiveForm::begin([

                    'action' => \yii\helpers\Url::to(['site/ver-carta', 'id' => $restaurante->getAttribute('id')]),
                    'method' => 'get',

                ]); ?>
                <?= Html::submitButton('Ver carta<i class="material-icons right">remove_red_eye</i>', ['class' => 'btn-large waves-effect waves-light indigo lighten-1']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>