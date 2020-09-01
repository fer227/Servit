<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurante */
/* @var $form ActiveForm */
$this->title= 'Editar información';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <blockquote>
        Si no rellenas todos los datos, los clientes no podrán informarse sobre tu restaurante.
    </blockquote>
    <div class="row"></div>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'my-form']]); ?>

        <?= $form->field($model, 'old_nombre')->label(false)->hiddenInput(['value' => $restaurante->nombre])?>
        <?= $form->field($model, 'new_nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $restaurante->nombre]) ?>
        <?= $form->field($model, 'telefono', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $restaurante->telefono]) ?>
        <blockquote>
            El horario se introduce en formato 24 horas.
        </blockquote>
        <?= $form->field($model, 'hora_apertura', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['class' => 'timepicker', 'value' => $restaurante->hora_apertura]) ?>
        <?= $form->field($model, 'hora_cierre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['class' => 'timepicker', 'value' => $restaurante->hora_cierre]) ?>
        <?= $form->field($model, 'provincia', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $restaurante->provincia]) ?>
        <?= $form->field($model, 'localidad', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $restaurante->localidad]) ?>
        <?= $form->field($model, 'direccion', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $restaurante->direccion]) ?>

    <blockquote>
        Puedes seleccionar varios tipos de comida, pero no recomendamos que pongas más de tres.
    </blockquote>
    <label>Tipo de comida</label>
    <div class="row"></div>
    <div class="etiquetas">
    <?= $form->field($model, 'etiquetas')->label(false)->checkboxList($etiquetas, ['item' =>function ($index, $label, $name, $checked, $value) {
        if($checked){
            return
                "<div class='row etiquetaConcreta'>
                    <label>
                        <input type='checkbox' name='{$name}' value='{$value}' checked>
                            <span>{$label}</span>
                    </label>
                </div>";
        }
        else{
            return "<div class='row etiquetaConcreta'><label><input type='checkbox' name='{$name}' value='{$value}'><span>{$label}</span></label></div>";
        }
    }]) ?>
    </div>

    <blockquote>
        Como imagen del restaurante puedes poner una foto de tu restaurante o el logo si tienes uno.
    </blockquote>

    <label>Logo o imagen del restaurante</label>
    <div class="row"></div>
    <img class="imgRestaurante" src="<?=Url::to('@web/')?><?php echo $restaurante->ruta; ?>">
    <div class="row"></div>
    <?= $form->field($model, 'imagen')->label(false)->fileInput() ?>
    <div class="row"></div>

    <div class="form-group">
            <?= Html::submitButton('Guardar<i class="material-icons right">save</i>', ['class' => 'btn-large indigo lighten-1 right', 'id' => 'enviar']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    <div class="row"></div>

</div><!-- editarInformacion -->

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/timer.js')?>"></script>

