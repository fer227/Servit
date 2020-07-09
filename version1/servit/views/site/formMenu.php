<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Añade un nuevo menú';
?>
<div class="site-formMenu">
    <h2><?= Html::encode($this->title) ?></h2>
    <?php $form = ActiveForm::begin(); ?>
    <p>Ponle nombre al menú y sus diferentes componentes</p>
    <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'componente1', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'componente2', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'componente3', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'componente4', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Continuar', ['class' => 'btn red darken-4 btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-formMenu -->