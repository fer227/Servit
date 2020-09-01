<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div id="test1" class="col s12">
    <div class="container">
        <?php foreach($zonas as $value): ?>
            <h4 class="center-align"><?php echo $value->nombre; ?></h4>
            <ul class="collapsible">
                <?php foreach($secciones as $value2): ?>
                    <?php if ($value2->id_zona == $value->id): ?>
                        <li>
                            <div class="collapsible-header">
                                <?php if ($value2->estado == 2): ?>
                                    <i class="material-icons indigo-text">restaurant</i>
                                    <?php if (($zona_array[$value2->id_zona][$value2->numero]['comanda'] == 1) and ($zona_array[$value2->id_zona][$value2->numero]['cuenta'] == 1)): ?>
                                        <span class="new badge green">2</span>
                                    <?php elseif ($zona_array[$value2->id_zona][$value2->numero]['comanda'] == 1): ?>
                                        <span class="new badge red lighten-1">1</span>
                                    <?php elseif ($zona_array[$value2->id_zona][$value2->numero]['cuenta'] == 1): ?>
                                        <span class="new badge green">1</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="material-icons indigo-text">remove</i>
                                <?php endif; ?>
                                <?php if (!$value->es_barra): ?>
                                    <span>Mesa <?php echo $value2->numero; ?></span>
                                <?php else: ?>
                                    <span>Barra <?php echo $value2->numero; ?></span>
                                <?php endif; ?>

                            </div>
                            <div class="collapsible-body center-align">
                                <div class="row">
                                    <?php if ($value2->estado == 2): ?>
                                        <?php if ($zona_array[$value2->id_zona][$value2->numero]['cuenta'] == 1): ?>
                                            <div class="row"><p class="green-text text-darken-3">El cliente solicita la cuenta</p></div>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['camarero/pagado', 'zona' => $value->id, 'seccion' => $value2->numero]),
                                                'method' => 'get',
                                                'options' => [
                                                    'style' => 'display: inline;'
                                                ]

                                            ]); ?>
                                            <div class="col s6">
                                                <h6 class="right-align" style="display: block">¿Pagado?: </h6>
                                            </div>
                                            <div class="col s4">
                                                <?= Html::submitButton('<i class="material-icons">done</i>', ['class' => 'btn-floating waves-effect green']) ?>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                            <div class="col s2">
                                            </div>
                                            <div class="row"></div>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['#']),
                                                'method' => 'get',
                                                'options' => [
                                                    'style' => 'display: inline;'
                                                ]

                                            ]); ?>
                                            <div class="col s6">
                                                <h6 class="right-align" style="display: block">Imprimir cuenta: </h6>
                                            </div>
                                            <div class="col s4">
                                                <?= Html::submitButton('<i class="material-icons">print</i>', ['class' => 'btn-floating waves-effect pink']) ?>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                            <div class="col s2">
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($zona_array[$value2->id_zona][$value2->numero]['comanda'] == 1): ?>
                                        <div class="row"></div>
                                        <?php $form = ActiveForm::begin([

                                            'action' => \yii\helpers\Url::to(['camarero/comanda', 'zona' => $value->id, 'seccion' => $value2->numero]),
                                            'method' => 'get',

                                        ]); ?>

                                            <div class="col s6">
                                                <h6 class="right-align">Comanda: </h6>
                                            </div>
                                            <div class="col s4">
                                                <?= Html::submitButton('<i class="material-icons">assignment</i>', ['class' => 'btn-floating waves-effect orange']) ?>
                                            </div>
                                            <div class="col s2">
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        <?php endif; ?>
                                        <?php if ($zona_array[$value2->id_zona][$value2->numero]['entregados'] == 1): ?>
                                            <div class="row"></div>
                                            <?php $form = ActiveForm::begin([

                                                'action' => \yii\helpers\Url::to(['camarero/entregados', 'zona' => $value->id, 'seccion' => $value2->numero]),
                                                'method' => 'get',

                                            ]); ?>

                                            <div class="col s6">
                                                <h6 class="right-align">Entregados: </h6>
                                            </div>
                                            <div class="col s4">
                                                <?= Html::submitButton('<i class="material-icons">assignment_turned_in</i>', ['class' => 'btn-floating waves-effect blue']) ?>
                                            </div>
                                            <div class="col s2">
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </div>
</div>

<div id="test2" class="col s12">
    <div class="container center-align">
        <h5>En próximas actualizaciones</h5>
    </div>
</div>
