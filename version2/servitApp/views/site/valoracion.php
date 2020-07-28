<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>


<div class="container">
    <h4 class="center-align">Valoración</h4>
    <div class="row"></div>
    <?php $form = ActiveForm::begin([]); ?>

    <h6 class="center-align">¿Cómo ha sido tu experiencia? <small>(1 mala, 5 excelente)</small></h6>
    <p class="range-field padding-range">
        <?= $form->field($model, 'experiencia', ['template' => '<div class="input-field">{input}{hint}{error}</div>'])->textInput(['type' => 'range',  'min' => 1, 'max' => 5]) ?>
    </p>

    <h6 class="center-align">¿Cómo ha sido el ambiente del restaurante?</h6>
    <p class="range-field padding-range">
        <?= $form->field($model, 'ambiente', ['template' => '<div class="input-field">{input}{hint}{error}</div>'])->textInput(['type' => 'range',  'min' => 1, 'max' => 5]) ?>
    </p>
    <div class="row"></div>
    <h6 class="center-align">¿Repetirías?</h6>
    <div class="center-align">
        <?= $form->field($model, 'repetirias')->label(false)->radioList($opciones, ['item' =>function ($index, $label, $name, $checked, $value) {
            if($checked){
                return "<div class='row center-align tercio'><label><input class='with-gap' type='radio' name='{$name}' value='{$value}' checked><span>{$label}</span></label></div>";
            }
            else{
                return "<div class='row center-align tercio'><label><input class='with-gap' type='radio' name='{$name}' value='{$value}'><span>{$label}</span></label></div>";
            }
        }]) ?>
    </div>

    <div class="row"></div>
    <h6 class="center-align">¿Recomendarías?</h6>
    <div class="center-align">
        <?= $form->field($model, 'recomendarias')->label(false)->radioList($opciones, ['item' =>function ($index, $label, $name, $checked, $value) {
            if($checked){
                return "<div class='row center-align tercio'><label><input class='with-gap' type='radio' name='{$name}' value='{$value}' checked><span>{$label}</span></label></div>";
            }
            else{
                return "<div class='row center-align tercio'><label><input class='with-gap' type='radio' name='{$name}' value='{$value}'><span>{$label}</span></label></div>";
            }
        }]) ?>
    </div>


    <div class="row"></div>
    <div class="form-group center-align">
        <?= Html::submitButton('Enviar<i class="material-icons right">send</i>', ['class' => 'btn-large btn-primary indigo', 'id' => 'enviar']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div><!-- site-formProducto -->

