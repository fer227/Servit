<?php

namespace app\controllers;

use app\models\Atiende;
use app\models\Categoria;
use app\models\Clasifica;
use app\models\Empleado;
use app\models\Incluye;
use app\models\Ingrediente;
use app\models\Pedido;
use app\models\Producto;
use app\models\Restaurante;
use app\models\Seccion;
use app\models\Supone;
use app\models\Usuario;
use app\models\Zona;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;

class RestaurantController extends ActiveController
{
    public $modelClass = Restaurante::class;

    public function actionCodigo(){
        $request = $_REQUEST;
        $idZona = $request['zona'];
        $idSeccion = $request['seccion'];
        $username = $request['username'];
        $seccion = Seccion::findOne(['id_zona' => $idZona, 'numero' => $idSeccion]);
        if($seccion->estado == 0){
            $seccion->estado = 2;
            $seccion->save();
            $atiende =  new Atiende();
            $atiende->id_zona = $idZona;
            $atiende->numero = $idSeccion;
            $atiende->estado_cuenta = 0;
            $atiende->username = $username;
            $atiende->datetime = date("Y-m-d H:i:s");
            $atiende->save();
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

    public function actionEtiquetas(){
        if (Yii::$app->request->get('id')){
            $request = $_REQUEST;
            $idRestaurante = $request['id'];
            $etiquetas = Clasifica::find()->where(['id_restaurante' => $idRestaurante])->all();
            $etiquetas = ArrayHelper::toArray($etiquetas);
            echo json_encode($etiquetas,JSON_PRETTY_PRINT);
            exit();
        }
        else{
            $etiquetas = Clasifica::find()->all();
            $etiquetas = ArrayHelper::toArray($etiquetas);
            echo json_encode($etiquetas,JSON_PRETTY_PRINT);
            exit();
        }

    }

    public function actionProductosByCategoria(){
        $request = $_REQUEST;
        $id = $request['id_categoria'];
        $productos = Producto::findAll(['id_categoria' => $id]);
        $productos = ArrayHelper::toArray($productos);
        echo json_encode($productos, JSON_PRETTY_PRINT);
        exit();
    }

    public function actionEliminarProducto(){
        $request = $_REQUEST;
        $id = $request['id_producto'];
        $username = $request['username'];
        $pedido = Pedido::findOne(['username' => $username, 'estado' => '0']);
        if(Incluye::deleteAll(['id_producto' => $id, 'id_pedido' => $pedido->id_pedido])){
            \Yii::$app->response->setStatusCode(200);
        }
        else
            \Yii::$app->response->setStatusCode(400);

    }

    public function actionConfirmarPedido(){
        $request = $_REQUEST;
        $username = $request['username'];
        //0 no enviado, 1 enviado
        $pedido = Pedido::findOne(['username' => $username, 'estado' => '0']);
        $pedido->estado = 1;
        $pedido->save();
    }

    public function actionAddPedido(){
        $request = $_REQUEST;
        $id = $request['id_producto'];
        $cantidad = $request['cantidad'];
        $username = $request['username'];
        $pedido = Pedido::findOne(['username' => $username, 'estado' => '0']);
        if($pedido == null){
            $newPedido = new Pedido();
            $newPedido->estado = 0;
            $newPedido->datetime = date("Y-m-d H:i:s");
            $newPedido->username = $username;
            $newPedido->precio_total = 0;
            $newPedido->save();
            $incluye = new Incluye();
            $incluye->cantidad = $cantidad;
            $incluye->id_producto = $id;
            $incluye->id_pedido = $newPedido->id_pedido;
            $incluye->cantidad_entregada = 0;
            $incluye->save();
            \Yii::$app->response->setStatusCode(200);
        }
        else{
            $incluye_existe = Incluye::findOne(['id_pedido' => $pedido->id_pedido, 'id_producto' => $id]);
            if($incluye_existe == null){
                $incluye = new Incluye();
                $incluye->cantidad = $cantidad;
                $incluye->id_producto = $id;
                $incluye->id_pedido = $pedido->id_pedido;
                $incluye->cantidad_entregada = 0;
                $incluye->save();
                \Yii::$app->response->setStatusCode(200);
            }
            else{
                $incluye_existe->cantidad = $incluye_existe->cantidad + $cantidad;
                $incluye_existe->save();
                \Yii::$app->response->setStatusCode(200);
            }
        }
    }

    public function actionPedidoActual(){
        $request = $_REQUEST;
        $username = $request['username'];
        $pedido = Pedido::findOne(['username' => $username, 'estado' => 0]);
        if($pedido != null){
            $incluye = Incluye::findAll(['id_pedido' => $pedido->id_pedido]);
            $productos = [];
            foreach ($incluye as $value){
                $producto_now = Producto::findAll(['id_producto' => $value->id_producto]);
                if(empty($productos)){
                    $productos = $producto_now;
                }
                else{
                    $productos = array_merge($productos, $producto_now);
                }
            }
            $productos = ArrayHelper::toArray($productos);
            $incluye = ArrayHelper::toArray($incluye);
            //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            \Yii::$app->response->setStatusCode(200);
            echo json_encode(array('productos'=>$productos, 'incluye' => $incluye),JSON_PRETTY_PRINT);
            exit();
        }
        else{
            \Yii::$app->response->setStatusCode(400);
        }
    }

    public function actionCuenta(){
        $request = $_REQUEST;
        $username = $request['username'];
        $atiende_row = Atiende::find()
            ->orderBy(['datetime' => SORT_DESC])
            ->where(['username' => $username])
            ->limit(1)
            ->all();
        $datetime = '';
        foreach ($atiende_row as $value){
            $datetime = $value->datetime;
        }
        $pedido = Pedido::find()
            ->where(['estado' => 1, 'username' => $username])
            ->andWhere(['>=', 'datetime', $datetime])
            ->all();
        if(!empty($pedido)){
            $incluye = [];
            foreach ($pedido as $value){
                $incluye_now = Incluye::findAll(['id_pedido' => $value->id_pedido]);
                if(empty($incluye))
                    $incluye = $incluye_now;
                else
                    $incluye = array_merge($incluye, $incluye_now);
            }
            \Yii::$app->response->setStatusCode(200);
            $incluye = ArrayHelper::toArray($incluye);
            echo json_encode($incluye,JSON_PRETTY_PRINT);
            exit();
        }
        else{
            \Yii::$app->response->setStatusCode(400);
        }
    }

    public function actionCuentaMejorada(){
        $request = $_REQUEST;
        $username = $request['username'];
        $atiende_row = Atiende::find()
            ->orderBy(['datetime' => SORT_DESC])
            ->where(['username' => $username])
            ->limit(1)
            ->all();
        $datetime = '';
        foreach ($atiende_row as $value){
            $datetime = $value->datetime;
        }
        $pedidos = Pedido::find()
            ->where(['estado' => 1, 'username' => $username])
            ->andWhere(['>=', 'datetime', $datetime])
            ->all();
        if(!empty($pedidos)){
            $entregados = [];
            $preparandose = [];
            $cuenta = [];
            $precio_total = 0;

            foreach($pedidos as $pedido){
                $incluye = Incluye::findAll(['id_pedido' => $pedido->id_pedido]);
                foreach ($incluye as $value){
                    $producto = Producto::findOne(['id_producto' => $value->id_producto]);
                    if($value->cantidad_entregada == $value->cantidad){
                        if(array_key_exists($producto->nombre, $entregados)){
                            $entregados[$producto->nombre] += $value->cantidad;
                        }
                        else{
                            $entregados[$producto->nombre] = $value->cantidad;
                        }
                    }
                    else if($value->cantidad_entregada == 0){
                        if(array_key_exists($producto->nombre, $preparandose)){
                            $preparandose[$producto->nombre] += $value->cantidad;
                        }
                        else{
                            $preparandose[$producto->nombre] = $value->cantidad;
                        }
                    }
                    else{
                        if(array_key_exists($producto->nombre, $entregados)){
                            $entregados[$producto->nombre] += $value->cantidad_entregada;
                        }
                        else{
                            $entregados[$producto->nombre] = $value->cantidad_entregada;
                        }
                        if(array_key_exists($producto->nombre, $preparandose)){
                            $preparandose[$producto->nombre] += ($value->cantidad - $value->cantidad_entregada);
                        }
                        else{
                            $preparandose[$producto->nombre] = ($value->cantidad - $value->cantidad_entregada);
                        }
                    }
                    if(array_key_exists($producto->nombre, $cuenta)){
                        $cuenta[$producto->nombre]['cantidad'] += $value->cantidad;
                        $cuenta[$producto->nombre]['precio'] += $producto->precio * $value->cantidad;
                    }
                    else{
                        $tmp['cantidad'] = $value->cantidad;
                        $tmp['precio'] = $producto->precio * $value->cantidad;
                        $cuenta[$producto->nombre] = $tmp;
                    }
                    $precio_total += $producto->precio * $value->cantidad;
                }
            }
            \Yii::$app->response->setStatusCode(200);
            echo json_encode(array('entregados' => $entregados, 'preparandose' => $preparandose, 'cuenta' => $cuenta, 'precio_cuenta' => $precio_total),JSON_PRETTY_PRINT);
            exit();
        }
        else{
            \Yii::$app->response->setStatusCode(400);
        }

    }

    public function actionValoracion(){
        $request = $_REQUEST;
        $username = $request['username'];
        $recomendarias = $request['recomendarias'];
        $repetirias = $request['repetirias'];
        $ambiente = $request['ambiente'];
        $experiencia = $request['experiencia'];

        $atiende_row = Atiende::find()
            ->orderBy(['datetime' => SORT_DESC])
            ->where(['username' => $username])
            ->limit(1)
            ->all();
        foreach ($atiende_row as $value){
            $value->ambiente = $ambiente;
            $value->repetiria = $repetirias;
            $value->recomendaria = $recomendarias;
            $value->experiencia = $experiencia;
            $value->save();
        }
        \Yii::$app->response->setStatusCode(200);
        exit();
    }

    public function actionValoraciones(){
        $request = $_REQUEST;
        $username = $request['username'];
        $valoraciones = [];
        $atiende = Atiende::find()
            ->orderBy(['datetime' => SORT_DESC])
            ->where(['username' => $username])
            ->all();
        foreach ($atiende as $value){
            $tmp = [];
            $tmp['ambiente'] = $value->ambiente;
            $zona = Zona::findOne(['id' => $value->id_zona]);
            $restaurante = Restaurante::findOne(['id' => $zona->id_restaurante]);
            $tmp['restaurante'] = $restaurante->nombre;
            $tmp['datetime'] = $value->datetime;
            $tmp['id_zona'] = $value->id_zona;
            $tmp['numero'] = $value->numero;
            $valoraciones[$value->datetime] = $tmp;
        }
        echo json_encode($valoraciones,JSON_PRETTY_PRINT);
        exit();
    }

    public function actionGetValoracion(){
        $request = $_REQUEST;
        $atiende = Atiende::findOne(['username' => $request['username'], 'id_zona' => $request['id_zona'], 'numero' => $request['seccion'], 'datetime' => $request['datetime']]);
        $atiende = ArrayHelper::toArray($atiende);
        echo json_encode($atiende,JSON_PRETTY_PRINT);
        exit();
    }

    public function actionEditarPerfil(){
        $request = $_REQUEST;
        $usuario = Usuario::findOne(['username' => $request['username']]);
        $usuario->provincia = $request['provincia'];
        $usuario->anioNacimiento = $request['anioNacimiento'];
        $usuario->nombre = $request['nombre'];
        $usuario->apellidos = $request['apellidos'];
        $usuario->save();
    }

    public function actionGetPerfil(){
        $request = $_REQUEST;
        $username = $request['username'];
        $usuario = Usuario::findOne(['username' => $username]);
        $usuarios = Usuario::find()->all();
        $usernames = '';
        foreach ($usuarios as $value){
            if($value->username != $username)
                $usernames = $usernames . ',' . $value->username;
        }
        $usernames = substr($usernames, 1);
        $array = [];
        $array['usernames'] = $usernames;
        $array['perfil'] = ArrayHelper::toArray($usuario);
        echo json_encode($array,JSON_PRETTY_PRINT);
        exit();
    }

    public function actionEditarValoracion(){
        $request = $_REQUEST;
        $atiende = Atiende::findOne(['username' => $request['username'], 'id_zona' => $request['id_zona'], 'numero' => $request['seccion'], 'datetime' => $request['datetime']]);
        $atiende->recomendaria = $request['recomendarias'];
        $atiende->repetiria = $request['repetirias'];
        $atiende->experiencia = $request['experiencia'];
        $atiende->ambiente = $request['ambiente'];
        $atiende->save();
    }

    public function actionSolicitarCuenta(){
        $request = $_REQUEST;
        $username = $request['username'];
        $propina = $request['propina'];
        $precio_total = $request['precio_total'];
        $atiende_row = Atiende::find()
            ->orderBy(['datetime' => SORT_DESC])
            ->where(['username' => $username])
            ->limit(1)
            ->all();
        foreach ($atiende_row as $value){
            $value->importe = $precio_total;
            $value->propina = $propina;
            $value->estado_cuenta = 1;
            $value->save();
        }
        \Yii::$app->response->setStatusCode(200);
        exit();
    }

    public function actionProductosCuenta(){
        $request = $_REQUEST;
        $username = $request['username'];
        $atiende_row = Atiende::find()
            ->orderBy(['datetime' => SORT_DESC])
            ->where(['username' => $username])
            ->limit(1)
            ->all();
        $datetime = '';
        foreach ($atiende_row as $value){
            $datetime = $value->datetime;
        }
        $pedido = Pedido::find()
            ->where(['estado' => 1, 'username' => $username])
            ->where(['>=', 'datetime', $datetime])
            ->all();
        if(!empty($pedido)){
            $productos = [];
            foreach ($pedido as $value){
                $incluye = Incluye::findAll(['id_pedido' => $value->id_pedido]);
                foreach ($incluye as $value2){
                    $productos_now = Producto::findAll(['id_producto' => $value2->id_producto]);
                    if(empty($productos))
                        $productos = $productos_now;
                    else
                        $productos = array_merge($productos, $productos_now);
                }
            }
            \Yii::$app->response->setStatusCode(200);
            $productos = ArrayHelper::toArray($productos);
            echo json_encode($productos,JSON_PRETTY_PRINT);
            exit();
        }
        else{
            \Yii::$app->response->setStatusCode(400);
        }
    }


    public function actionIngredientesByCategoria(){
        $request = $_REQUEST;
        $id = $request['id_categoria'];
        $productos = Producto::findAll(['id_categoria' => $id]);
        $ingredientes = [];
        foreach ($productos as $value){
            $ingredientes_now = Ingrediente::findAll(['id_producto' => $value->id_producto]);
            if(empty($ingredientes) and !empty($ingredientes_now)){
                $ingredientes = $ingredientes_now;
            }
            else if(!empty($ingredientes) and !empty($ingredientes_now)){
                $ingredientes = array_merge($ingredientes, $ingredientes_now);
            }
        }

        $ingredientes = ArrayHelper::toArray($ingredientes);
        echo json_encode($ingredientes, JSON_PRETTY_PRINT);
        exit();
    }

    public function actionAlergiasByCategoria(){
        $request = $_REQUEST;
        $id = $request['id_categoria'];
        $productos = Producto::findAll(['id_categoria' => $id]);
        $alergias = [];
        foreach ($productos as $value){
            $alergias_now = Supone::findAll(['id_producto' => $value->id_producto]);
            if(empty($alergias) and !empty($alergias_now)){
                $alergias = $alergias_now;
            }
            else if(!empty($alergias) and !empty($alergias_now)){
                $alergias = array_merge($alergias, $alergias_now);
            }
        }

        $alergias = ArrayHelper::toArray($alergias);
        echo json_encode($alergias, JSON_PRETTY_PRINT);
        exit();
    }



    public function actionObtenerCategorias(){
        $request = $_REQUEST;
        $username = $request['username'];
        $atiende_row = Atiende::find()
            ->orderBy(['datetime' => SORT_DESC])
            ->where(['username' => $username])
            ->limit(1)
            ->all();
        $id_zona = '';
        foreach ($atiende_row as $value){
            $id_zona = $value->id_zona;
        }
        $zona = Zona::findOne(['id' => $id_zona]);
        $idRestaurante = $zona->id_restaurante;
        $categorías = Categoria::findAll(['id_restaurante' => $idRestaurante]);
        $categorías = ArrayHelper::toArray($categorías);
        echo json_encode($categorías,JSON_PRETTY_PRINT);
        exit();
    }

    public function actionObtenerCartaPublic(){
        $request = $_REQUEST;
        $id_restaurante = $request['id'];
        $categorias = Categoria::findAll(['id_restaurante' => $id_restaurante]);
        $productos_total = [];
        $ingredientes_total = [];
        $alergias_total = [];
        foreach ($categorias as $value){
            $productos = Producto::findAll(['id_categoria' => $value->id_categoria]);
            foreach ($productos as $value2){
                $ingredientes = Ingrediente::findAll(['id_producto' => $value2->id_producto]);
                if(empty($ingredientes_total) and !empty($ingredientes)){
                    $ingredientes_total = $ingredientes;
                }
                else if(!empty($ingredientes_total) and !empty($ingredientes)){
                    $ingredientes_total = array_merge($ingredientes_total, $ingredientes);
                }

                $alergias = Supone::findAll(['id_producto' => $value2->id_producto]);
                if(empty($alergias_total) and !empty($alergias)){
                    $alergias_total = $alergias;
                }
                else if(!empty($alergias_total) and !empty($alergias)){
                    $alergias_total = array_merge($alergias_total, $alergias);
                }
            }

            if(empty($productos_total) and !empty($productos)){
                $productos_total = $productos;
            }
            else if(!empty($productos_total) and !empty($productos)){
                $productos_total = array_merge($productos_total, $productos);
            }
        }
        $productos_total = ArrayHelper::toArray($productos_total);
        $categorias = ArrayHelper::toArray($categorias);
        $ingredientes_total = ArrayHelper::toArray($ingredientes_total);
        $alergias_total = ArrayHelper::toArray($alergias_total);
        echo json_encode(array('productos'=>$productos_total, 'categorias' => $categorias, 'ingredientes' => $ingredientes_total, 'alergias' => $alergias_total),JSON_PRETTY_PRINT);
        exit();
    }
}
