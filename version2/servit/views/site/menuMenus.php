<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title= 'Edita la carta de tu restaurante- Menús';
?>
    <!--
    <div class="row">
        <div class="col s3 center-align" style="margin-top: 20px">

            <div class="row">
                <a style="width: 70%" class='dropdown-trigger blue darken-4 btn-large' href='#' data-target='dropdown1'><i class="material-icons left">arrow_drop_down_circle</i>Menús</a>
            </div>

            <div class="row">
                <a style="width: 70%" href="<?=Url::to('@web/')?>site/form-menu" class="waves-effect waves-light blue darken-4 white-text btn">Añadir Menú</a>
            </div>

            Dropdown Structure
            <ul id='dropdown1' class='dropdown-content'>
                <li><a class="blue-text text-darken-4 center-align" href="<?=Url::to('@web/')?>site/menu-categorias">Categorías</a></li>
                <li><a class="blue-text text-darken-4 center-align" href="<?=Url::to('@web/')?>site/menu-productos">Productos</a></li>
                <li><a class="blue-text text-darken-4 center-align" href="<?=Url::to('@web/')?>site/menu-menus">Menús</a></li>
            </ul>

        </div>
 -->
    <div class="col s12">
        <ul class="tabs center">
            <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/menu-categorias" target="_self">CATEGORÍAS</a></li>
            <li class="tab col s3"><a href="<?=Url::to('@web/')?>site/menu-productos" target="_self">PRODUCTOS</a></li>
            <li class="tab col s3"><a class="active" href="<?=Url::to('@web/')?>site/menu-menus" target="_self">MENÚS</a></li>
        </ul>
    </div>
    <div class="row"></div>
<?php if ( empty($menus)): ?>
    <div class="center-align">
        <h5>--EN DESARROLLO--</h5>
    </div>
<?php else: ?>
    <div class="col s2"></div>
    <div class="col s10 center-align">
        <table class="striped" style="margin-left: 20px">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Categoría 1</th>
                <th>Categoría 2</th>
                <th>Categoría 3</th>
                <th>Categoría 4</th>
                <th class="center-align">Opción</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach($menus as $key=>$value): ?>
                <tr>
                    <td><?php echo $value->getAttribute('nombre'); ?></td>
                    <td>
                        <?php if ($value->categoria1 == null): ?>
                            <p>---</p>
                        <?php else: ?>
                            <?php echo $value->categoria1; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($value->categoria2 == null): ?>
                            <p>---</p>
                        <?php else: ?>
                            <?php echo $value->categoria2; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($value->categoria3 == null): ?>
                            <p>---</p>
                        <?php else: ?>
                            <?php echo $value->categoria3; ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($value->categoria4 == null): ?>
                            <p>---</p>
                        <?php else: ?>
                            <?php echo $value->categoria4; ?>
                        <?php endif; ?>
                    </td>
                    <td class="center-align">
                        <?php $form = ActiveForm::begin([

                            'action' => \yii\helpers\Url::to(['site/editar-menu', 'menu' => $value->nombre]),
                            'method' => 'get',
                            'options' => [
                                'style' => 'display: inline'
                            ]

                        ]); ?>
                        <?= Html::submitButton('<i class="material-icons right">tune</i>', ['class' => 'btn-floating waves-effect waves-light blue darken-4 btn-small']) ?>
                        <?php ActiveForm::end(); ?>
                        <?php $form = ActiveForm::begin([

                            'action' => \yii\helpers\Url::to(['site/eliminar-menu', 'menu' => $value->getAttribute('nombre')]),
                            'method' => 'get',
                            'options' => [
                                'style' => 'display: inline'
                            ]

                        ]); ?>
                        <?= Html::submitButton('<i class="material-icons right">close</i>', ['class' => 'btn-floating waves-effect red btn-small']) ?>
                        <?php ActiveForm::end(); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>