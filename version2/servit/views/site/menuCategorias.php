<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title= 'Edita la carta de tu restaurante- Categorías';
?>
<div class="col s12">
    <ul class="tabs center">
        <li class="tab col s3"><a class="active" href="<?=Url::to('@web/')?>site/menu-categorias" target="_self">CATEGORÍAS</a></li>
        <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/menu-productos" target="_self">PRODUCTOS</a></li>
        <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/menu-menus" target="_self">MENÚS</a></li>
    </ul>
</div>

<div class="row"></div>

<div class="col s12 container">
    <div class="row">
    <div class="col s2">
        <blockquote>
            Recuerda que no podrás eliminar una categoría si tiene productos asociados.
        </blockquote>
    </div>
        <div class="col s1"></div>

    <div class="col s9">
        <h5>Edita la carta de tu restaurante- Categorías</h5>
        <div class="card">

            <div class="card-image">
                <a class="btn-large btn-floating halfway-fab waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to('@web/')?>site/form-categoria" data-position="right" data-tooltip="Añadir categoría">
                    <i class="material-icons">add</i>
                </a>
            </div>

            <div class="card-content">
                <?php if ( empty($categorias)): ?>
                    <div>
                        <p class="blockquoteError">
                            Aún no has creado ninguna categoría.<br>
                            Dirígete al botón "+".
                        </p>
                    </div>
                <?php else: ?>
            <table class="striped">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Visible</th>
                    <th class="center-align">Opción</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($categorias as $key=>$value): ?>
                    <tr>
                        <td><?php echo $value->getAttribute('nombre'); ?></td>
                        <td>
                            <?php if($value->visible == 1): ?>
                                <?php $form = ActiveForm::begin([

                                    'action' => \yii\helpers\Url::to(['site/invisibilizar-categoria', 'id_categoria' => $value->getAttribute('id_categoria')]),
                                    'method' => 'get',


                                ]); ?>
                                <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating tooltipped waves-effect waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para ocultar", 'data-position'=>"right"]) ?>
                                <?php ActiveForm::end(); ?>
                            <?php else: ?>
                                <?php $form = ActiveForm::begin([

                                    'action' => \yii\helpers\Url::to(['site/visibilizar-categoria', 'id_categoria' => $value->getAttribute('id_categoria')]),
                                    'method' => 'get',


                                ]); ?>
                                <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating tooltipped waves-effect waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para mostrar", 'data-position'=>"right"]) ?>
                                <?php ActiveForm::end(); ?>
                            <?php endif; ?>
                        </td>
                        <td class="center-align">
                            <?php $form = ActiveForm::begin([

                                'action' => \yii\helpers\Url::to(['site/editar-categoria', 'id_categoria' => $value->getAttribute('id_categoria')]),
                                'method' => 'get',
                                'options' => [
                                    'class' => 'botoninline'
                                ]

                            ]); ?>
                            <?= Html::submitButton('<i class="material-icons right">edit</i>', ['class' => 'btn-floating waves-effect waves-light indigo lighten-1 btn-small']) ?>
                            <?php ActiveForm::end(); ?>

                            <?php if($canDelete[$value->id_categoria]): ?>
                                <?php $form = ActiveForm::begin([

                                    'action' => \yii\helpers\Url::to(['site/eliminar-categoria', 'id_categoria' => $value->getAttribute('id_categoria')]),
                                    'method' => 'get',
                                    'options' => [
                                        'class' => 'botoninline'
                                    ]

                                ]); ?>
                                <?= Html::submitButton('<i class="material-icons right">delete</i>', ['class' => 'btn-floating waves-effect red btn-small']) ?>
                                <?php ActiveForm::end(); ?>
                            <?php else: ?>
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
