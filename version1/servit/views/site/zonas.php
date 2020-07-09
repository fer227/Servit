<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="col s12">
    <ul class="tabs center">
        <li class="tab col s3"><a class="active" href="<?=Url::to('@web/')?>site/zonas" target="_self">ZONAS RESTAURANTE</a></li>
        <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/secciones" target="_self">MESAS Y SECCIONES DE BARRAS</a></li>
    </ul>
</div>

<div class="row"></div>

<div class="col s12 container">
    <div class="row">
        <div class="col s2">
            <blockquote>
                Aquí podrás crear las diferentes zonas de tu restaurante y las barras.
            </blockquote>
            <blockquote>
                Si no puede editar o eliminar alguna zona es porque alguna mesa de esa zona está siendo utilizada.
            </blockquote>
        </div>
        <div class="col s1"></div>

        <div class="col s9">
            <h5>Gestiona las zonas de tu restaurante</h5>
            <div class="card">

                <div class="card-image">
                    <a class="btn-large btn-floating halfway-fab waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to('@web/')?>site/form-zona" data-position="right" data-tooltip="Crear una nueva zona">
                        <i class="material-icons">add</i>
                    </a>
                </div>

                <div class="card-content">
                    <?php if ( empty($zonas)): ?>
                        <div>
                            <p class="blockquoteError">
                                Aún no has creado ninguna zona.<br>
                                Dirígete al botón "+".
                            </p>
                        </div>
                    <?php else: ?>
                    <table class="striped">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Mesas/Divisiones</th>
                            <th>Visible</th>
                            <th class="center-align">Opción</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach($zonas as $key=>$value): ?>
                            <tr>
                                <td><?php echo $value->getAttribute('nombre'); ?></td>
                                <?php if ($value->es_barra): ?>
                                    <td>Barra</td>
                                <?php else: ?>
                                    <td>Zona</td>
                                <?php endif; ?>
                                <td class="paddingNumSec"><?php echo $value->num_secciones; ?></td>
                                <td>
                                    <?php if($editable[$value->id]): ?>
                                        <?php if($value->visible == 1): ?>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['site/invisibilizar-zona', 'id_zona' => $value->getAttribute('id')]),
                                                'method' => 'get',


                                            ]); ?>
                                            <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para ocultar", 'data-position'=>"right"]) ?>
                                            <?php ActiveForm::end(); ?>
                                        <?php else: ?>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['site/visibilizar-zona', 'id_zona' => $value->getAttribute('id')]),
                                                'method' => 'get',


                                            ]); ?>
                                            <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small' , 'data-tooltip'=>"Pulsa para mostrar", 'data-position'=>"right"]) ?>
                                            <?php ActiveForm::end(); ?>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php if($value->visible == 1): ?>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['site/invisibilizar-zona', 'id_zona' => $value->getAttribute('id')]),
                                                'method' => 'get',


                                            ]); ?>
                                            <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating disabled waves-effect tooltipped waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para ocultar", 'data-position'=>"right"]) ?>
                                            <?php ActiveForm::end(); ?>
                                        <?php else: ?>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['site/visibilizar-zona', 'id_zona' => $value->getAttribute('id')]),
                                                'method' => 'get',


                                            ]); ?>
                                            <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating disabled waves-effect tooltipped waves-light indigo lighten-1 btn-small' , 'data-tooltip'=>"Pulsa para mostrar", 'data-position'=>"right"]) ?>
                                            <?php ActiveForm::end(); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td class="center-align">
                                    <?php if($editable[$value->id]): ?>
                                        <?php $form = ActiveForm::begin([

                                            'action' => Url::to(['site/editar-zona', 'id_zona' => $value->getAttribute('id')]),
                                            'method' => 'get',
                                            'options' => [
                                                'class' => 'botoninline'
                                            ]

                                        ]); ?>
                                        <?= Html::submitButton('<i class="material-icons right">edit</i>', ['class' => 'btn-floating waves-effect waves-light indigo lighten-1 btn-small']) ?>
                                        <?php ActiveForm::end(); ?>
                                        <?php $form = ActiveForm::begin([

                                            'action' => Url::to(['site/eliminar-zona', 'id_zona' => $value->getAttribute('id')]),
                                            'method' => 'get',
                                            'options' => [
                                                'class' => 'botoninline'
                                            ]

                                        ]); ?>
                                        <?= Html::submitButton('<i class="material-icons right">delete</i>', ['class' => 'btn-floating waves-effect red btn-small']) ?>
                                        <?php ActiveForm::end(); ?>
                                    <?php else: ?>
                                        <a class="btn-floating disabled btn-small"><i class="material-icons">edit</i></a>
                                        <a class="btn-floating disabled btn-small"><i class="material-icons">delete</i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

