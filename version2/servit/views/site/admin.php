<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="container col s12">
    <div class="row">
        <div class="col s12">
            <h4>Usuarios propietarios de restaurantes</h4>
            <blockquote>
                Aún no está disponible la función de eliminar
            </blockquote>
            <div class="card">
                <div class="card-image">
                    <a class="btn-large btn-floating halfway-fab waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to('@web/')?>site/form-propietario" data-position="right" data-tooltip="Añadir un propietario">
                        <i class="material-icons">person_add</i>
                    </a>
                </div>
                <div class="card-content">
                    <?php if ( empty($propietarios)): ?>
                        <div>
                            <p class="blockquoteError">
                                Aún no has insertado ningún usuario.<br>
                                Añade un nuevo propietario pulsando sobre el botón situado a la derecha.
                            </p>
                        </div>
                    <?php else: ?>
                        <table class="striped">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Username</th>
                                <th>Correo electrónico</th>
                                <th>Restaurante</th>
                                <th>Visible</th>
                                <th>Opción</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach($propietarios as $key=>$value): ?>
                                <?php if ( $value->username != 'administrador'): ?>
                                <tr>
                                    <td><?php echo $value->getAttribute('nombre'); ?></td>
                                    <td><?php echo $value->getAttribute('apellidos'); ?></td>
                                    <td><?php echo $value->getAttribute('username'); ?></td>
                                    <td><?php echo $value->correo; ?></td>
                                    <td><?php echo $restaurantes[$value->username]; ?></td>
                                    <td>
                                        <?php if($value->visible == 1): ?>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['site/invisibilizar-propietario', 'username' => $value->getAttribute('username')]),
                                                'method' => 'get',


                                            ]); ?>
                                            <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para restringir servicios", 'data-position'=>"right"]) ?>
                                            <?php ActiveForm::end(); ?>
                                        <?php else: ?>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['site/visibilizar-propietario', 'username' => $value->getAttribute('username')]),
                                                'method' => 'get',


                                            ]); ?>
                                            <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small' , 'data-tooltip'=>"Pulsa para dar servicios", 'data-position'=>"right"]) ?>
                                            <?php ActiveForm::end(); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $form = ActiveForm::begin([

                                            'action' => \yii\helpers\Url::to(['site/editar-propietario',
                                                'propietario' => $value->getAttribute('username')]),
                                            'method' => 'get',
                                            'options' => [
                                                'class' => 'botoninline'
                                            ]

                                        ]); ?>
                                        <?= Html::submitButton('<i class="material-icons">edit</i>', ['class' => 'btn-floating waves-effect waves-light indigo lighten-1 btn-small']) ?>
                                        <?php ActiveForm::end(); ?>

                                        <?php $form = ActiveForm::begin([

                                            'action' => \yii\helpers\Url::to(['site/eliminar-propietario',
                                                'propietario' => $value->getAttribute('username')]),
                                            'method' => 'get',
                                            'options' => [
                                                'class' => 'botoninline'
                                            ]

                                        ]); ?>
                                        <?= Html::submitButton('<i class="material-icons">delete</i>', ['class' => 'btn-floating disabled waves-effect red btn-small']) ?>
                                        <?php ActiveForm::end(); ?>
                                    </td>
                                </tr>
                            <?php endif;?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

