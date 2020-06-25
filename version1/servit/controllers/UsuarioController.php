<?php

namespace app\controllers;

use app\models\editarEmpleadoForm;
use app\models\Empleado;
use app\models\Usuario;
use yii\rest\ActiveController;

class UsuarioController extends ActiveController
{
    public $modelClass = Usuario::class;
    public function actionEmpleado(){
        $request = $_REQUEST;

        $usuario = new Usuario();
        $usuario->attributes=$request;
        if ($usuario->save()) {
            \Yii::$app->response->setStatusCode(200);
            \Yii::$app->response->setStatusCode(200);
        }
        else
        {
            \Yii::$app->response->setStatusCode(400);
        }
    }
}