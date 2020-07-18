<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
?>
<div class="container col s12 center-align">
    <h4>Restaurantes de Servit</h4>
    <div class="row"></div>
    <?php foreach($restaurantes as $key=>$value): ?>
        <div class="container">
            <div class="card horizontal indigo lighten-2">
                <div class="card-image">
                    <?php if ($value->ruta != null): ?>
                    <img class="tieneImagen" src="<?=Url::to('@web/')?><?php echo $value->ruta; ?>">
                    <?php else: ?>
                    <div class="notieneImagen" class="white-text center-align">Imagen no disponible</div>
                    <?php endif;?>
                </div>
                <div class="card-stacked">
                    <div class="card-content white-text">
                        <?php $nombre_boton = Html::encode($value->getAttribute('nombre')); ?>
                        <span class="card-title"><?php echo $nombre_boton; ?></span>
                        <?php foreach($etiquetas as $key=>$value2): ?>
                            <?php if ($value->id == $value2->id_restaurante): ?>
                                <div class="chip">
                                    <?php echo Html::encode($value2->getAttribute('nombre')); ?>
                                </div>
                            <?php endif;?>
                        <?php endforeach; ?>
                        <div class="row"></div>
                        <?php if ($value->telefono != 0): ?>
                            <p>Teléfono: <?php echo Html::encode($value->getAttribute('telefono')); ?></p>
                        <?php else: ?>
                            <p>Teléfono no disponible</p>
                        <?php endif;?>
                        <?php if ($value->direccion != null): ?>
                            <p>Dirección: <?php echo Html::encode($value->getAttribute('direccion')); ?></p>
                        <?php else: ?>
                            <p>Dirección no disponible</p>
                        <?php endif;?>
                    </div>
                    <div class="card-action">
                        <?php $form = ActiveForm::begin([

                            'action' => \yii\helpers\Url::to(['site/restaurantes', 'id' => $value->id]),
                            'method' => 'get'

                        ]); ?>
                        <?= Html::submitButton('Acceder', ['class' => 'right black-text indigo lighten-5 btn-small']) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
            <div class="row"></div>
        </div>
    <?php endforeach; ?>
    <?= LinkPager::widget(['pagination' => $pages, 'prevPageLabel' => '<i class="material-icons">chevron_left</i>', 'nextPageLabel' => '<i class="material-icons">chevron_right</i>', 'disableCurrentPageButton' => 'true','disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'active white-text']]); ?>
</div>
