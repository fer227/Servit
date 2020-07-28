<?php

namespace app\controllers;
use app\models\ComandaJSON;
use app\models\Empleado;
use yii\helpers\Json;
use Yii;
use yii\httpclient\Client;

class CamareroController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $this->layout = 'camareroNav';
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/seccion/asignadas', [
            'username' => \Yii::$app->user->identity->username
        ])->send();
        $contenido = $response->getContent();
        $contenido = json_decode($contenido);
        $secciones = $contenido->secciones;
        $zonas = $contenido->zonas;
        $zona_array = $contenido->zona_array;
        $zona_array = json_decode(json_encode($zona_array), true);
        return $this->render('index',['secciones' => $secciones, 'zonas' => $zonas, 'zona_array' => $zona_array]);
    }

    public function actionPagado(){
        $request = Yii::$app->request;
        $id_zona = $request->get('zona');
        $seccion = $request->get('seccion');
        $client = new Client();
        //$response = $client->get('http://localhost/servit/web/seccion/pagado', ['id_zona' => $id_zona, 'seccion' => $seccion])->send();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('http://localhost/servit/web/seccion/pagado')
            ->setData(['id_zona' => $id_zona, 'seccion' => $seccion])
            ->send();
        return $this->redirect('index');
    }

    public function actionEntregados(){
        $this->layout = 'camareroNav';
        $request = Yii::$app->request;
        $id_zona = $request->get('zona');
        $seccion = $request->get('seccion');
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/seccion/entregados', ['id_zona' => $id_zona, 'seccion' => $seccion])->send();
        $contenido = $response->getContent();
        $entregados = json_decode($contenido);
        return $this->render('entregados', ['entregados' => $entregados]);
    }

    public function actionComanda(){
        $model = new ComandaJSON();

        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            $json = json_decode($model->json);
            $ubicacion = [];
            $ubicacion['seccion'] = $model->seccion;
            $ubicacion['zona'] = $model->zona;
            $json_final = [];
            $json_final['ubicacion'] = $ubicacion;
            $json_final['entregados'] = $json;
            $json_str = json_encode($json_final);
            $response = $client->createRequest()
                ->addHeaders(['content-type' => 'application/json'])
                ->setMethod('GET')
                ->setUrl('http://localhost/servit/web/seccion/confirmar-entregados')
                ->setContent($json_str)
                ->send();
            return $this->redirect('index');
        }

        $this->layout = 'camareroNav';
        $request = Yii::$app->request;
        $id_zona = $request->get('zona');
        $seccion = $request->get('seccion');
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/seccion/comanda', ['id_zona' => $id_zona, 'seccion' => $seccion])->send();
        $contenido = $response->getContent();
        $contenido = json_decode($contenido);
        $incluye = $contenido->incluye;
        $productos = $contenido->productos;
        $pedidos = $contenido->pedidos;
        foreach ($pedidos as $pedido){
            $array = explode(" ", $pedido->datetime);
            $str = $array[1];
            $str = substr($array[1], 0, -3);
            $pedido->datetime = $str;
        }
        return $this->render('comanda',['productos' => $productos, 'incluye' => $incluye, 'model' => $model, 'zona' => $id_zona, 'seccion' => $seccion, 'pedidos' => $pedidos]);
    }
}
