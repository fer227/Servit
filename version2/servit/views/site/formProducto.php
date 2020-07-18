<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Añade un nuevo producto';
?>
<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'my-form']]); ?>
        <h4><?= Html::encode($this->title) ?></h4>

            <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <blockquote>
            Si quieres añadirle céntimos, la coma se indica con un punto "<b>.</b>"
        </blockquote>
            <?= $form->field($model, 'precio', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
            <?= $form->field($model, 'id_categoria')->dropDownList($categorias, ['prompt' => 'Elige una categoría']) ?>
            <div class="row"></div>
        <blockquote>Introduce los ingredientes más relevantes del producto. No hace falta que los pongas todos, es solo para que el cliente se haga una idea.
            <br>Escribe el ingrediente y pulsa la tecla "intro" para guardarlo y comenzar a escribir el siguiente.</blockquote>
        <label>Ingredientes</label>
        <div id="chips1" class="chips"></div>
    </div>
    <div class="row">
        <blockquote>
            Selecciona las alergías que puede contener este plato o producto.
        </blockquote>
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
    </div>
    <div class="row"></div>
    <div class="form-group">
        <?= Html::submitButton('Crear<i class="material-icons right">add</i>', ['class' => 'btn-large left indigo lighten-1 btn-primary', 'id' => 'enviar']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row"></div>
</div><!-- site-formProducto -->

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/formProducto.js')?>"></script>