<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form ActiveForm */
$this->title= 'Editar información';
?>
<div class="container">
    <h4><?= Html::encode($this->title) ?></h4>
    <div class="row">
        <div class="col s7">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nombre', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $empleado->nombre]) ?>
            <?= $form->field($model, 'apellido1', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $empleado->apellido1]) ?>
            <?= $form->field($model, 'apellido2', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $empleado->apellido2]) ?>
            <?= $form->field($model, 'dni', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['value' => $empleado->dni]) ?>
            <?php if ($editable): ?>
                <?= $form->field($model, 'rol')->dropDownList($roles, ['prompt' => 'Elige un rol']) ?>
            <?php else: ?>
                <blockquote>
                    No puedes editar su rol si es camarero y tiene mesas asignadas.
                </blockquote>
                <?= $form->field($model, 'rol')->dropDownList($roles, ['prompt' => 'Elige un rol', 'disabled' => true]) ?>
            <?php endif; ?>
            <?= $form->field($model, 'old_dni')->label(false)->hiddenInput(['value' => $empleado->dni])?>

            <blockquote>
                Recuerda que el usuario y la contraseña se generan automáticamente.
            </blockquote>
            <div class="row"></div>
            <?= $form->field($model, 'user', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['disabled' => true, 'value' => substr($empleado->dni, 0, -1)]) ?>
            <?= $form->field($model, 'password', ['template' => '<div class="input-field">{label}{input}{hint}{error}</div>'])->textInput(['disabled' => true,'value' => substr($empleado->apellido1, 0, 3) . $empleado->apellido2 . $empleado->id_restaurante]) ?>

            <div class="form-group">
                <?= Html::submitButton('Guardar<i class="material-icons right">save</i>', ['class' => 'btn-large right btn-primary indigo lighten-1']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="row"></div>
        </div>
        <div class="col s1">

        </div>
        <div class="col s4">
            <h6 class="center-align">Resumen de mesas y secciones de barras asignadas a este empleado</h6>
            <ul class="collapsible">
                <?php foreach($zonas as $value): ?>
                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons indigo-text text-lighten-1">keyboard_arrow_right</i>
                            <?php echo $value->nombre; ?>
                            <span class="new badge indigo lighten-1" data-badge-caption="asig."><?php echo $badges[$value->id] ?></span>
                        </div>
                        <div class="collapsible-body center-align">
                            <ul class="collection">
                                <?php foreach($secciones as $value2): ?>
                                    <?php if ( $value2['id_zona'] == $value->id): ?>
                                        <?php if ( $value->es_barra): ?>
                                            <li class="collection-item">Sección <?php echo $value2['numero'] ?></li>
                                        <?php else: ?>
                                            <li class="collection-item">Mesa <?php echo $value2['numero'] ?></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <blockquote>
                Pulsa sobre una sección para ver más detalles.
            </blockquote>
        </div>
    </div>
</div><!-- site-formEmpleado -->