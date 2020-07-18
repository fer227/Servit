<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title= 'Edita la zona';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row"></div>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'id_zona')->label(false)->hiddenInput(['value' => $zona->id])?>
    <?= $form->field($model, 'es_barra')->dropDownList($opciones, ['prompt' => 'Elige una opción'])->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $zona->nombre]) ?>
    <?php if ($zona->es_barra): ?>
        <blockquote>
            Puedes aumentar o reducir el número de divisiones de esta barra.
        </blockquote>
        <div class="row"></div>
    <?php else: ?>
        <blockquote>
            Puedes aumentar o reducir el número de mesas de esta zona.
        </blockquote>
    <div class="row"></div>
    <?php endif; ?>
    <?= $form->field($model, 'num_secciones', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $zona->num_secciones]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar<i class="material-icons right">add</i>', ['class' => 'btn-large right btn-primary indigo lighten-1']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>