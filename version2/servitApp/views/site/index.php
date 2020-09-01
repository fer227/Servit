<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = 'Restaurantes';
?>
<div class="container">

    <h4 class="center-align indigo-text text-darken-1"><?= Html::encode($this->title) ?></h4>

    <div class="fixed-action-btn">
        <a href="<?=Url::to('@web/')?>site/codigo" class="btn-floating btn-large red lighten-1">
            <i class="large material-icons">photo_camera</i>
        </a>
    </div>

    <?php foreach($restaurantes as $key=>$value): ?>
        <div class="row">
            <div class="col s12 m7">
                <div class="card">
                    <div class="card-image">
                        <?php if ($value->ruta != null): ?>
                            <img class="tieneImagen" src="/servit/web/<?php echo $value->ruta; ?>">
                        <?php else: ?>
                            <div class="notieneImagen" class="white-text center-align">Imagen no disponible</div>
                        <?php endif;?>
                        <?php $form = ActiveForm::begin([

                            'action' => \yii\helpers\Url::to(['site/index', 'id' => $value->id]),
                            'method' => 'get'

                        ]); ?>
                        <?= Html::submitButton('<i class="large material-icons right">info_outline</i>', ['class' => 'btn-floating btn-large halfway-fab waves-effect waves-light indigo lighten-1']) ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <div class="card-content white text">
                        <span class="card-title"><?php echo $value->nombre ?></span>
                        <div class="center-align">
                            <?php foreach($etiquetas as $key=>$value2): ?>
                                <?php if ($value->id == $value2->id_restaurante): ?>
                                    <div class="chip">
                                        <?php echo Html::encode($value2->nombre); ?>
                                    </div>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
