<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container col s12">
    <h4>Carta de nuestro restaurante</h4>
    <div class="row">
        <ul class="collapsible popout">
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
                                            <th class="padIngredientes">Ingredientes destacados</th>
                                            <th>Precio</th>
                                            <th>Alérgenos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($productos as $value2): ?>
                                            <?php if($value2->id_categoria == $value->id_categoria): ?>
                                                <tr>
                                                    <td><?php echo $value2->getAttribute('nombre'); ?></td>
                                                    <td>
                                                        <?php foreach($ingredientes as $value3): ?>
                                                            <?php if($value3->id_producto == $value2->id_producto): ?>
                                                                <div class="chip">
                                                                    <?php echo $value3->getAttribute('nombre'); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td><?php echo $value2->getAttribute('precio'); ?>€</td>
                                                    <td>
                                                        <?php $tiene_alergenos = false; ?>
                                                        <?php foreach($alergias as $value3): ?>
                                                            <?php if($value3->id_producto == $value2->id_producto): ?>
                                                                <img class="alergenosCartaPublica" src="<?=Url::to('@web/images/alergias/')?><?php echo $value3->getAttribute('id_alergia'); ?>.svg">
                                                                <?php $tiene_alergenos = true; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php if(!$tiene_alergenos): ?>
                                                            Sin alérgenos
                                                        <?php endif; ?>
                                                    </td>
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
