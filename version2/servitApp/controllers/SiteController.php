<?php

namespace app\controllers;

use app\models\EditarValoracion;
use app\models\Perfil;
use app\models\ProductoForm;
use app\models\Propina;
use app\models\Valoracion;
use yii\httpclient\Client;
use app\models\Codigo;
use app\models\Usuario;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site/login');
        }
        else if (Yii::$app->request->get('id')){
            $request = Yii::$app->request;
            $id = $request->get('id');
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurants/'. $id)->send();
            $restaurante = $response->getContent();
            $restaurante = json_decode($restaurante);
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurant/etiquetas', ['id' => $id])->send();
            $etiquetas = $response->getContent();
            $etiquetas = json_decode($etiquetas);
            $hora_apertura = substr($restaurante->hora_apertura, 0, -3);
            $hora_cierre = substr($restaurante->hora_cierre, 0, -3);

            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurant/obtener-carta-public', ['id' => $id])->send();
            $contenido = $response->getContent();
            $contenido = json_decode($contenido);
            $productos = $contenido->productos;
            $categorias = $contenido->categorias;
            $ingredientes = $contenido->ingredientes;

            $alergias = $contenido->alergias;
            return $this->render('restaurante',[
                'restaurante' => $restaurante,
                'etiquetas' => $etiquetas,
                'hora_apertura' => $hora_apertura,
                'hora_cierre' => $hora_cierre,
                'productos' => $productos,
                'categorias' => $categorias,
                'ingredientes' => $ingredientes,
            ]);
        }
        else{
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurants')->send();
            $restaurantes = $response->getContent();
            $restaurantes = json_decode($restaurantes);
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurant/etiquetas')->send();
            $etiquetas = $response->getContent();
            $etiquetas = json_decode($etiquetas);
            return $this->render('index', [
                'restaurantes' => $restaurantes,
                'etiquetas' => $etiquetas
            ]);
        }
    }

    public function actionCodigo(){
        $model = new Codigo();

        if ($model->load(Yii::$app->request->post())) {
            $codigo = explode(".", $model->codigo);
            if(sizeof($codigo) != 3){
                return $this->render('codigo', [
                    'model' => $model,
                    'mensaje' => 'Esa mesa no está disponible o no existe'
                ]);
            }
            $restaurante = $codigo[0];
            $zona = $codigo[1];
            $seccion = $codigo[2];
            $client = new Client();
            /*+
            $response = $client->get('http://localhost/servit/web/restaurant/codigo', [
                'restaurante' => $restaurante,
                'zona' => $zona,
                'seccion' => $seccion,
                'username' => \Yii::$app->user->identity->username
            ])->send();
            */
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('http://localhost/servit/web/restaurant/codigo')
                ->setData(['restaurante' => $restaurante, 'zona' => $zona, 'seccion' => $seccion, 'username' => \Yii::$app->user->identity->username])
                ->send();
            $status = $response->getStatusCode();
            if($status == 200){
                return $this->redirect('menu');
            }
            else{
                return $this->render('codigo', [
                    'model' => $model,
                    'mensaje' => 'Esa mesa no está disponible o no existe'
                ]);
            }
        }

        return $this->render('codigo', [
            'model' => $model,
            'mensaje' => 'null'
        ]);
    }

    public function actionValoraciones(){
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/restaurant/valoraciones', ['username' => \Yii::$app->user->identity->username])->send();
        $contenido = $response->getContent();
        $valoraciones = json_decode($contenido);
        return $this->render('valoraciones', ['valoraciones' => $valoraciones]);
    }

    public function actionEditarValoracion(){
        $model = new EditarValoracion();

        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            //$response = $client->get('http://localhost/servit/web/restaurant/editar-valoracion', ['username' => \Yii::$app->user->identity->username, 'id_zona' => $model->id_zona, 'experiencia' => $model->experiencia, 'ambiente' => $model->ambiente, 'repetirias' => $model->repetirias, 'recomendarias' => $model->recomendarias, 'seccion' => $model->seccion, 'datetime' => $model->datetime])->send();
            $response = $client->createRequest()
                ->setMethod('PUT')
                ->setUrl('http://localhost/servit/web/restaurant/editar-valoracion')
                ->setData(['username' => \Yii::$app->user->identity->username, 'id_zona' => $model->id_zona, 'experiencia' => $model->experiencia, 'ambiente' => $model->ambiente, 'repetirias' => $model->repetirias, 'recomendarias' => $model->recomendarias, 'seccion' => $model->seccion, 'datetime' => $model->datetime])
                ->send();
            return $this->redirect('valoraciones');
        }

        $request = Yii::$app->request;
        $id_zona = $request->get('id_zona');
        $seccion = $request->get('seccion');
        $datetime = $request->get('datetime');
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/restaurant/get-valoracion', ['username' => \Yii::$app->user->identity->username, 'id_zona' => $id_zona, 'seccion' => $seccion, 'datetime' => $datetime])->send();
        $contenido = $response->getContent();
        $valoracion = json_decode($contenido);
        $model->ambiente = $valoracion->ambiente;
        $model->experiencia = $valoracion->experiencia;
        $model->recomendarias = $valoracion->recomendaria;
        $model->repetirias = $valoracion->repetiria;
        $model->datetime = $valoracion->datetime;
        $model->username = $valoracion->username;
        $model->id_zona = $valoracion->id_zona;
        $model->seccion = $valoracion->numero;
        $opciones = [];
        $opciones['0'] = 'No';
        $opciones['1'] = 'Tal vez';
        $opciones['2'] = 'Sí';
        return $this->render('editarValoracion', ['model' => $model, 'opciones' => $opciones]);
    }

    public function actionPerfil(){
        $model = new Perfil();

        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            //$response = $client->get('http://localhost/servit/web/restaurant/editar-perfil', ['username' => \Yii::$app->user->identity->username, 'nombre' => $model->nombre, 'apellidos' => $model->apellidos, 'anioNacimiento' => $model->anioNacimiento, 'provincia' => $model->provincia])->send();
            $response = $client->createRequest()
                ->setMethod('PUT')
                ->setUrl('http://localhost/servit/web/restaurant/editar-perfil')
                ->setData(['username' => \Yii::$app->user->identity->username, 'nombre' => $model->nombre, 'apellidos' => $model->apellidos, 'anioNacimiento' => $model->anioNacimiento, 'provincia' => $model->provincia])
                ->send();
            return $this->redirect('index');
        }
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/restaurant/get-perfil', ['username' => \Yii::$app->user->identity->username])->send();
        $contenido = $response->getContent();
        $contenido = json_decode($contenido);
        $perfil = $contenido->perfil;
        $usernames = $contenido->usernames;
        return $this->render('perfil', ['model' => $model, 'perfil' => $perfil, 'usernames' => $usernames]);
    }

    public function actionMenu($pestania = 1){
        $model_propina = new Propina();
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/restaurant/pedido-actual', ['username' => \Yii::$app->user->identity->username])->send();
        $tienePedidoActual = false;
        if($response->getStatusCode() == '200'){
            $tienePedidoActual = true;
            $contenido = $response->getContent();
            $contenido = json_decode($contenido);
            $productos_pedido = $contenido->productos;
            $incluye = $contenido->incluye;
        }
        if($tienePedidoActual){
            $precio_total = 0;
            foreach ($productos_pedido as $value){
                foreach ($incluye as $value2){
                    if($value->id_producto == $value2->id_producto){
                        $precio_total += $value->precio * $value2->cantidad;
                        break;
                    }
                }
            }
        }
        $tieneCuenta = false;
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/restaurant/cuenta-mejorada', ['username' => \Yii::$app->user->identity->username])->send();
        $entregados = [];
        $preparandose = [];
        $cuenta = [];
        $precio_cuenta = 0;
        if($response->getStatusCode() == '200'){
            $tieneCuenta = true;
            $contenido = $response->getContent();
            $contenido = json_decode($contenido);
            $entregados = $contenido->entregados;
            $preparandose = $contenido->preparandose;
            $cuenta = $contenido->cuenta;
            $precio_cuenta = $contenido->precio_cuenta;
        }
        $productos = [];
        if (Yii::$app->request->get('id_categoria')){
            $request = Yii::$app->request;
            $id = $request->get('id_categoria');
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurant/productos-by-categoria', ['id_categoria' => $id])->send();
            $productos = $response->getContent();
            $productos = json_decode($productos);
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurant/ingredientes-by-categoria', ['id_categoria' => $id])->send();
            $ingredientes = $response->getContent();
            $ingredientes = json_decode($ingredientes);
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurant/alergias-by-categoria', ['id_categoria' => $id])->send();
            $alergias = $response->getContent();
            $alergias = json_decode($alergias);
            $this->layout = 'extendedNav';
            $categorias = [];
            $model = new ProductoForm();
            if ($tienePedidoActual){

                return $this->render('menu', ['categorias' => $categorias, 'productos' => $productos, 'ingredientes' => $ingredientes, 'alergias' => $alergias, 'model' => $model, 'productos_pedido' => $productos_pedido, 'incluye' => $incluye, 'model_propina' => $model_propina, 'tienePedidoActual' => $tienePedidoActual, 'precio_total' => $precio_total, 'pestania' => $pestania, 'tieneCuenta' => $tieneCuenta, 'precio_cuenta' => $precio_cuenta, 'entregados' => $entregados, 'preparandose' => $preparandose, 'cuenta' => $cuenta]);
            }
            else
                return $this->render('menu', ['categorias' => $categorias, 'productos' => $productos, 'ingredientes' => $ingredientes, 'alergias' => $alergias, 'model' => $model, 'tienePedidoActual' => $tienePedidoActual, 'pestania' => $pestania, 'model_propina' => $model_propina, 'tieneCuenta' => $tieneCuenta,'precio_cuenta' => $precio_cuenta, 'entregados' => $entregados, 'preparandose' => $preparandose, 'cuenta' => $cuenta]);
        }
        else{
            $client = new Client();
            $response = $client->get('http://localhost/servit/web/restaurant/obtener-categorias', ['username' => \Yii::$app->user->identity->username])->send();
            $categorias = $response->getContent();
            $categorias = json_decode($categorias);
            $this->layout = 'extendedNav';
            if($tienePedidoActual)
                return $this->render('menu', ['categorias' => $categorias,'productos' => $productos, 'productos_pedido' => $productos_pedido, 'incluye' => $incluye, 'precio_cuenta' => $precio_cuenta , 'tienePedidoActual' => $tienePedidoActual, 'precio_total' => $precio_total, 'model_propina' => $model_propina, 'pestania' => $pestania, 'tieneCuenta' => $tieneCuenta, 'entregados' => $entregados, 'preparandose' => $preparandose, 'cuenta' => $cuenta]);

            else
                return $this->render('menu', ['categorias' => $categorias, 'productos' => $productos, 'tienePedidoActual' => $tienePedidoActual, 'pestania' => $pestania, 'precio_cuenta' => $precio_cuenta , 'tieneCuenta' => $tieneCuenta, 'model_propina' => $model_propina, 'productos' => $productos , 'entregados' => $entregados, 'preparandose' => $preparandose, 'cuenta' => $cuenta]);
        }
    }

    public function actionAddPedido(){
        $model = new ProductoForm();
        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            //$response = $client->get('http://localhost/servit/web/restaurant/add-pedido', ['id_producto' => $model->id, 'cantidad' => $model->cantidad, 'username' => \Yii::$app->user->identity->username])->send();
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('http://localhost/servit/web/restaurant/add-pedido')
                ->setData(['id_producto' => $model->id, 'cantidad' => $model->cantidad, 'username' => \Yii::$app->user->identity->username])
                ->send();
            return $this->redirect(['menu', 'pestania' => '2']);
        }
        else{
            print_r("error");
            die();
        }
    }

    public function actionSolicitarCuenta(){
        $model = new Propina();
        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            //$response = $client->get('http://localhost/servit/web/restaurant/solicitar-cuenta', ['propina' => $model->propina, 'precio_total' => $model->total, 'username' => \Yii::$app->user->identity->username])->send();
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('http://localhost/servit/web/restaurant/solicitar-cuenta')
                ->setData(['propina' => $model->propina, 'precio_total' => $model->total, 'username' => \Yii::$app->user->identity->username])
                ->send();
            if($model->propina > 0){
                $mensaje = "¡Gracias por la propina!";
                return $this->render('agradecimiento', ['mensaje' => $mensaje]);
            }
            else{
                $mensaje = "¡Gracias por la visita!";
                return $this->render('agradecimiento', ['mensaje' => $mensaje]);
            }
        }
        else{
            print_r("error");
            die();
        }
    }

    public function actionEliminarProducto(){
        if (Yii::$app->request->get('id_producto')) {
            $request = Yii::$app->request;
            $id = $request->get('id_producto');
            $client = new Client();
            //$response = $client->get('http://localhost/servit/web/restaurant/eliminar-producto', ['id_producto' => $id, 'username' => \Yii::$app->user->identity->username])->send();
            $response = $client->createRequest()
                ->setMethod('DELETE')
                ->setUrl('http://localhost/servit/web/restaurant/eliminar-producto')
                ->setData(['id_producto' => $id, 'username' => \Yii::$app->user->identity->username])
                ->send();
            return $this->redirect(['menu', 'pestania' => '2']);
        }
    }

    public function actionConfirmarPedido(){
        $client = new Client();
        //$response = $client->get('http://localhost/servit/web/restaurant/confirmar-pedido', ['username' => \Yii::$app->user->identity->username])->send();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('http://localhost/servit/web/restaurant/confirmar-pedido')
            ->setData(['username' => \Yii::$app->user->identity->username])
            ->send();
        return $this->redirect(['menu', 'pestania' => '3']);
    }

    public function actionValoracion(){
        $model = new Valoracion();
        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            //$response = $client->get('http://localhost/servit/web/restaurant/valoracion', ['username' => \Yii::$app->user->identity->username, 'experiencia' => $model->experiencia, 'ambiente' => $model->ambiente, 'repetirias' => $model->repetirias, 'recomendarias' => $model->recomendarias])->send();
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('http://localhost/servit/web/restaurant/valoracion')
                ->setData(['username' => \Yii::$app->user->identity->username, 'experiencia' => $model->experiencia, 'ambiente' => $model->ambiente, 'repetirias' => $model->repetirias, 'recomendarias' => $model->recomendarias])
                ->send();
            return $this->redirect('index');
        }
        $opciones['0'] = 'No';
        $opciones['1'] = 'Tal vez';
        $opciones['2'] = 'Sí';
        return $this->render('valoracion', [
            'model' => $model,
            'opciones' => $opciones
        ]);
    }

    public function actionRegister()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post())) {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl('http://localhost/servit/web/usuarios')
                ->setData(['username' => $model->username,
                    'password' => password_hash($model->password, PASSWORD_DEFAULT),
                    'provincia' => $model->provincia,
                    'nombre' => $model->nombre,
                    'anioNacimiento' => $model->anioNacimiento,
                    'rol' => '0',
                    'apellidos' => $model->apellidos])
                ->setOptions([
                    'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
                ])
                ->send();

            \Yii::$app->user->login($model);
            return $this->redirect('index');

        }

        $client = new Client();
        $response = $client->get('http://localhost/servit/web/usuarios')->send();
        $usuarios = $response->getContent();
        $usuarios = json_decode($usuarios);
        //$usuarios = $usuarios->data;
        $usernames = '';
        foreach ($usuarios as $value){
            $usernames = $usernames . ',' . $value->username;
        }
        $usernames = substr($usernames, 1);
        return $this->render('register', [
            'model' => $model,
            'usernames' => $usernames
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $usuario = Usuario::findByUsername($model->username);
            if($usuario->rol == 0)
                return $this->redirect('index');
            else
                return $this->redirect(array('camarero/index'));
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
