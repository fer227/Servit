<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title= 'Introduce el código de la mesa';
?>

<div class="container">
    <h5 class="indigo-text text-darken-1"><?= Html::encode($this->title) ?></h5>
    <?php $form = ActiveForm::begin([
    ]); ?>
    <?= $form->field($model, 'codigo', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput()->label(false) ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11 center-align">
            <?= Html::submitButton('Acceder', ['class' => 'btn btn-primary indigo']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php if($mensaje != 'null'): ?>
        <p class="blockquoteError"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <p class="center-align" style="margin-top: 50px">Nota: en futuras actualizaciones, esto se llevará a cabo mediante código QR</p>
</div>
