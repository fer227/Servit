<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title= 'Crear una nueva zona';
?>
<div class="container">
    <div class="row">
        <div class="col s8">
            <h4><?= Html::encode($this->title) ?></h4>
            <div class="row"></div>
            <?php $form = ActiveForm::begin(); ?>
            <blockquote>
                Puedes crear una nueva zona (un comedor, una terraza..) o también tienes la opción de crear una barra.
                Selecciona aquí abajo la opción que necesites.
            </blockquote>
            <?= $form->field($model, 'es_barra')->dropDownList($opciones, ['prompt' => 'Elige una opción'])->label(false) ?>
            <div class="row"></div>
            <blockquote>
                Ahora puedes ponerle un nombre.
                En caso de que hayas seleccionado "Barra" puedes nombrarlo por ejemplo "Barra" o en caso de que tengas varias puedes añadirle un número "Barra 1".
                En caso de que hayas seleccionado "Zona" simplemente ponle el nombre de la misma (por ejemplo Terraza, Salón principal, Comedor..)
            </blockquote>
            <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
            <div class="row"></div>
            <blockquote>
                Finalmente hay que establecer el número de secciones.<br>
                Si has seleccionado "Barra", las secciones se corresponden con las divisiones que tiene la barra donde se pueden poner los clientes.<br>
                Si has seleccionado "Zona", las secciones se corresponden con las mesas que tiene tu nueva zona.
                <br>A la derecha tienes una imagen explicativa.
            </blockquote>
            <?= $form->field($model, 'num_secciones', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>


            <div class="form-group">
                <?= Html::submitButton('Crear<i class="material-icons right">add</i>', ['class' => 'btn-large right btn-primary indigo lighten-1']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col s1"></div>
        <div class="col s3 imgHelpFormZona">
            <div class="row center-align">
                <div>
                    <h5>Barra</h5>
                    <img class="imgBarra" src="<?=Url::to('@web/images/barra.jpg')?>">
                </div>
            </div>
            <div class="row center-align">
                <div>
                    <h5>Zona estándar</h5>
                    <img class="imgMesas" src="<?=Url::to('@web/images/salon.jpg')?>">
                </div>
            </div>
        </div>
    </div>
</div>