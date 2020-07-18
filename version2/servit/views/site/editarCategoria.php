<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Editar categoría';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <p>Introduce el nombre de la nueva categoría</p>
    <?php $form = ActiveForm::begin([
    ]); ?>
    <div class="row"></div>
    <?= $form->field($model, 'id_categoria')->label(false)->hiddenInput(['value' => $categoria->id_categoria])?>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $categoria->nombre]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar<i class="material-icons right">save</i>', ['class' => 'btn-large btn-primary right indigo lighten-1']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>