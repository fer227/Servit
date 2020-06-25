<?php

namespace app\controllers;

use app\models\Categoria;
use app\models\Empleado;
use app\models\Mesa;
use app\models\Producto;
use app\models\Restaurante;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class RestaurantController extends ActiveController
{
    public $modelClass = Restaurante::class;

    public function actionCodigo(){
        $request = $_REQUEST;
        $idRestaurante = $request['restaurante'];
        $idMesa = $request['mesa'];
        $mesa = Mesa::findOne(['restaurante' => $idRestaurante, 'numero' => $idMesa]);
        echo($mesa->numero);
        if($mesa->reservada == 0){
            $mesa->reservada = 1;
            $mesa->save();
            \Yii::$app->response->setStatusCode(200);
        }
        else
            \Yii::$app->response->setStatusCode(400);

    }

    public function actionAceptarCodigo(){
        $request = $_REQUEST;
        $idMesa = $request['mesa'];
        $idEmpleado = $request['username'];
        $empleado = Empleado::findOne(['usuario' => $idEmpleado]);
        $idRestaurante = $empleado->restaurante;
        $mesa = Mesa::findOne(['restaurante' => $idRestaurante, 'numero' => $idMesa]);
        $mesa->reservada = 3;
        $mesa->save();
        /*if($mesa->reservada == 0){
            $mesa->reservada = 1;
            $mesa->save();
            \Yii::$app->response->setStatusCode(200);
        }
        else
            \Yii::$app->response->setStatusCode(400);
        */

    }

    public function actionObtenerCarta(){
        $request = $_REQUEST;
        $idRestaurante = $request['restaurante'];
        $productos = Producto::findAll(['restaurante' => $idRestaurante]);
        $categorias = Categoria::findAll(['restaurante' => $idRestaurante]);
        \Yii::$app->response->setStatusCode(200);
        $productos = ArrayHelper::toArray($productos);
        $categorias = ArrayHelper::toArray($categorias);
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        echo json_encode(array('productos'=>$productos, 'categorias' => $categorias),JSON_PRETTY_PRINT);
    }
}
