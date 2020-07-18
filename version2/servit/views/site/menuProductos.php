<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="col s12">
    <ul class="tabs center">
        <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/menu-categorias" target="_self">CATEGORÍAS</a></li>
        <li class="tab col s3"><a class="active" href="<?=Url::to('@web/')?>site/menu-productos" target="_self">PRODUCTOS</a></li>
        <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/menu-menus" target="_self">MENÚS</a></li>
    </ul>
</div>

<div class="row"></div>

<div class="col s12 container">
    <div class="row">
        <div class="col s2">
            <?php if ( empty($categorias)): ?>
                <div>
                    <p class="blockquoteError">
                        Aún no has creado ninguna categoría. Dirígete a "Categorías" y crea una.
                    </p>
                </div>
            <?php else: ?>
                <div class="row">
                    <h5>Categorías</h5>
                    <div class="collection">
                        <?php foreach($categorias as $key=>$value): ?>
                            <?php if ($categoriaSeleccionada == $value->id_categoria): ?>
                                <a href="<?=Url::to(['site/menu-productos', 'id_categoria' => $value->id_categoria])?>" class="collection-item active"><?= Html::encode($value->nombre) ?></a>
                            <?php else: ?>
                                <a href="<?=Url::to(['site/menu-productos', 'id_categoria' => $value->id_categoria])?>" class="collection-item"><?= Html::encode($value->nombre) ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>


                <div class="col s1"></div>
                <div class="col s9">
                        <h5>Edita la carta de tu restaurante- Productos</h5>
                        <div class="card">

                            <div class="card-image">
                                <?php if ( !empty($categorias)): ?>
                                    <a class="btn-large btn-floating halfway-fab waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to('@web/')?>site/form-producto" data-position="right" data-tooltip="Añadir producto">
                                        <i class="material-icons">add</i>
                                    </a>
                                <?php else: ?>
                                    <a class="btn-large btn-floating halfway-fab disabled waves-effect waves-light indigo lighten-1 tooltipped" href="<?=Url::to('@web/')?>site/form-producto" data-position="right" data-tooltip="Crea primero una categoría">
                                        <i class="material-icons">add</i>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="card-content">
                                <?php if ($categoriaSeleccionada != null): ?>
                                <?php if ( empty($productos)): ?>
                                    <div>
                                        <p class="blockquoteError">
                                            Aún no has creado ningún producto de esta categoría.<br>
                                            Añade un producto pulsando sobre el botón "+"
                                        </p>
                                    </div>
                                <?php else: ?>
                                <table class="striped">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th class="padIngredientes">Ingredientes</th>
                                        <th>Precio</th>
                                        <th>Visible</th>
                                        <th class="center-align">Opción</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach($productos as $key=>$value): ?>
                                            <tr>
                                                <td><?php echo $value->getAttribute('nombre'); ?></td>
                                                <td class="ingredientesDisposicion">
                                                        <?php foreach($ingredientes as $key2=>$value2): ?>
                                                            <?php if ($value2->id_producto == $value->id_producto): ?>
                                                                <div class="chip">
                                                                    <?php echo $value2->getAttribute('nombre'); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                </td>
                                                <td class="padIngredientes"><?php echo $value->getAttribute('precio'); ?></td>
                                                <td class="padIngredientes">
                                                    <?php if($value->visible == 1): ?>
                                                        <?php $form = ActiveForm::begin([

                                                            'action' => \yii\helpers\Url::to(['site/invisibilizar-producto', 'id_producto' => $value->getAttribute('id_producto')]),
                                                            'method' => 'get',


                                                        ]); ?>
                                                        <?= Html::submitButton('<i class="material-icons">remove_red_eye</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small', 'data-tooltip'=>"Pulsa para ocultar", 'data-position'=>"right"]) ?>
                                                        <?php ActiveForm::end(); ?>
                                                    <?php else: ?>
                                                        <?php $form = ActiveForm::begin([

                                                            'action' => \yii\helpers\Url::to(['site/visibilizar-producto', 'id_producto' => $value->getAttribute('id_producto')]),
                                                            'method' => 'get',


                                                        ]); ?>
                                                        <?= Html::submitButton('<i class="material-icons">visibility_off</i>', ['class' => 'btn-floating waves-effect tooltipped waves-light indigo lighten-1 btn-small' , 'data-tooltip'=>"Pulsa para mostrar", 'data-position'=>"right"]) ?>
                                                        <?php ActiveForm::end(); ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="center-align">
                                                    <?php $form = ActiveForm::begin([

                                                        'action' => \yii\helpers\Url::to(['site/editar-producto', 'id_producto' => $value->getAttribute('id_producto')]),
                                                        'method' => 'get',
                                                        'options' => [
                                                            'class' => 'botoninline'
                                                        ]

                                                    ]); ?>
                                                    <?= Html::submitButton('<i class="material-icons right">edit</i>', ['class' => 'z-depth-0 btn-floating waves-effect waves-light indigo lighten-1 btn-small']) ?>
                                                    <?php ActiveForm::end(); ?>
                                                    <?php $form = ActiveForm::begin([

                                                        'action' => \yii\helpers\Url::to(['site/eliminar-producto', 'id_producto' => $value->getAttribute('id_producto')]),
                                                        'method' => 'get',
                                                        'options' => [
                                                            'class' => 'botoninline'
                                                        ]

                                                    ]); ?>
                                                    <?= Html::submitButton('<i class="material-icons right">delete</i>', ['class' => ' z-depth-0 btn-floating waves-effect red btn-small']) ?>
                                                    <?php ActiveForm::end(); ?>
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
                        Selecciona alguna categoría para ver sus productos. <br>
                        Tienes las categorías en la parte izquierda.
                    </blockquote>
            <?php endif; ?>
    </div>
</div>
