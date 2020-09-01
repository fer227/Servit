<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container center-align">
    <?php foreach($pedidos as $pedido): ?>
        <h5 class="center-align">Pedido a las <?php echo $pedido->datetime; ?></h5>
        <table>
            <?php foreach($incluye as $value): ?>
                <?php if ($value->id_pedido == $pedido->id_pedido): ?>
                    <tbody>
                    <?php foreach($productos as $value2): ?>
                        <tr>
                            <?php if ($value2->id_producto == $value->id_producto): ?>
                                <td class="center-align width20"><h6><b>x</b><b id='cant_<?php echo $value2->id_producto; ?>_<?php echo $value->id_pedido; ?>'><?php echo ($value->cantidad - $value->cantidad_entregada); ?></b></h6></td>
                                <td class="center-align width60"><?php echo $value2->nombre; ?></td>
                                <td class="center-align width20">
                                    <a id="boton_<?php echo $value2->id_producto; ?>_<?php echo $value->id_pedido; ?>" onclick="restar(<?php echo ($value2->id_producto)?>, <?php echo ($value->id_pedido)?>)" class="btn-floating btn-small waves-effect waves-light indigo"><i class="material-icons">check</i></a>
                                </td>
                                <?php break; ?>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
        <div class="row"></div>
    <?php endforeach; ?>
    <div class="row">

    </div>
    <div class="row">
        <?php $form = ActiveForm::begin([

            'action' => \yii\helpers\Url::to(['camarero/comanda']),
            'method' => 'post'

        ]); ?>
        <?= $form->field($model, 'json')->label(false)->hiddenInput(['id' => 'json', 'value' => ''])?>
        <?= $form->field($model, 'zona')->label(false)->hiddenInput(['value' => $zona])?>
        <?= $form->field($model, 'seccion')->label(false)->hiddenInput(['value' => $seccion])?>
        <?= Html::submitButton('Confirmar entregados', ['class' => 'white-text indigo btn']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<script type="text/javascript" src="<?=Url::to('@web/themes/material-default/js/comanda.js')?>"></script>
