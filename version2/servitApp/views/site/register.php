<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Propietario */
/* @var $form ActiveForm */

$this->title= 'Registro';
?>
<div class="container">
    <h3 class="center-align"><?= Html::encode($this->title) ?></h3>
    
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'usernames')->label(false)->hiddenInput(['value' => $usernames, 'id' => 'usernames'])?>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'apellidos', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'username', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['id' => 'username_intro']) ?>
    <p class="blockquoteError ocultar" id="alerta_user">
        El username introducido no está disponible.
    </p>
    <?= $form->field($model, 'password', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->passwordInput()?>
    <?= $form->field($model, 'provincia', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput()?>
    <?= $form->field($model, 'anioNacimiento', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput()?>

    <div class="form-group">
            <?= Html::submitButton('Registrarse', ['class' => 'btn indigo lighten-1', 'id' => 'enviar']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <div class="row"></div>

</div><!-- site-register -->

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/controlUsername.js')?>"></script>