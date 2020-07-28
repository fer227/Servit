<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Editar propietario';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row"></div>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'usernames')->label(false)->hiddenInput(['value' => $usernames, 'id' => 'usernames'])?>
    <?= $form->field($model, 'old_username')->label(false)->hiddenInput(['value' => $propietario->username])?>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $propietario->nombre]) ?>
    <?= $form->field($model, 'apellidos', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $propietario->apellidos]) ?>
    <?= $form->field($model, 'correo', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $propietario->correo, 'id' => 'email']) ?>
    <p class="blockquoteError ocultar" id="alerta_correo">
        La dirección de correo electrónica introducida no es correcta.
    </p>
    <?= $form->field($model, 'username', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $propietario->username, 'id' => 'username_intro']) ?>
    <p class="blockquoteError ocultar" id="alerta_user">
        El username introducido no está disponible.
    </p>
    <blockquote>
        Puedes asignarle una nueva contraseña o puedes dejar este campo vacío (el usuario continuará con su contraseña habitual).
        <br>
        Si decides ponerle una nueva, comunícasela al propietario.
    </blockquote>
    <?= $form->field($model, 'password', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <div class="row"></div>
    <div class="form-group">
        <?= Html::submitButton('Guardar<i class="material-icons right">save</i>', ['class' => 'btn-large right indigo lighten-1 btn-primary', 'id' => 'enviar']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/controlEmailUser.js')?>"></script>