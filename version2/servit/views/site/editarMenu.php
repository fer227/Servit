<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Edita la configuración del menú';
?>
<div class="editarMenu">
    <h2><?= Html::encode($this->title) ?></h2>
    <?php $form = ActiveForm::begin([
    ]); ?>

    <?= $form->field($model, 'old_name')->label(false)->hiddenInput(['value' => $menu->nombre])?>
    <?= $form->field($model, 'new_name', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $producto->nombre]) ?>
    <?= $form->field($model, 'categoria1')->dropDownList($categorias, ['prompt' => 'Elige una categoría']) ?>
    <div class="row"></div>
    <?= $form->field($model, 'categoria2')->dropDownList($categorias, ['prompt' => 'Elige una categoría']) ?>
    <div class="row"></div>
    <?= $form->field($model, 'categoria3')->dropDownList($categorias, ['prompt' => 'Elige una categoría']) ?>
    <div class="row"></div>
    <?= $form->field($model, 'categoria4')->dropDownList($categorias, ['prompt' => 'Elige una categoría']) ?>
    <div class="row"></div>

    <div class="form-group">
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary red darken-4']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-formMenu -->