<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Edita la información del producto';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row"></div>
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'id' => 'my-form']
    ]); ?>

    <?= $form->field($model, 'id_producto')->label(false)->hiddenInput(['value' => $producto->id_producto])?>
    <?= $form->field($model, 'chips')->label(false)->hiddenInput(['value' => $ingredientes, 'id'=>'chip_input'])?>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $producto->nombre]) ?>
    <?= $form->field($model, 'precio', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $producto->precio]) ?>
    <?= $form->field($model, 'id_categoria')->dropDownList($categorias, ['prompt' => 'Elige una categoría']) ?>
    <div class="row"></div>
    <blockquote>Introduce los ingredientes más relevantes del producto. No hace falta que los pongas todos, es solo para que el cliente se haga una ida.
        <br>Escribe el ingrediente y pulsa la tecla "intro" para guardarlo y comenzar a escribir el siguiente.</blockquote>
    <div id="chips1" class="chips chips-initial"></div>
    <div class="row"></div>
    <label>Alérgenos</label>
    <div>
        <?= $form->field($model, 'alergias')->label(false)->checkboxList($alergias, ['item' =>function ($index, $label, $name, $checked, $value) {
            if($checked){
                $url = Url::to('@web/images/alergias/');
                return
                    "<div class='row center-align alergenosDisposicion'><img class='alergenosEditar' src=\"". $url . "{$label}.svg\"><label><input type='checkbox' name='{$name}' value='{$value}' checked><span></span></label></div>";

            }
            else{
                $url = Url::to('@web/images/alergias/');
                return
                    "<div class='row center-align alergenosDisposicion'><img class='alergenosEditar' src=\"". $url . "{$label}.svg\"><label><input type='checkbox' name='{$name}' value='{$value}'><span></span></label></div>";
            }
        }]) ?>
    </div>
    <div class="row"></div>
    <div class="form-group">
        <?= Html::submitButton('Guardar<i class="material-icons right">save</i>', ['class' => 'btn-large right btn-primary indigo lighten-1', 'id' => 'enviar']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row"></div>
</div><!-- site-formProducto -->

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/editarProducto.js')?>"></script>