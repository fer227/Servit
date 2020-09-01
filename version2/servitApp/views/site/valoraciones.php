<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<?php foreach($valoraciones as $value): ?>
    <div class="container">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    <div class="row">
                        <div class="mitad">
                            <span class="card-title indigo-text text-darken-4"> <?php echo $value->restaurante; ?></span>
                            <?php if($value->ambiente != null): ?>
                                <p class="green-text text-darken-1">Completado</p>
                            <?php else: ?>
                                <p class="red-text text-darken-1">Pendiente</p>
                            <?php endif; ?>
                        </div>
                        <div class="mitad">
                            <?php $form = ActiveForm::begin([

                                'action' => \yii\helpers\Url::to(['site/editar-valoracion', 'id_zona' => $value->id_zona, 'seccion' => $value->numero, 'datetime' => $value->datetime]),
                                'method' => 'post'

                            ]); ?>
                            <?= Html::submitButton('<i class="material-icons large">edit</i>', ['class' => 'right white-text indigo btn btn-floating']) ?>
                            <?php ActiveForm::end(); ?>
                            <?php echo substr($value->datetime, 0, -3); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
