<?php

namespace app\controllers;
use app\models\Atiende;
use app\models\Empleado;
use app\models\Incluye;
use app\models\Pedido;
use app\models\Producto;
use app\models\Seccion;
use app\models\Zona;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class SeccionController extends ActiveController
{
    public $modelClass = Seccion::class;
    public function actionAsignadas()
    {
        $request = $_REQUEST;
        $empleado = $request['username'];
        $secciones = Seccion::findAll(['usuario_empleado' => $empleado]);
        \Yii::$app->response->setStatusCode(200);
        $zonas = [];
        $comprobaciones = [];

        foreach ($secciones as $value){
            $zona_now = Zona::findOne(['id' => $value->id_zona]);
            if(empty($zonas)){
                $zonas = array($zona_now);
                $comprobaciones[$zona_now->id] = 1;
            }
            else if(!isset($comprobaciones[$zona_now->id])){
                $zonas = array_merge($zonas, array($zona_now));
                $comprobaciones[$zona_now->id] = 1;
            }
        }
        $zona_array = [];
        foreach ($zonas as $zona){
            $secciones_zona = Seccion::findAll(['id_zona' => $zona->id, 'usuario_empleado' => $empleado]);
            $incluye_secciones = [];
            foreach ($secciones_zona as $value){
                if($value->estado == 2){
                    $atiende_row = Atiende::find()
                        ->where(['id_zona' => $zona->id, 'numero' => $value->numero])
                        ->orderBy(['datetime' => SORT_DESC])
                        ->limit(1)
                        ->all();
                    $datetime = '';
                    $username = '';
                    $incluye_all = [];
                    $incluye_all['comanda'] = 0;
                    $incluye_all['entregados'] = 0;
                    foreach ($atiende_row as $value2){
                        $datetime = $value2->datetime;
                        $username = $value2->username;
                        $incluye_all['cuenta'] = $value2->estado_cuenta;
                    }
                    $pedido = Pedido::find()
                        ->where(['estado' => 1, 'username' => $username])
                        ->andWhere(['>=', 'datetime', $datetime])
                        ->all();

                    $comanda_bool = false;
                    $entregados_bool = false;
                    foreach ($pedido as $value2){
                        $incluye_comanda = Incluye::find()
                            ->where(['id_pedido' => $value2->id_pedido])
                            ->andWhere('cantidad_entregada < cantidad')
                            ->all();
                        $incluye_entregados = Incluye::find()
                            ->where(['id_pedido' => $value2->id_pedido])
                            ->andWhere(['>', 'cantidad_entregada', 0])
                            ->all();
                        if(!empty($incluye_comanda)){
                            $incluye_all['comanda'] = 1;
                            $comanda_bool = true;
                        }
                        if(!empty($incluye_entregados)){
                            $incluye_all['entregados'] = 1;
                            $entregados_bool= true;
                        }
                        if($comanda_bool and $entregados_bool)
                            break;
                    }
                    $incluye_secciones[$value->numero] = $incluye_all;
                }
                else{
                    $incluye_secciones[$value->numero] = 0;
                }
            }
            $zona_array[$zona->id] = $incluye_secciones;
        }

        $secciones = ArrayHelper::toArray($secciones);
        $zonas = ArrayHelper::toArray($zonas);
        $zona_array = ArrayHelper::toArray($zona_array);
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        echo json_encode(array('secciones' => $secciones,'zonas' => $zonas, 'zona_array' => $zona_array),JSON_PRETTY_PRINT);
        exit();
    }

    public function actionPagado(){
        $request = $_REQUEST;
        $id_zona = $request['id_zona'];
        $seccion = $request['seccion'];

        $atiende_row = Atiende::find()
            ->where(['id_zona' => $id_zona, 'numero' => $seccion])
            ->orderBy(['datetime' => SORT_DESC])
            ->limit(1)
            ->all();
        $datetime = '';
        $username = '';
        foreach ($atiende_row as $value2){
            $datetime = $value2->datetime;
            $username = $value2->username;
            $value2->estado_cuenta = 2;
            $value2->save();
        }
        $pedido = Pedido::find()
            ->select(['id_pedido', 'datetime'])
            ->where(['estado' => 1, 'username' => $username])
            ->andWhere(['>=', 'datetime', $datetime])
            ->all();
        $productos_pendientes = false;
        foreach ($pedido as $value){
            $incluye = Incluye::find()
                ->where(['id_pedido' => $value->id_pedido])
                ->andWhere('cantidad_entregada != cantidad')
                ->all();
            if(!empty($incluye)){
                $productos_pendientes = true;
                break;
            }
        }
        if(!$productos_pendientes){
            $seccion = Seccion::findOne(['id_zona' => $id_zona, 'numero' => $seccion]);
            $seccion->estado = 0;
            $seccion->save();
        }
    }

    public function actionConfirmarEntregados(){
        $body = file_get_contents('php://input');
        $json = json_decode($body);
        $ubiacion = $json->ubicacion;
        $entregados = $json->entregados;

        foreach ($entregados as $key=>$value){
            list($id_producto, $id_pedido) = explode("_", $key);
            $incluye_now = Incluye::find()
                ->where(['id_producto' => $id_producto, 'id_pedido' => $id_pedido])
                ->andWhere('cantidad_entregada != cantidad')
                ->all();
            print_r($incluye_now);
            foreach ($incluye_now as $row){
                $row->cantidad_entregada += $value;
                $row->save();
            }
        }

        $id_zona = $ubiacion['zona'];
        $seccion = $ubiacion['seccion'];

        $atiende_row = Atiende::find()
            ->where(['id_zona' => $id_zona, 'numero' => $seccion])
            ->orderBy(['datetime' => SORT_DESC])
            ->limit(1)
            ->all();
        $datetime = '';
        $username = '';
        foreach ($atiende_row as $value2){
            $datetime = $value2->datetime;
            $username = $value2->username;
            if($value2->estado_cuenta == 2){
                $pedido = Pedido::find()
                    ->select(['id_pedido', 'datetime'])
                    ->where(['estado' => 1, 'username' => $username])
                    ->andWhere(['>=', 'datetime', $datetime])
                    ->all();
                $productos_pendientes = false;
                foreach ($pedido as $value){
                    $incluye = Incluye::findAll(['id_pedido' => $value->id_pedido]);
                    foreach ($incluye as $value2){
                        if($value2->cantidad_entregada != $value2->cantidad){
                            $productos_pendientes = true;
                            break;
                        }
                    }
                }
                if(!$productos_pendientes){
                    $seccion = Seccion::findOne(['id_zona' => $id_zona, 'numero' => $seccion]);
                    $seccion->estado = 0;
                    $seccion->save();
                }
            }
        }
    }

    public function actionEntregados(){
        $request = $_REQUEST;
        $id_zona = $request['id_zona'];
        $seccion = $request['seccion'];

        $atiende_row = Atiende::find()
            ->where(['id_zona' => $id_zona, 'numero' => $seccion])
            ->orderBy(['datetime' => SORT_DESC])
            ->limit(1)
            ->all();
        $datetime = '';
        $username = '';
        foreach ($atiende_row as $value2){
            $datetime = $value2->datetime;
            $username = $value2->username;
        }
        $pedido = Pedido::find()
            ->select(['id_pedido', 'datetime'])
            ->where(['estado' => 1, 'username' => $username])
            ->andWhere(['>=', 'datetime', $datetime])
            ->all();
        $entregados = [];
        foreach($pedido as $value){
            $incluye = Incluye::findAll(['id_pedido' => $value->id_pedido]);
            foreach ($incluye as $value2){
                if($value2->cantidad_entregada > 0){
                    $producto = Producto::findOne(['id_producto' => $value2->id_producto]);
                    if(array_key_exists($producto->nombre, $entregados)){
                        $entregados[$producto->nombre] += $value2->cantidad_entregada;
                    }
                    else{
                        $entregados[$producto->nombre] = $value2->cantidad_entregada;
                    }
                }
            }
        }
        echo json_encode($entregados,JSON_PRETTY_PRINT);
        exit();
    }

    public function actionComanda(){
        $request = $_REQUEST;
        $id_zona = $request['id_zona'];
        $seccion = $request['seccion'];

        $atiende_row = Atiende::find()
            ->where(['id_zona' => $id_zona, 'numero' => $seccion])
            ->orderBy(['datetime' => SORT_DESC])
            ->limit(1)
            ->all();
        $datetime = '';
        $username = '';
        foreach ($atiende_row as $value2){
            $datetime = $value2->datetime;
            $username = $value2->username;
        }
        $pedido = Pedido::find()
            ->select(['id_pedido', 'datetime'])
            ->where(['estado' => 1, 'username' => $username])
            ->andWhere(['>=', 'datetime', $datetime])
            ->all();
        $incluye = [];
        $pedidos = [];
        foreach ($pedido as $value){
            $incluye_now = Incluye::find()
                ->where(['id_pedido' => $value->id_pedido])
                ->andWhere('cantidad_entregada != cantidad')
                ->all();
            if(empty($incluye) and !empty($incluye_now)){
                $incluye = $incluye_now;
                $pedidos = array($value);
            }
            else if(!empty($incluye_now)){
                $incluye = array_merge($incluye, $incluye_now);
                $pedidos = array_merge($pedidos, array($value));
            }
        }
        $zona = Zona::findOne(['id' => $id_zona]);
        $productos = Producto::findAll(['id_restaurante' => $zona->id_restaurante]);
        $incluye = ArrayHelper::toArray($incluye);
        $productos = ArrayHelper::toArray($productos);
        $pedidos = ArrayHelper::toArray($pedidos);
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        echo json_encode(array('incluye' => $incluye, 'productos' => $productos, 'pedidos' => $pedidos),JSON_PRETTY_PRINT);
        exit();
    }
}
