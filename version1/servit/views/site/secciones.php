<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="col s12">
    <ul class="tabs center">
        <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/zonas" target="_self">ZONAS RESTAURANTE</a></li>
        <li class="tab col s3"><a class="active" href="<?=Url::to('@web/')?>site/secciones" target="_self">MESAS Y SECCIONES DE BARRAS</a></li>
    </ul>
</div>

<div class="row"></div>

<div class="col s12 container">
    <div class="row">
        <div class="col s2">
            <?php if ( empty($zonas)): ?>
                <div>
                    <p class="blockquoteError">
                        Aún no has creado ninguna zona. Dirígete a "ZONAS RESTAURANTE" y crea una.
                    </p>
                </div>
            <?php else: ?>
                <div class="row">
                    <h5>Zonas</h5>
                    <div class="collection">
                        <?php foreach($zonas as $key=>$value): ?>
                            <?php if ($zonaSeleccionada == $value->id): ?>
                                <a href="<?=Url::to(['site/secciones', 'id_zona' => $value->id])?>" class="collection-item active"><?= Html::encode($value->nombre) ?></a>
                            <?php else: ?>
                                <a href="<?=Url::to(['site/secciones', 'id_zona' => $value->id])?>" class="collection-item"><?= Html::encode($value->nombre) ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <blockquote>
                Si la sección está ocupada, no podrás editarla.
            </blockquote>
            <blockquote>
                Si quieres aumentar o disminuir el número de secciones, dirígete al botón de la esquina superior derecha.
            </blockquote>
        </div>


                <div class="col s1"></div>
                <div class="col s9">
                        <?php if ($zonas_sin_asignar != ''): ?>
                            <p class="blockquoteError">Tienes secciones sin asignar en las siguientes zonas: <?php echo $zonas_sin_asignar ?> </p>
                        <?php endif; ?>
                        <h5>Gestiona las mesas y secciones de las barras</h5>
                        <div class="card">

                            <?php if ($zonaSeleccionada != null): ?>
                                <div class="card-image">
                                    <a class="btn-large btn-floating halfway-fab waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to(['site/editar-zona', 'id_zona' => $zonaSeleccionada])?>" data-position="right" data-tooltip="Modificar el numero de secciones/mesas">
                                        <i class="material-icons">tune</i>
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="card-image">
                                    <a class="btn-large btn-floating disabled halfway-fab waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to(['site/editar-zona', 'id_zona' => $zonaSeleccionada])?>" data-position="right" data-tooltip="Modificar el numero de secciones/mesas">
                                        <i class="material-icons">tune</i>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="card-content">
                                <?php if ($zonaSeleccionada != null): ?>
                                <?php if ( empty($secciones)): ?>
                                    <div>
                                        <p class="blockquoteError">
                                            Esta zona no tiene secciones.<br>
                                            Dirígete a "ZONAS RESTAURANTE" y añádele secciones editando la zona concreta.
                                        </p>
                                    </div>
                                <?php else: ?>
                                <table class="striped">
                                    <thead>
                                    <tr>
                                        <th class="center-align">Número</th>
                                        <th class="center-align">Estado</th>
                                        <th class="center-align">Código</th>
                                        <th class="center-align">Camarero asignado</th>
                                        <th class="center-align">Visible</th>
                                        <th class="center-align">Editar</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($secciones as $key=>$value): ?>
                                            <tr>
                                                <td class="center-align"><?php echo $value->getAttribute('numero'); ?></td>
                                                <td class="center-align">
                                                    <?php if ($value->estado == 0): ?>
                                                        Libre
                                                    <?php elseif($value->estado == 1): ?>
                                                        Asociándose
                                                    <?php elseif($value->estado == 2): ?>
                                                        Ocupada
                                                    <?php elseif($value->estado == 3): ?>
                                                        Reservada
                                                    <?php endif; ?>
                                                </td>
                                                <td class="center-align">
                                                    <?php echo $codigos[$value->numero] ?>
                                                </td>
                                                <td class="center-align">
                                                    <?php if ($asignaciones[$value->numero] == 'Sin asignar'): ?>
                                                        <p class="red-text">Sin asignar</p>
                                                    <?php else: ?>
                                                        <?php echo $asignaciones[$value->numero] ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="center-align">
                                                    <?php if($value->estado == 0): ?>
                                                        <?php if($value->visible == 1): ?>
                                                            <?php $form = ActiveForm::begin([

                                                                'action' => \yii\helpers\Url::to(['site/invisibilizar-seccion', 'id_zona' => $value->getAttribute('id_zona'), 'numero' => $value->numero]),
                                                                'method' => 'get',


                                                            ]); ?>
                                                            <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para ocultar", 'data-position'=>"right"]) ?>
                                                            <?php ActiveForm::end(); ?>
                                                        <?php else: ?>
                                                            <?php $form = ActiveForm::begin([

                                                                'action' => \yii\helpers\Url::to(['site/visibilizar-seccion', 'id_zona' => $value->getAttribute('id_zona'), 'numero' => $value->numero]),
                                                                'method' => 'get',


                                                            ]); ?>
                                                            <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small' , 'data-tooltip'=>"Pulsa para mostrar", 'data-position'=>"right"]) ?>
                                                            <?php ActiveForm::end(); ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if($value->visible == 1): ?>
                                                            <?php $form = ActiveForm::begin([

                                                                'action' => \yii\helpers\Url::to(['site/invisibilizar-seccion', 'id_zona' => $value->getAttribute('id_zona'), 'numero' => $value->numero]),
                                                                'method' => 'get',


                                                            ]); ?>
                                                            <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating disabled waves-effect tooltipped waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para ocultar", 'data-position'=>"right"]) ?>
                                                            <?php ActiveForm::end(); ?>
                                                        <?php else: ?>
                                                            <?php $form = ActiveForm::begin([

                                                                'action' => \yii\helpers\Url::to(['site/visibilizar-seccion', 'id_zona' => $value->getAttribute('id_zona'), 'numero' => $value->numero]),
                                                                'method' => 'get',


                                                            ]); ?>
                                                            <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating disabled waves-effect tooltipped waves-light indigo lighten-1 btn-small' , 'data-tooltip'=>"Pulsa para mostrar", 'data-position'=>"right"]) ?>
                                                            <?php ActiveForm::end(); ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="center-align">
                                                    <?php if ($value->estado == 0 or $value->estado == 3): ?>
                                                        <?php $form = ActiveForm::begin([

                                                            'action' => \yii\helpers\Url::to(['site/editar-seccion', 'id_zona' => $zonaSeleccionada, 'numero' => $value->getAttribute('numero')]),
                                                            'method' => 'get',
                                                            'options' => [
                                                                'class' => 'botoninline'
                                                            ]

                                                        ]); ?>
                                                        <?= Html::submitButton('<i class="material-icons right">edit</i>', ['class' => 'z-depth-0 btn-floating waves-effect waves-light indigo lighten-1 btn-small']) ?>
                                                        <?php ActiveForm::end(); ?>
                                                    <?php else: ?>
                                                        <a class="btn-floating disabled btn-small"><i class="material-icons">edit</i></a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <?php endif; ?>
            <?php else: ?>
                    <blockquote>
                        Selecciona alguna zona o barra para ver sus mesas o secciones correspondientes. <br>
                        Tienes las zonas y barras en la parte izquierda.
                    </blockquote>
            <?php endif; ?>
    </div>
</div>
