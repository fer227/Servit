<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Alta de un nuevo propietario';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row"></div>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'usernames')->label(false)->hiddenInput(['value' => $usernames, 'id' => 'usernames'])?>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'apellidos', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'nombre_restaurante', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'correo', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['id' => 'email']) ?>
    <p class="blockquoteError ocultar" id="alerta_correo">
        La dirección de correo electrónica introducida no es correcta.
    </p>
    <?= $form->field($model, 'username', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['id' => 'username_intro']) ?>
    <p class="blockquoteError ocultar" id="alerta_user">
        El username introducido no está disponible.
    </p>
    <blockquote>
        Tienes que asignarle una contraseña provisional.
        <br>
        El usuario podrá cambiarla más tarde en su perfil.
    </blockquote>
    <?= $form->field($model, 'password', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <blockquote>
        Una vez lo hayas creado, al nuevo cliente le llegará un correo electrónico a la dirección que has indicado con el usuario y contraseña
        que hayas asignado.
    </blockquote>
    <div class="row"></div>
    <div class="form-group">
        <?= Html::submitButton('Crear<i class="material-icons right">add</i>', ['class' => 'btn-large right indigo lighten-1 btn-primary', 'id' => 'enviar']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row"></div>
</div>

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/controlEmailUser.js')?>"></script>