<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container">
    <div class="center-align">
        <img class="logomenu" src="<?=Url::to('@web/images/admin.svg')?>">
    </div>
    <div class="row center">
        <?php if ($nombre == null): ?>
        <h5 class="header col s12 light">Empieza creando tu restaurante</h5>
        <div class="center-align">
            <a href="<?=Url::to('@web/')?>site/crear-restaurante" class="waves-effect pink lighten-1 btn">Crear restaurante</a>
        </div>
        <?php else: ?>
        <h5 class="header col s12 light">Gestiona tu restaurante: <b><?php echo Html::encode($nombre); ?></b></h5>
        <div class="row">
            <div class="col s6">
                <div class="card indigo lighten-5 hoverable">
                    <div class="card-content black-text cardmenu">
                        <span class="card-title black-text"><b>Información del restaurante</b><div class="divider"></div></span>
                        <p>Modifica la información general de tu restaurante.</p>
                    </div>
                    <div class="card-action left-align">
                        <a class="red-text text-lighten-2" href="<?=Url::to('@web/')?>site/editar-informacion">Acceder</a>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card indigo lighten-5 hoverable">
                    <div class="card-content black-text cardmenu">
                        <span class="card-title black-text"><b>Carta</b><div class="divider"></div></span>
                        <p>Añade nuevos platos o bebidas, modifica su información o precio e introducelos en su correspondiente categoría.</p>
                    </div>
                    <div class="card-action left-align">
                        <a class="red-text text-lighten-2" href="<?=Url::to('@web/')?>site/menu-categorias">Acceder</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <div class="card indigo lighten-5 hoverable">
                    <div class="card-content black-text cardmenu">
                        <span class="card-title black-text"><b>Empleados</b><div class="divider"></div></span>
                        <p>Da de alta o modifica los datos de tus trabajadores. Puedes consultar su trabajo.</p>
                    </div>
                    <div class="card-action left-align">
                        <a class="red-text text-lighten-2" href="<?=Url::to('@web/')?>site/empleados">Acceder</a>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card indigo lighten-5 hoverable">
                    <div class="card-content black-text cardmenu">
                        <span class="card-title black-text"><b>Zonas y mesas</b><div class="divider"></div></span>
                        <p>Establece las diferentes zonas de tu restaurante (salones, terrazas, barras), crea sus correspondientes mesas y asígnales empleados para que las atiendan.</p>
                    </div>
                    <div class="card-action left-align">
                        <a class="red-text text-lighten-2" href="<?=Url::to('@web/')?>site/zonas">Acceder</a>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col s6">
                    <div class="card indigo lighten-5 hoverable">
                        <div class="card-content black-text cardmenu">
                            <span class="card-title black-text"><b>Informes</b><div class="divider"></div></span>
                            <p>Observa el rendimiento de tu restaurante. Comprueba cómo están siendo las valoraciones de tus clientes.</p>
                        </div>
                        <div class="card-action left-align">
                            <a class="red-text text-lighten-2" href="<?=Url::to('@web/')?>site/informes">Acceder</a>
                        </div>
                    </div>
                </div>
                <div class="col s6">
                    <div class="card indigo lighten-5 hoverable">
                        <div class="card-content black-text cardmenu">
                            <span class="card-title black-text"><b>Históricos</b><div class="divider"></div></span>
                            <p class="center-align">Próximamente</p>
                        </div>
                        <div class="card-action left-align">
                            <a class="red-text text-lighten-2" href="<?=Url::to('@web/')?>site/#">Acceder</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>