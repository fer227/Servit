<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title= 'Gestiona a tus empleados';
?>
<div class="container col s12">
    <div class="row">
        <div class="col s12">
            <h4>Gestiona a tus empleados</h4>
            <blockquote>
                El "usuario" de cada empleado se corresponde con el DNI sin letra.
                <br>
                Tanto el usuario como la contraseña, no se pueden modificar.
            </blockquote>
            <div class="card">
                <div class="card-image">
                    <a class="btn-large btn-floating halfway-fab waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to('@web/')?>site/form-empleado" data-position="right" data-tooltip="Crear nuevo empleado">
                        <i class="material-icons">person_add</i>
                    </a>
                </div>
                <div class="card-content">
                    <?php if ( empty($empleados)): ?>
                        <div>
                            <p class="blockquoteError">
                                Aún no has creado ningún empleado.<br>
                                Añade un nuevo empleado pulsando sobre el botón situado a la derecha.
                            </p>
                        </div>
                    <?php else: ?>
                    <table class="striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Primer apellido</th>
                                <th>DNI</th>
                                <th>Contraseña</th>
                                <th>Rol</th>
                                <th class="center-align">Secciones/mesas asignadas</th>
                                <th class="center-align">Visible</th>
                                <th class="center-align">Opción</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php foreach($empleados as $key=>$value): ?>
                            <tr>
                                <td><?php echo $value->getAttribute('nombre'); ?></td>
                                <td><?php echo $value->getAttribute('apellido1'); ?></td>
                                <td><?php echo $value->getAttribute('dni'); ?></td>
                                <td><?php echo $passwords[$value->usuario] ?></td>
                                <td><?php echo $value->getAttribute('rol'); ?></td>
                                <td class="center-align"><?php echo $secciones_asignadas[$value->usuario] ?></td>
                                <td class="center-align">
                                    <?php if($value->visible == 1): ?>
                                        <?php $form = ActiveForm::begin([

                                            'action' => \yii\helpers\Url::to(['site/invisibilizar-empleado', 'usuario' => $value->getAttribute('usuario')]),
                                            'method' => 'get',


                                        ]); ?>
                                        <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para ocultar", 'data-position'=>"right"]) ?>
                                        <?php ActiveForm::end(); ?>
                                    <?php else: ?>
                                        <?php $form = ActiveForm::begin([

                                            'action' => \yii\helpers\Url::to(['site/visibilizar-empleado', 'usuario' => $value->getAttribute('usuario')]),
                                            'method' => 'get',


                                        ]); ?>
                                        <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small' , 'data-tooltip'=>"Pulsa para mostrar", 'data-position'=>"right"]) ?>
                                        <?php ActiveForm::end(); ?>
                                    <?php endif; ?>
                                </td>
                                <td class="center-align">
                                    <?php $form = ActiveForm::begin([

                                        'action' => \yii\helpers\Url::to(['site/editar-empleado',
                                        'empleado' => $value->getAttribute('usuario')]),
                                        'method' => 'get',
                                        'options' => [
                                            'class' => 'botoninline'
                                        ]

                                    ]); ?>
                                    <?= Html::submitButton('<i class="material-icons">edit</i>', ['class' => 'btn-floating waves-effect waves-light indigo lighten-1 btn-small']) ?>
                                    <?php ActiveForm::end(); ?>

                                    <?php $form = ActiveForm::begin([

                                        'action' => \yii\helpers\Url::to(['site/eliminar-empleado',
                                        'empleado' => $value->getAttribute('usuario')]),
                                        'method' => 'get',
                                        'options' => [
                                            'class' => 'botoninline'
                                        ]

                                    ]); ?>
                                    <?= Html::submitButton('<i class="material-icons">delete</i>', ['class' => 'btn-floating waves-effect red btn-small']) ?>
                                    <?php ActiveForm::end(); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
