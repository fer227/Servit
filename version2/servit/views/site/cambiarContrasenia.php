<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Propietario */
/* @var $form ActiveForm */

$this->title= 'Modifica tu contraseña';
?>
<div class="container">
<h3><?= Html::encode($this->title) ?></h3>

<?php $form = ActiveForm::begin([
]); ?>

<?= $form->field($model, 'old_password', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->passwordInput()->label('Introduce la antigua contraseña') ?>
<?= $form->field($model, 'new_password', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->passwordInput()->label('Introduce la nueva contraseña') ?>

<div class="form-group">
    <?= Html::submitButton('Actualizar', ['class' => 'btn indigo lighten-1']) ?>
</div>
<?php ActiveForm::end(); ?>

</div>