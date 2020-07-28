<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
?>
<div class="container">
    <h3><?= Html::encode($this->title) ?></h3>

    <p>Rellena los siguientes campos para iniciar sesión:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'username', ['template' => '<div class="input-field"><i class="material-icons prefix">account_circle</i>{label}{input}{hint}{error}</div>'])->textInput() ?>
    <?= $form->field($model, 'password', ['template' => '<div class="input-field"><i class="material-icons prefix">vpn_key</i>{label}{input}{hint}{error}</div>'])->passwordInput() ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Acceder', ['class' => 'btn btn-primary indigo lighten-1', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
