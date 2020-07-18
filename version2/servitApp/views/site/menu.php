<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<input class="consejoPropina" value="<?php echo $pestania; ?>" id="dato_pestania"></input>
<script>
    var dato = document.getElementById("dato_pestania");
    if(dato.value == 2){
        var p1 = document.getElementById("tab_carta");
        var p2 = document.getElementById("tab_pedido");
        p1.classList.remove("active");
        p2.classList.add("active");
    }
    else if(dato.value == "3"){
        var p1 = document.getElementById("tab_carta");
        var p2 = document.getElementById("tab_cuenta");
        p1.classList.remove("active");
        p2.classList.add("active");
    }
</script>

<div id="test1" class="col s12">
    <?php if(!empty($categorias)): ?>
    <div class="container">
        <div class="row"></div>
        <?php foreach($categorias as $key=>$value): ?>
            <div class="container">
                <div class="card horizontal">
                    <div class="card-stacked">
                        <div class="card-content">
                            <div class="mitad">
                                <span class="card-title indigo-text text-darken-4"><?php echo $value->nombre; ?></span>
                            </div>
                            <div class="mitad">
                                <?php $form = ActiveForm::begin([

                                    'action' => \yii\helpers\Url::to(['site/menu', 'id_categoria' => $value->id_categoria]),
                                    'method' => 'get'

                                ]); ?>
                                <?= Html::submitButton('<i class="material-icons large">navigate_next</i>', ['class' => 'right white-text indigo btn btn-floating']) ?>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <?php foreach($productos as $key=>$value): ?>
            <div>
                <div class="card horizontal">
                    <div class="card-stacked">
                        <div class="card-content">
                            <div class="row center-align">
                                <div class="mitad">
                                    <span class="card-title indigo-text text-darken-4"><?php echo $value->nombre; ?></span>
                                    <div class="left-align paddin-8">
                                        <span class="card-title"><?php echo $value->precio . '€'; ?></span>
                                    </div>
                                </div>
                                <div class="mitad">
                                    <a class="right white-text btn-large indigo btn btn-floating modal-trigger" href='#<?php echo $value->id_producto; ?>'><i class="material-icons large">shopping_cart</i></a>
                                </div>
                            </div>

                            <div>
                                <?php foreach($ingredientes as $key=>$value2): ?>
                                    <?php if($value2->id_producto == $value->id_producto): ?>
                                        <div class="chip">
                                            <?php echo $value2->nombre; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php if(empty($categorias)): ?>
    <?php foreach($productos as $key=>$value): ?>
        <div id='<?php echo $value->id_producto; ?>' class="modal bottom-sheet">
            <div class="modal-content center-align">
                <h5><?php echo $value->nombre; ?>- <?php echo $value->precio; ?>€</h5>
                <?php foreach($alergias as $key=>$value2): ?>
                    <?php if($value2->id_producto == $value->id_producto): ?>
                        <img class="imgAlergia" src="/servit/web/images/alergias/<?php echo $value2->id_alergia; ?>.svg">
                    <?php endif; ?>
                <?php endforeach; ?>
                <div class="row"></div>
                <div class="row col s12">
                     <div class="col s4 right-align">
                     </div>
                    <div class="col s4">
                        <i onclick="restar('<?php echo $value->id_producto; ?>')" class="material-icons indigo-text operando">remove</i>
                        <h4 class="tercio2" id='cantidad_<?php echo $value->id_producto; ?>'>0</h4>
                        <i onclick="sumar('<?php echo $value->id_producto; ?>')" class="material-icons indigo-text operando">add</i>
                    </div>
                    <div class="col s4 left-align">
                    </div>
                </div>
                <div class="center-align">
                    <?php $form = ActiveForm::begin([

                        'action' => \yii\helpers\Url::to(['site/add-pedido']),
                        'method' => 'post'

                    ]); ?>
                    <?= $form->field($model, 'id')->label(false)->hiddenInput(['value' => $value->id_producto])?>
                    <?= $form->field($model, 'cantidad')->label(false)->hiddenInput(['value' => 0, 'id' => 'cantidad_form_' .  $value->id_producto])?>
                    <?= Html::submitButton('Añadir al pedido', ['class' => 'white-text indigo btn', 'id' => 'enviar_' . $value->id_producto, 'disabled' => true]) ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<div id="test2" class="col s12">
    <div class="container">
        <?php if(($tienePedidoActual) and !empty($incluye)): ?>
            <table>
                <tbody>
                    <?php foreach($productos_pedido as $value): ?>
                    <tr>
                        <td>
                            <h6><?php echo ($value->nombre . " (" . $value->precio ."€" . ")"); ?></h6>
                        </td>

                        <?php foreach($incluye as $value2): ?>
                            <?php if($value2->id_producto == $value->id_producto): ?>
                                <td>
                                    <p class="paddin-5-l">(x<?php echo $value2->cantidad; ?>)</p>
                                </td>
                                <td>
                                    <?php echo ($value->precio * $value2->cantidad).'€'; ?>
                                </td>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <td>
                            <?php $form = ActiveForm::begin([

                                'action' => \yii\helpers\Url::to(['site/eliminar-producto', 'id_producto' => $value->id_producto]),
                                'method' => 'get',

                            ]); ?>
                            <?= Html::submitButton('<i class="material-icons right">delete</i>', ['class' => 'btn-floating btn-small waves-effect red']) ?>
                            <?php ActiveForm::end(); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row center-align">
                <h5 class="inlineblock">Precio total del pedido: </h5>
                <h5 class="inlineblock"><b><?php echo ($precio_total).'€'; ?></b></h5>
            </div>

            <div class="row center-align">
                <?php $form = ActiveForm::begin([

                    'action' => \yii\helpers\Url::to(['site/confirmar-pedido']),
                    'method' => 'get',

                ]); ?>
                <?= Html::submitButton('<i class="material-icons right">send</i>Confirmar pedido', ['class' => 'btn-large waves-effect indigo']) ?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="center-align">
                <small>Recuerda que puedes hacer varios pedidos</small>
            </div>
        <?php else: ?>
            <h5 class="center-align">Aún no has añadido ningún producto a tu pedido.</h5>
        <?php endif; ?>
    </div>
