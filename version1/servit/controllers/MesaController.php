<?php

namespace app\controllers;

use app\models\Mesa;
use yii\helpers\ArrayHelper;

class MesaController extends \yii\web\Controller
{
    public function actionMesas()
    {
        $request = $_REQUEST;
        $empleado = $request['username'];
        $mesas = Mesa::findAll(['empleado' => $empleado]);
        \Yii::$app->response->setStatusCode(200);
        $mesas = ArrayHelper::toArray($mesas);
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        echo json_encode(array('data'=>$mesas),JSON_PRETTY_PRINT);
    }

}
