<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title= 'Crear una categoría';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <?php $form = ActiveForm::begin(); ?>
    <p>Introduce el nombre de la nueva categoría</p>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Crear<i class="material-icons right">add</i>', ['class' => 'btn-large right btn-primary indigo lighten-1']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
