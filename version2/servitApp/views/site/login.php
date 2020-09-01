<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Iniciar sesión';
?>
<div class="container">
    <h3 class="center-align"><?= Html::encode($this->title) ?></h3>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <?= $form->field($model, 'username', ['template' => '<div class="input-field"><i class="material-icons prefix">account_circle</i>{label}{input}{hint}{error}</div>'])->textInput() ?>

    <?= $form->field($model, 'password', ['template' => '<div class="input-field"><i class="material-icons prefix">vpn_key</i>{label}{input}{hint}{error}</div>'])->passwordInput() ?>
    <div class="center-align">
        <a href="<?=Url::to('@web/')?>site/register">¿No tienes cuenta? Regístrate</a>
    </div>
    <br>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11 center-align">
                <?= Html::submitButton('Acceder', ['class' => 'btn btn-primary indigo lighten-1', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
