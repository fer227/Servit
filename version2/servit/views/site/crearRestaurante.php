<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurante */
/* @var $form ActiveForm */
$this->title= 'Crear restaurante';
?>
<div class="crearRestaurante">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <?= $form->field($model, 'direccion', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <?= $form->field($model, 'telefono', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <?= $form->field($model, 'horario', ['inputOptions' => ['class' => 'materialize-textarea'], 'template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textarea(['rows' => '6']) ?>
        <?= $form->field($model, 'provincia', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <?= $form->field($model, 'localidad', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <p>Selecciona las categorías que desee</p>
        <?= $form->field($model, 'etiquetas')->checkboxList($etiquetas, ['item' =>function ($index, $label, $name, $checked, $value) {

return "<div class='row'><label><input name={$name} type='checkbox' value={$value}><span>{$label}</span></label></div>";

}]) ?>
    <div class="row"></div>
        <?= $form->field($model, 'imagen')->fileInput() ?>
    <div class="row"></div>
        <div class="form-group">
            <?= Html::submitButton('Crear', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div><!-- crearRestaurante -->
