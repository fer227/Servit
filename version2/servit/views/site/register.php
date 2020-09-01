<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Propietario */
/* @var $form ActiveForm */

$this->title= 'Comienza a disfrutar de las ventajas de Servit';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    
    <?php $form = ActiveForm::begin([]); ?>
        <p>Primero rellena tus datos para poder ponernos en contacto contigo lo antes posible.</p>
        <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <?= $form->field($model, 'apellidos', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <?= $form->field($model, 'correo', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <?= $form->field($model, 'telefono', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput() ?>
        <p>Coméntanos un poco tu situación. Puedes preguntar cualquier duda que tengas sin compromiso.</p>
        <?= $form->field($model, 'mensaje', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textarea(['class' => 'materialize-textarea', 'rows' => 3])?>
        <blockquote>
            Pulsa la tecla "intro" para añadir nuevas líneas en el mensaje.
        </blockquote>
    <div class="form-group">
            <?= Html::submitButton('Enviar<i class="material-icons right">send</i>', ['class' => 'btn-large right indigo lighten-1']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<div class="row"></div>
</div><!-- site-register -->
