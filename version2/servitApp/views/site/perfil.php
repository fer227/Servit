<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title= 'Perfil';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row"></div>

    <?php $form = ActiveForm::begin([]); ?>
    <?= $form->field($model, 'usernames')->label(false)->hiddenInput(['value' => $usernames, 'id' => 'usernames'])?>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $perfil->nombre]) ?>
    <?= $form->field($model, 'apellidos', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $perfil->apellidos]) ?>
    <?= $form->field($model, 'provincia', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $perfil->provincia]) ?>
    <?= $form->field($model, 'anioNacimiento', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $perfil->anioNacimiento]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar<i class="material-icons right">save</i>', ['class' => 'btn-large right indigo lighten-1', 'id' => 'enviar']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>