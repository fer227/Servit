<?php

namespace app\controllers;

use app\models\editarEmpleadoForm;
use app\models\Empleado;
use app\models\Usuario;
use yii\rest\ActiveController;

class UsuarioController extends ActiveController
{
    protected function verbs() {
        $verbs = parent::verbs();
        $verbs =  [
            'index' => ['GET', 'POST', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH']
        ];
        return $verbs;
    }
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