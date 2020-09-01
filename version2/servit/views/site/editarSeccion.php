<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Editar mesa o sección de barra';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <?php $form = ActiveForm::begin([
    ]); ?>
    <div class="row"></div>
    <?= $form->field($model, 'numero')->label(false)->hiddenInput(['value' => $seccion->numero])?>
    <?= $form->field($model, 'id_zona')->label(false)->hiddenInput(['value' => $seccion->id_zona])?>
    <?= $form->field($model, 'plazas', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $seccion->plazas]) ?>
    <blockquote>
        Tienes que asignarle una empleado que será el encargado de atenderla.
    </blockquote>
    <?= $form->field($model, 'usuario_empleado')->dropDownList($empleados) ?>
    <blockquote>
        Solo puedes cambiar el estado de la mesa (o sección de la barra) a "Reservado" o "Libre".
        <br> Su estado será "Ocupado" cuando el cliente se vincule con la mesa a través de la aplicación.
    </blockquote>
    <?= $form->field($model, 'estado')->dropDownList($opciones, ['prompt' => 'Selecciona estado']) ?>
    <div class="row"></div>
    <blockquote>
        El código de la mesa es automático y no se puede editar.
        <br>En próximas actualizaciones incorporaremos los códigos QR.
    </blockquote>
    <label>Código de la mesa</label>
    <div class="input-field col s12">
        <input disabled value=<?php echo $codigo ?> id="disabled" type="text" class="validate">
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar<i class="material-icons right">save</i>', ['class' => 'btn-large btn-primary right indigo lighten-1']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row"></div>
</div>