</div>

<div id="test3" class="col s12">
    <?php if(($tieneCuenta)): ?>
        <ul class="collapsible">
            <li>
                <div class="collapsible-header"><i class="material-icons indigo-text">done</i>Entregados</div>
                <div class="collapsible-body">
                    <table>
                        <tbody>
                            <?php foreach($entregados as $key=>$value): ?>
                                <tr>
                                    <td><?php echo $key; ?></td>
                                    <td>(x<?php echo $value; ?>)</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons indigo-text">room_service</i>Preparándose</div>
                <div class="collapsible-body">
                    <table>
                        <tbody>
                        <?php foreach($preparandose as $key=>$value): ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td>(x<?php echo $value; ?>)</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons indigo-text">euro_symbol</i>Resumen de la cuenta</div>
                <div class="collapsible-body">
                    <table>
                        <tbody>
                            <?php foreach($cuenta as $key=>$value): ?>
                                <tr>
                                    <td><?php echo $key; ?> (x<?php echo $value->cantidad; ?>)</td>
                                    <td>
                                        <?php echo $value->precio .'€'; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </li>
        </ul>
        <div class="row">
            <div class="col s10 right-align">
                 <h6>Actualizar información:</h6>
            </div>
            <div class="col s2 left-align paddin-5">
                <a href="<?=Url::to(['/site/menu', 'pestania' => 3])?>" class="btn-floating btn-small waves-effect red lighten-1">
                    <i class="large material-icons">autorenew</i>
                </a>
            </div>
        </div>
        <div class="row center-align">
            <h5 class="inlineblock">Precio total de la cuenta: </h5>
            <h5 class="inlineblock"><b><?php echo ($precio_cuenta).'€'; ?></b></h5>
        </div>
        <div class="container">
            <div class="row">
                <div class="col s6 center-align">
                    <div class="switch">
                        <h6>¿Dejar propina?</h6>
                        <label>
                            <input id="propina_switch" onclick="propina()" type="checkbox">
                            <span class="lever"></span>
                        </label>
                    </div>
                </div>
                <div class="col s6 propinaInput">
                    <input id="propina_input" oninput="validateDecimal()" disabled></input>
                </div>
            </div>
            <h6 id="consejo" class="center-align consejoPropina">La coma se indica con un <b>.</b></h6>
        </div>
        <div class="row"></div>
        <div class="row center-align">
            <?php $form = ActiveForm::begin([

                'action' => \yii\helpers\Url::to(['site/solicitar-cuenta']),
                'method' => 'post',

            ]); ?>
            <?= $form->field($model_propina, 'propina')->label(false)->hiddenInput(['value' => 0, 'id' => 'form_propina'])?>
            <?= $form->field($model_propina, 'total')->label(false)->hiddenInput(['value' => $precio_cuenta])?>
            <?= Html::submitButton('<i class="material-icons right">event_note</i>Solicitar cuenta', ['class' => 'btn-large waves-effect indigo', 'id' => 'solicitar_cuenta']) ?>
            <?php ActiveForm::end(); ?>
        </div>

    <?php else: ?>
    <ul class="collapsible">
        <li>
            <div class="collapsible-header"><i class="material-icons indigo-text">done</i>Entregados</div>
            <div class="collapsible-body"></div>
        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons indigo-text">room_service</i>Preparándose</div>
            <div class="collapsible-body"></div>

        </li>
        <li>
            <div class="collapsible-header"><i class="material-icons indigo-text">euro_symbol</i>Resumen de la cuenta</div>
            <div class="collapsible-body"></div>

        </li>
    </ul>
    <div class="container center-align">
        <h5>Aún no has pedido ningún producto</h5>
    </div>
    <?php endif; ?>
</div>

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/menuUsuario.js')?>"></script>

