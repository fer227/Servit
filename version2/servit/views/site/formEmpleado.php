<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Alta de un nuevo empleado';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <?php $form = ActiveForm::begin(); ?>
    <blockquote>El "usuario" y la contraseña del empleado se crearán automáticamente</blockquote>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'apellido1', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'apellido2', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'dni', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'rol')->dropDownList($roles, ['prompt' => 'Elige un rol']) ?>
    <div class="row"></div>
    <div class="form-group">
        <?= Html::submitButton('Crear<i class="material-icons right">add</i>', ['class' => 'btn-large right indigo lighten-1 btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-formEmpleado -->