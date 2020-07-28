<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="container">
    <div class="row">
        <h4 class="center-align indigo-text text-darken-1"><?php echo Html::encode($restaurante->nombre); ?></h4>
        <div class="col s7">
            <img class="cardimg" src="/servit/web/<?php echo $restaurante->ruta; ?>">
        </div>
        <div class="col s5 center-align">
            <?php foreach($etiquetas as $value2): ?>
                <div class="chip">
                    <?php echo Html::encode($value2->nombre); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row center-align">
        <?php if ($restaurante->telefono != 0): ?>
            <p>Teléfono de contacto: <?php echo Html::encode($restaurante->telefono); ?></p>
        <?php else: ?>
            <p>Teléfono no disponible</p>
        <?php endif;?>
        <?php if ($restaurante->direccion != null): ?>
            <p>Dirección del restaurante: <?php echo Html::encode($restaurante->direccion); ?></p>
        <?php else: ?>
            <p>Dirección no disponible</p>
        <?php endif;?>
        <p>Hora de apertura: <?php echo Html::encode($hora_apertura); ?></p>
        <p>Hora de cierre: <?php echo Html::encode($hora_cierre); ?></p>
    </div>

    <h5 class="center-align">Nuestra carta</h5>
    <div class="row">
        <ul class="collapsible">
            <?php if(!empty($categorias)): ?>
                <?php foreach($categorias as $value): ?>
                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons indigo-text text-lighten-1">arrow_drop_down_circle</i>
                            <?php echo $value->nombre; ?>
                        </div>
                        <div class="collapsible-body center-align">
                            <div class="row">
                                <table class="striped">
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="center-align">Ingredientes</th>
                                        <th>Precio</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($productos as $value2): ?>
                                        <?php if($value2->id_categoria == $value->id_categoria): ?>
                                            <tr>
                                                <td><?php echo $value2->nombre; ?></td>
                                                <td class="center-align">
                                                    <?php foreach($ingredientes as $value3): ?>
                                                        <?php if($value3->id_producto == $value2->id_producto): ?>
                                                            -<?php echo $value3->nombre; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </td>
                                                <td><?php echo $value2->precio; ?>€</td>

                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="blockquoteError">La carta de este restaurante aún no está disponible.</p>
            <?php endif; ?>
        </ul>
    </div>
</div>
