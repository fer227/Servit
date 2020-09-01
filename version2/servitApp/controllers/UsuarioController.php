<?php

namespace app\controllers;
use Yii;
use app\models\Usuario;

class UsuarioController extends \yii\web\Controller
{
    public function actionEmpleado(){
        $request = $_REQUEST;

        $usuario = new Usuario();
        $usuario->attributes=$request;
        if ($usuario->save()) {
            Yii::$app->response->setStatusCode(200);
        }
        else
        {
            Yii::$app->response->setStatusCode(400);
        }
    }
}
