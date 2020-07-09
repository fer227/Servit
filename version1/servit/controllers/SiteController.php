<?php

namespace app\controllers;

use app\models\Alergia;
use app\models\cambiarContraseniaForm;
use app\models\Categoria;
use app\models\Clasifica;
use app\models\ComponenteMenu;
use app\models\editarEmpleadoForm;
use app\models\editarInformacionForm;
use app\models\editarMenuForm;
use app\models\editarPropietario;
use app\models\Empleado;
use app\models\Etiqueta;
use app\models\formProducto;
use app\models\formPropietario;
use app\models\formRestaurante;
use app\models\formUnete;
use app\models\formZona;
use app\models\Ingrediente;
use app\models\Menu;
use app\models\nuevoMenu;
use app\models\Perfil;
use app\models\Seccion;
use app\models\Supone;
use app\models\Usuario;
use app\models\Zona;
use yii\httpclient\Client;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Propietario;
use app\models\Restaurante;
use app\models\Producto;
use yii\data\Pagination;
use yii\web\UploadedFile;

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
            return $this->render('index');
        }
        elseif(\Yii::$app->user->identity->username == 'administrador'){
            return $this->redirect('administrador');
        }
        else{
            $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
            $restaurante = Restaurante::findOne(['id' => $propietario->restaurante]);
            return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
        }
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
            $propietario = Propietario::findByUsername($model->username);
            if($propietario->username == 'administrador'){
                return $this->redirect('administrador');
            }
            elseif($propietario->restaurante == null) {
                return $this->redirect(array('site/menu-propietario'));
            }
            else{
                //$restaurante = Restaurante::findOne(['id' => $propietario->restaurante]);
                //return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
                return $this->redirect(array('site/menu-propietario'));
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionAdministrador(){
        $propietarios = Propietario::find()->all();
        $restaurantes = [];

        foreach($propietarios as $value){
            if ($value->restaurante != null){
                $tmp = Restaurante::findOne($value->restaurante);
                $restaurantes[$value->username] = $tmp->nombre;
            }
        }
        $this->layout = 'admin';
        return $this->render('admin', ['propietarios' => $propietarios, 'restaurantes' => $restaurantes]);
    }

    public function actionFormPropietario()
    {
        $model = new formPropietario();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $propietario_new = new Propietario();
                $propietario_new->username = $model->username;
                $propietario_new->nombre = $model->nombre;
                $propietario_new->apellidos = $model->apellidos;
                $propietario_new->password = password_hash($model->password, PASSWORD_DEFAULT);
                $propietario_new->visible = 1;
                $propietario_new->correo = $model->correo;

                if($propietario_new->save()){
                    $restaurante = new Restaurante();
                    $restaurante->nombre = $model->nombre_restaurante;
                    $restaurante->save();
                    $propietario_new->restaurante = $restaurante->id;
                    $propietario_new->save();
                    $this->layout = 'admin';
                    $contenido = '<p>Hola ' . $propietario_new->nombre . ', bienvenido a Servit. <p><br>' .
                        'Ya puedes iniciar sesión con tu usuario: <b>'. $propietario_new->username . '</b> y tu contraseña: <b>' . $model->password . '</b> <br> ' .
                    'Recuerda que puedes cambiar tanto tu usuario como contraseña desde tu perfil. Gracias por confiar en nosotros.';
                    $message = Yii::$app->mailer->compose();
                    $message->setFrom('servitcontacto@gmail.com')
                        ->setTo($propietario_new->correo)
                        ->setSubject('Alta en Servit')
                        ->setHtmlBody($contenido)
                        ->send();
                    return $this->redirect('administrador');
                }
            }
        }
        $propietarios = Propietario::find()->all();
        $usernames = '';
        foreach ($propietarios as $value){
            $usernames = $usernames . ',' . $value->username;
        }
        $usernames = substr($usernames, 1);
        $this->layout = 'admin';
        return $this->render('formPropietario', [
            'model' => $model,
            'usernames' => $usernames
        ]);
    }

    public function actionEditarPropietario()
    {
        $model = new editarPropietario();
        $this->layout = 'admin';
        if ($model->load(Yii::$app->request->post())) {
            $propietario = Propietario::findOne($model->old_username);
            $cambio_user = false;
            if($propietario->username != $model->username)
                $cambio_user = true;
            $propietario->username = $model->username;
            $propietario->nombre = $model->nombre;
            $propietario->apellidos = $model->apellidos;
            $propietario->correo = $model->correo;
            $cambio_password = false;
            if(!empty($_POST['editarPropietario']['password'])){
                $cambio_password = true;
                $propietario->password = password_hash($model->password, PASSWORD_DEFAULT);
            }

            if($cambio_user and $cambio_password){
                $contenido = '<p>Hola ' . $propietario->nombre . '<p><br>' .
                    'Tu usuario ha sido modificado a: <b>'. $model->username . '</b>' .
                    'Tu contraseña ha sido modificada a: <b>'. $model->password . '</b>'. 'Gracias por confiar en nosotros.';
                $message = Yii::$app->mailer->compose();
                $message->setFrom('servitcontacto@gmail.com')
                    ->setTo($propietario->correo)
                    ->setSubject('Cambio en tu usuario y contraseña')
                    ->setHtmlBody($contenido)
                    ->send();
            }
            elseif ($cambio_user){
                $contenido = '<p>Hola ' . $propietario->nombre . '<p><br>' .
                    'Tu usuario ha sido modificado a: <b>'. $model->username . '</b>' .
                     'Gracias por confiar en nosotros.';
                $message = Yii::$app->mailer->compose();
                $message->setFrom('servitcontacto@gmail.com')
                    ->setTo($propietario->correo)
                    ->setSubject('Cambio en tu usuario')
                    ->setHtmlBody($contenido)
                    ->send();
            }
            elseif($cambio_password){
                $contenido = '<p>Hola ' . $propietario->nombre . '.<p><br>' .
                    'Tu contraseña ha sido modificada a: <b>'. $model->password . '</b>'. '<br>Gracias por confiar en nosotros.';
                $message = Yii::$app->mailer->compose();
                $message->setFrom('servitcontacto@gmail.com')
                    ->setTo($propietario->correo)
                    ->setSubject('Cambio en tu contraseña')
                    ->setHtmlBody($contenido)
                    ->send();
            }

            $propietario->save();
            return $this->redirect('administrador');
        }

        $request = Yii::$app->request;
        $username = $request->get('propietario');
        $propietario = Propietario::findOne($username);

        $propietarios = Propietario::find()->all();
        $usernames = '';
        foreach ($propietarios as $value){
            if($value->username != $username)
                $usernames = $usernames . ',' . $value->username;
        }
        $usernames = substr($usernames, 1);
        return $this->render('editarPropietario',[
            'model' => $model,
            'propietario' => $propietario,
            'usernames' => $usernames
        ]);
    }

    public function actionEditarInformacion()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $restaurante = Restaurante::findOne($propietario->restaurante);
        $model = new editarInformacionForm();
        $etiquetas_actuales= Clasifica::findAll(['id_restaurante' => $propietario->restaurante]);
        $etiquetas_bd = Etiqueta::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                $hora_ap = $_POST['editarInformacionForm']['hora_apertura'];
                $hora_ap = $hora_ap . ':00';

                $hora_cie = $_POST['editarInformacionForm']['hora_cierre'];
                $hora_cie = $hora_cie . ':00';

                $restaurante->updateAttributes(['direccion' => $model->direccion, 'hora_apertura' => $hora_ap, 'hora_cierre' => $hora_cie, 'provincia' => $model->provincia, 'telefono' =>  $model->telefono, 'localidad' => $model->localidad]);

                $nuevas_etiquetas = array();
                foreach ($_POST['editarInformacionForm']['etiquetas'] as $value){
                    array_push($nuevas_etiquetas, $value);
                    if(!in_array($value, $etiquetas_actuales)){
                        $etiqueta = new Clasifica();
                        $etiqueta->nombre = $value;
                        $etiqueta->id_restaurante = $propietario->restaurante;
                        $etiqueta->save();
                    }
                }
                foreach ($etiquetas_actuales as $value){
                    if(!in_array($value->nombre, $nuevas_etiquetas)){
                        Clasifica::deleteAll(['nombre' => $value, 'id_restaurante' => $propietario->restaurante]);
                    }
                }

                if($_POST['editarInformacionForm']['new_nombre'] == $restaurante->nombre){
                    if(!empty($_FILES)) {
                        $restaurante->imagen = UploadedFile::getInstance($model, 'imagen');
                        if ($restaurante->upload()) {
                            return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
                        }
                    }
                }
                else{
                    if(empty($_FILES)){
                        $antigua_ruta = pathinfo($restaurante->ruta);
                        $extension = $antigua_ruta['extension'];
                        $nueva_ruta = 'uploads/' . $model->new_nombre . '.' . $extension;
                        rename(\Yii::getAlias('@webroot') . '/' .$restaurante->ruta, \Yii::getAlias('@webroot') . '/' . $nueva_ruta);
                        if ($restaurante->updateAttributes(['nombre' => $model->new_nombre, 'ruta' => $nueva_ruta])) {
                            return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
                        }
                    }
                    else{
                        $restaurante->imagen = UploadedFile::getInstance($model, 'imagen');
                        if($restaurante->upload()){
                            $nueva_ruta = 'uploads/' . $model->new_nombre . '.' . $restaurante->imagen->extension;
                            rename(\Yii::getAlias('@webroot') . '/' .$restaurante->ruta, \Yii::getAlias('@webroot') . '/' . $nueva_ruta);
                            if ($restaurante->updateAttributes(['nombre' => $model->new_nombre, 'ruta' => $nueva_ruta])) {
                                return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
                            }
                        }
                    }
                }
                return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
            }
        }

        $etiquetas = [];
        foreach ($etiquetas_bd as $value){
            $etiquetas[$value->nombre] = $value->nombre;
        }

        $checkedList = array();
        foreach ($etiquetas_actuales as $item){
            array_push($checkedList, $item->nombre);
        }
        $restaurante->hora_apertura = substr($restaurante->hora_apertura, 0, -3);
        $restaurante->hora_cierre = substr($restaurante->hora_cierre, 0, -3);
        $model->etiquetas = $checkedList;
        return $this->render('editarInformacion', [
            'model' => $model,
            'restaurante' => $restaurante,
            'etiquetas' => $etiquetas
        ]);
    }

    public function actionEditarMesa()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $model = new editarMesa();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                // form inputs are valid, do something here
                $model->plazas = $_POST['editarMesa']['plazas'];
                if($_POST['editarMesa']['empleado'] != 'null')
                    $model->empleado = $_POST['editarMesa']['empleado'];
                else
                    $model->empleado = null;
                $model->reservada = $_POST['editarMesa']['reservada'];
                $mesa = Mesa::findOne(['restaurante' => $propietario->restaurante, 'numero' => $_POST['editarMesa']['numero']]);
                if ($mesa->updateAttributes(['plazas' => $model->plazas, 'empleado' => $model->empleado, 'reservada' => $model->reservada])) {
                    $mesas = Mesa::findAll(['restaurante' => $propietario->restaurante]);
                    return $this->render('mesas', ['mesas' => $mesas]);
                }
            }
        }

        $request = Yii::$app->request;
        $numeroMesa = $request->get('mesa');
        $mesa = Mesa::findOne(['restaurante' => $propietario->restaurante, 'numero' => $numeroMesa]);
        $listaEmpleados = Empleado::findAll(['restaurante' => $propietario->restaurante]);
        $empleados['null'] = 'Ninguno';
        foreach($listaEmpleados as $key=>$value){
            $empleados[$value->usuario] = $value->usuario;
        }
        $model->empleado = $mesa->empleado;
        $model->reservada = $mesa->reservada;
        return $this->render('editarMesa',[
            'model' => $model,
            'mesa' => $mesa,
            'empleados' => $empleados
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $request = Yii::$app->request;
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionInformacion()
    {
        return $this->render('informacion');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionMenuPropietario()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $restaurante = Restaurante::findOne(['id' => $propietario->restaurante]);
        if($propietario->username == 'administrador')
            return $this->redirect('administrador');
        else if($propietario->visible == 1)
            return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
        else{
            $this->layout = 'admin';
            return $this->render('sinAcceso');
        }
    }

    public function actionPerfil(){
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);
        $restaurante = Restaurante::findOne(['id' => $propietario->restaurante]);
        $model = new Perfil();

        if ($model->load(Yii::$app->request->post())) {
            if($propietario->updateAttributes(['apellidos' => $model->apellidos, 'nombre' => $model->nombre, 'username' => $model->username, 'correo' => $model->correo])){
                \Yii::$app->user->login($propietario);
                $restaurante = Restaurante::findOne($propietario->restaurante);
                return $this->redirect(['menu-propietario', 'nombre' => $restaurante->nombre]);
            }
        }

        $propietarios = Propietario::find()->all();
        $usernames = '';
        foreach ($propietarios as $value){
            if($value->username != $propietario->username)
                $usernames = $usernames . ',' . $value->username;
        }
        $usernames = substr($usernames, 1);
        return $this->render('perfil', [
            'model' => $model,
            'propietario' => $propietario,
            'usernames' => $usernames
        ]);
    }

    public function actionCambiarContrasenia(){
        $model = new cambiarContraseniaForm();
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);
        $restaurante = Restaurante::findOne(['id' => $propietario->restaurante]);

        if ($model->load(Yii::$app->request->post())){
            $model->old_password = $_POST['cambiarContraseniaForm']['old_password'];
            if(password_verify($model->old_password, $propietario->password)){
                $model->new_password = password_hash($_POST['cambiarContraseniaForm']['new_password'], PASSWORD_DEFAULT);
                if($propietario->updateAttributes(['password' => $model->new_password])){
                    return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
                }
            }
        }

        return $this->render('cambiarContrasenia', [
            'model' => $model,
        ]);
    }

    public function actionRestaurantes()
    {
        if (Yii::$app->request->get('id')){
            $request = Yii::$app->request;
            $id = $request->get('id');
            $restaurante = Restaurante::findOne($id);
            $etiquetas = Clasifica::findAll(['id_restaurante' => $id]);
            $hora_apertura = substr($restaurante->hora_apertura, 0, -3);
            $hora_cierre = substr($restaurante->hora_cierre, 0, -3);
            return $this->render('restaurante', ['restaurante' => $restaurante, 'etiquetas' => $etiquetas, 'hora_apertura' => $hora_apertura, 'hora_cierre' => $hora_cierre]);
        }
        else{
            $restaurantes = Restaurante::find()
                ->innerJoin('propietario', 'restaurante.id=propietario.restaurante')
                ->where(['propietario.visible' => 1]);
            $countQuery = clone $restaurantes;
            $pages = new Pagination(['pageSize' => 2, 'totalCount' => $countQuery->count()] );
            $modelo = $restaurantes->offset($pages->offset)->limit($pages->limit)->all();

            $etiquetas = Clasifica::find()->all();
            return $this->render('restaurantes', ['restaurantes' => $modelo, 'pages' => $pages, 'etiquetas' => $etiquetas]);
        }
    }

    public function actionVerCarta(){
        $request = Yii::$app->request;
        $id_restaurante = $request->get('id');
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
        return $this->render('verCarta',[
           'productos' => $productos_total,
           'categorias' => $categorias,
           'ingredientes' => $ingredientes_total,
           'alergias' => $alergias_total
        ]);
    }

    public function actionEditarProducto(){
        $model = new formProducto();
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            $producto = Producto::findOne(['id_producto' => $_POST['formProducto']['id_producto']]);
            $producto->updateAttributes(['nombre' => $model->nombre, 'precio' => $model->precio, 'id_categoria' => $model->id_categoria]);

            $alergias_actuales = Supone::findAll(['id_producto' => $producto->id_producto]);
            $nuevas_alergias = array();
            if(!empty($_POST['formProducto']['alergias'])){
                foreach ($_POST['formProducto']['alergias'] as $value){
                    array_push($nuevas_alergias, $value);
                    if(!in_array($value, $alergias_actuales)){
                        $alergia = new Supone();
                        $alergia->id_producto = $producto->id_producto;
                        $alergia->id_alergia = $value;
                        $alergia->save();
                    }
                }
                foreach ($alergias_actuales as $value){
                    if(!in_array($value->id_alergia, $nuevas_alergias)){
                        Supone::deleteAll(['id_alergia' => $value->id_alergia, 'id_producto' => $producto->id_producto]);
                    }
                }
            }
            else{
                Supone::deleteAll(['id_producto' => $producto->id_producto]);
            }

            $array = json_decode($_POST['formProducto']['chips']);
            foreach($array as $key=>$value){
                $consulta = Ingrediente::findAll(['id_producto' => $producto->id_producto, 'nombre' => $value->tag]);
                if(empty($consulta)){
                    $ingrediente = new Ingrediente();
                    $ingrediente->nombre = $value->tag;
                    $ingrediente->id_producto = $producto->id_producto;
                    $ingrediente->save();
                }
            }
            $ingredientes_before = Ingrediente::findAll(['id_producto' => $producto->id_producto]);
            foreach($ingredientes_before as $key=>$value){
                $existe = false;
                foreach($array as $key2=>$value2){
                    if($value->nombre == $value2->tag){
                        $existe = true;
                        break;
                    }
                }
                if(!$existe){
                    Ingrediente::deleteAll(['id_ingrediente' => $value->id_ingrediente]);
                }
            }

            $productos = Producto::findAll(['id_categoria' => $producto->id_categoria]);
            $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
            $tmp = 0;
            $ingredientes = [];
            foreach ($productos as $value) {
                if($tmp != 0){
                    $ingredientes = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                    $tmp += 1;
                }
                else {
                    $ingredientes_tmp = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                    $ingredientes = array_merge($ingredientes, $ingredientes_tmp);
                }
            }
            return $this->render('menuProductos', ['categoriaSeleccionada' => $producto->id_categoria, 'ingredientes' => $ingredientes ,'categorias' => $categorias, 'productos' => $productos]);
        }

        $request = Yii::$app->request;
        $id_producto = $request->get('id_producto');
        $producto = Producto::findOne($id_producto);

        $alergias = [];
        $alergias_bd = Alergia::find()->all();
        foreach ($alergias_bd as $value){
            $alergias[$value->id] = $value->nombre;
        }

        $checkedList = array();
        $alergias_actuales = Supone::findAll(['id_producto' => $id_producto]);
        foreach ($alergias_actuales as $item){
            array_push($checkedList, $item->id_alergia);
        }
        $model->alergias = $checkedList;
        $model->id_categoria = $producto->id_categoria;
        $categoriasdb = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
        foreach($categoriasdb as $key=>$value){
            $categorias[$value->id_categoria] = $value->nombre;
        }
        $ingredientes = Ingrediente::findAll(['id_producto' => $id_producto]);
        if(!empty($ingredientes)){
            $string = "";
            foreach($ingredientes as $key=>$value){
                $string .= $value->nombre;
                $string .= ',';
            }
            $string = rtrim($string,',');
        }
        else{
            $string = "null";
        }
        return $this->render('editarProducto',[
            'model' => $model,
            'producto' => $producto,
            'categorias' => $categorias,
            'ingredientes' => $string,
            'alergias' => $alergias
        ]);
    }

    public function actionEditarMenu(){
        $model = new editarMenuForm();
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            $producto = Producto::findOne(['nombre' => $_POST['editarProductoForm']['old_name'], 'restaurante' => $propietario->restaurante]);
            $model->new_name = $_POST['editarProductoForm']['new_name'];
            $model->new_precio = $_POST['editarProductoForm']['new_precio'];
            $model->new_descripcion = $_POST['editarProductoForm']['new_descripcion'];
            $model->new_categoria = $_POST['editarProductoForm']['new_categoria'];
            if ($producto->updateAttributes(['nombre' => $model->new_name, 'descripcion' => $model->new_descripcion, 'precio' => $model->new_precio, 'categoria' => $model->new_categoria])) {
                $productos = Producto::findAll(['categoria' => $producto->categoria, 'restaurante' => $producto->restaurante]);
                $categorias = Categoria::findAll(['restaurante' => $propietario->restaurante]);
                return $this->render('menuProductos', ['categoriaSeleccionada' => $producto->categoria, 'categorias' => $categorias, 'productos' => $productos]);
            }
        }

        $request = Yii::$app->request;
        $nombreMenu = $request->get('menu');
        $menu = Menu::findOne(['nombre' => $nombreMenu, 'restaurante' => $propietario->restaurante]);
        $model->categoria1 = $menu->categoria1;
        $model->categoria2 = $menu->categoria2;
        $model->categoria3 = $menu->categoria3;
        $model->categoria4 = $menu->categoria4;
        $categoriasdb = Categoria::findAll(['restaurante' => $propietario->restaurante]);
        $categorias['null'] = '----';
        foreach($categoriasdb as $key=>$value){
            $categorias[$value->nombre] = $value->nombre;
        }
        return $this->render('editarMenu',[
            'model' => $model,
            'menu' => $menu,
            'categorias' => $categorias
        ]);
    }

    public function actionVisibilizarCategoria(){
        $request = Yii::$app->request;
        $id_ategoria= $request->get('id_categoria');
        $categoria = Categoria::findOne($id_ategoria);
        $categoria->updateAttributes(['visible' => 1]);
        return $this->redirect('menu-categorias');
    }

    public function actionInvisibilizarCategoria(){
        $request = Yii::$app->request;
        $id_ategoria= $request->get('id_categoria');
        $categoria = Categoria::findOne($id_ategoria);
        $categoria->updateAttributes(['visible' => 0]);
        return $this->redirect('menu-categorias');
    }

    public function actionVisibilizarPropietario(){
        $request = Yii::$app->request;
        $username = $request->get('username');
        $propietario = Propietario::findOne($username);
        $propietario->updateAttributes(['visible' => 1]);
        return $this->redirect('administrador');
    }

    public function actionInvisibilizarPropietario(){
        $request = Yii::$app->request;
        $username = $request->get('username');
        $propietario = Propietario::findOne($username);
        $propietario->updateAttributes(['visible' => 0]);
        return $this->redirect('administrador');
    }

    public function actionVisibilizarZona(){
        $request = Yii::$app->request;
        $id_zona= $request->get('id_zona');
        $zona = Zona::findOne($id_zona);
        $zona->updateAttributes(['visible' => 1]);
        return $this->redirect('zonas');
    }

    public function actionInvisibilizarZona(){
        $request = Yii::$app->request;
        $id_zona= $request->get('id_zona');
        $zona = Zona::findOne($id_zona);
        $zona->updateAttributes(['visible' => 0]);
        return $this->redirect('zonas');
    }

    public function actionVisibilizarSeccion(){
        $request = Yii::$app->request;
        $id_zona= $request->get('id_zona');
        $numero= $request->get('numero');
        $seccion = Seccion::findOne(['id_zona' => $id_zona, 'numero' => $numero]);
        $seccion->updateAttributes(['visible' => 1]);
        return $this->redirect(['secciones', 'id_zona' => $id_zona]);
    }

    public function actionInvisibilizarSeccion(){
        $request = Yii::$app->request;
        $id_zona= $request->get('id_zona');
        $numero= $request->get('numero');
        $seccion = Seccion::findOne(['id_zona' => $id_zona, 'numero' => $numero]);
        $seccion->updateAttributes(['visible' => 0]);
        return $this->redirect(['secciones', 'id_zona' => $id_zona]);
    }

    public function actionVisibilizarEmpleado(){
        $request = Yii::$app->request;
        $usuario= $request->get('usuario');
        $empleado = Empleado::findOne($usuario);
        $empleado->updateAttributes(['visible' => 1]);
        return $this->redirect('empleados');
    }

    public function actionInvisibilizarEmpleado(){
        $request = Yii::$app->request;
        $usuario= $request->get('usuario');
        $empleado = Empleado::findOne($usuario);
        $empleado->updateAttributes(['visible' => 0]);
        return $this->redirect('empleados');
    }

    public function actionVisibilizarProducto(){
        $request = Yii::$app->request;
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);
        $id_producto= $request->get('id_producto');
        $producto = Producto::findOne($id_producto);
        $producto->updateAttributes(['visible' => 1]);
        $productos = Producto::findAll(['id_categoria' => $producto->id_categoria]);
        $tmp = 0;
        $ingredientes = [];
        foreach ($productos as $value) {
            if($tmp != 0){
                $ingredientes = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                $tmp += 1;
            }
            else {
                $ingredientes_tmp = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                $ingredientes = array_merge($ingredientes, $ingredientes_tmp);
            }
        }
        $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
        return $this->render('menuProductos', ['productos' => $productos, 'categoriaSeleccionada' => $producto->id_categoria, 'categorias' => $categorias, 'ingredientes' => $ingredientes]);
    }

    public function actionInvisibilizarProducto(){
        $request = Yii::$app->request;
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);
        $id_producto= $request->get('id_producto');
        $producto = Producto::findOne($id_producto);
        $producto->updateAttributes(['visible' => 0]);
        $productos = Producto::findAll(['id_categoria' => $producto->id_categoria]);
        $tmp = 0;
        $ingredientes = [];
        foreach ($productos as $value) {
            if($tmp != 0){
                $ingredientes = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                $tmp += 1;
            }
            else {
                $ingredientes_tmp = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                $ingredientes = array_merge($ingredientes, $ingredientes_tmp);
            }
        }
        $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
        return $this->render('menuProductos', ['productos' => $productos, 'categoriaSeleccionada' => $producto->id_categoria, 'categorias' => $categorias, 'ingredientes' => $ingredientes]);
    }

    public function actionEditarCategoria(){
        $model = new Categoria();
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            $categoria = Categoria::findOne(['id_categoria' => $_POST['Categoria']['id_categoria'], 'id_restaurante' => $propietario->restaurante]);
            $model->nombre = $_POST['Categoria']['nombre'];
            if ($categoria->updateAttributes(['nombre' => $model->nombre])) {
                $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
                $canDelete = [];
                foreach ($categorias as $value){
                    $consulta = Producto::findAll(['id_categoria' => $value->id_categoria]);
                    if(empty($consulta))
                        $canDelete[$value->id_categoria] = true;
                    else
                        $canDelete[$value->id_categoria] = false;
                }

                return $this->render('menuCategorias', ['categorias' => $categorias, 'canDelete' => $canDelete]);
            }
        }

        $request = Yii::$app->request;
        $id_ategoria= $request->get('id_categoria');
        $categoria = Categoria::findOne($id_ategoria);
        return $this->render('editarCategoria',[
            'model' => $model,
            'categoria' => $categoria
        ]);
    }

    public function actionEditarSeccion(){
        $model = new Seccion();
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            $seccion = Seccion::findOne(['id_zona' => $_POST['Seccion']['id_zona'], 'numero' => $_POST['Seccion']['numero']]);
            if($model->usuario_empleado == 'null'){
                $model->usuario_empleado = null;
            }

            if ($seccion->updateAttributes(['plazas' => $model->plazas, 'estado' => $model->estado, 'usuario_empleado' => $model->usuario_empleado])) {
                return $this->redirect(['secciones', 'id_zona' => $seccion->id_zona]);
            }
        }

        $request = Yii::$app->request;
        $id_zona= $request->get('id_zona');
        $numero= $request->get('numero');
        $seccion = Seccion::findOne(['id_zona' => $id_zona, 'numero' => $numero]);
        $opciones = [];
        $opciones['0'] = 'Libre';
        $opciones['3'] = 'Reservada';
        $model->estado = '0';
        $empleados_bd =  Empleado::find()->where(['id_restaurante' => $propietario->restaurante])->all();
        $empleados = [];
        $empleados['null'] = "Sin asignar";
        foreach ($empleados_bd as $value){
            if($value->rol == 'Camarero'){
                $str = $value->nombre . " " . $value->apellido1 . ' ' . $value->apellido2 . ', DNI: ' . $value->dni;
                $empleados[$value->usuario] = $str;
            }
        }
        $model->usuario_empleado = $seccion->usuario_empleado;
        $codigo = $propietario->restaurante . '.' . $seccion->id_zona . '.' . $seccion->numero;
        return $this->render('editarSeccion',[
            'model' => $model,
            'seccion' => $seccion,
            'opciones' => $opciones,
            'codigo' => $codigo,
            'empleados' => $empleados
        ]);
    }

    public function actionEditarEmpleado(){
        $model = new editarEmpleadoForm();
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);
        if ($model->load(Yii::$app->request->post())) {
            $empleado = Empleado::findOne(substr($model->old_dni, 0, -1));
            $model->user = substr($model->dni, 0, -1);
            $model->password = substr($model->apellido1, 0, 3) . $model->apellido2 . $propietario->restaurante;
            $model->password = password_hash($model->password, PASSWORD_DEFAULT);

            $usuarioApp = Usuario::findOne(substr($model->old_dni, 0, -1));
            $usuarioApp->updateAttributes(['username' => $model->user, 'rol' => $model->rol, 'password' => $model->password, 'nombre' => $model->nombre, 'apellidos' => $model->apellido1 . " " . $model->apellido2]);

            if($empleado->updateAttributes(['nombre' => $model->nombre, 'apellido1' => $model->apellido1, 'apellido2' => $model->apellido2, 'password' => $model->password, 'usuario' => $model->user, 'rol' => $model->rol, 'dni' => $model->dni])) {
                $empleados = Empleado::findAll(['id_restaurante' => $propietario->restaurante]);
                $passwords = [];
                foreach ($empleados as $value){
                    $passwords[$value->usuario] = substr($value->apellido1, 0, 3) . $value->apellido2 . $value->id_restaurante;
                }
                return $this->render('empleados', ['empleados' => $empleados, 'passwords' => $passwords]);
            }
        }

        $request = Yii::$app->request;
        $usuarioEmpleado = $request->get('empleado');
        $empleado = Empleado::findOne($usuarioEmpleado);
        $roles = [];
        $roles['Camarero'] = 'Camarero';
        $roles['Cocinero'] = 'Cocinero';
        $model->rol = $empleado->rol;
        $secciones =  Seccion::findAll(['usuario_empleado' => $empleado->usuario]);
        $editable = true;
        if(!empty($secciones))
            $editable = false;

        $secciones = Seccion::find()
            ->innerJoin('zona', 'zona.id=seccion.id_zona')
            ->where(['seccion.usuario_empleado' => $empleado->usuario])
            ->all();

        $zonas = Zona::findAll(['id_restaurante' => $propietario->restaurante]);
        $badges = [];
        foreach ($zonas as $value){
            $badges[$value->id] = sizeof(Seccion::findAll(['id_zona' => $value->id, 'usuario_empleado' => $empleado->usuario]));
        }

        return $this->render('editarEmpleado',[
            'model' => $model,
            'empleado' => $empleado,
            'roles' => $roles,
            'editable' => $editable,
            'zonas' => $zonas,
            'secciones' => $secciones,
            'badges' => $badges
        ]);
    }

    public function actionMenuProductos($id_categoria = null){
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);

        if($id_categoria != null){
            //$request = Yii::$app->request;
            //$categoria = $request->get('categoria');
            $productos = Producto::findAll(['id_categoria' => $id_categoria]);
            $tmp = 0;
            $ingredientes = [];
            foreach ($productos as $value) {
                if($tmp != 0){
                    $ingredientes = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                    if(!empty($ingredientes))
                        $tmp += 1;
                }
                else {
                    $ingredientes_tmp = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                    if(!empty($ingredientes_tmp))
                        $ingredientes = array_merge($ingredientes, $ingredientes_tmp);
                }
            }
            $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
            return $this->render('menuProductos', ['productos' => $productos, 'categoriaSeleccionada' => $id_categoria, 'categorias' => $categorias, 'ingredientes' => $ingredientes]);
        }
        $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
        return $this->render('menuProductos', ['categoriaSeleccionada' => null, 'categorias' => $categorias, 'productos' => null]);
    }

    public function actionCrearRestaurante()
    {
        $model = new formRestaurante();
        $restaurante = new Restaurante();

        if ($model->load(Yii::$app->request->post())) {
                // form inputs are valid, do something here
                $restaurante->imagen = UploadedFile::getInstance($model, 'imagen');
                $restaurante->nombre = $_POST['formRestaurante']['nombre'];
                $restaurante->direccion = $_POST['formRestaurante']['direccion'];
                $restaurante->telefono = $_POST['formRestaurante']['telefono'];
                $restaurante->localidad = $_POST['formRestaurante']['localidad'];
                $restaurante->provincia = $_POST['formRestaurante']['provincia'];
                $restaurante->horario = $_POST['formRestaurante']['horario'];

                if($restaurante->upload()) {
                    if ($restaurante->save(false)) {
                        foreach ($_POST['formRestaurante']['etiquetas'] as $value) {
                            $etiqueta = new Etiqueta();
                            $etiqueta->restaurante = $restaurante->id;
                            $etiqueta->etiqueta = $value;
                            $etiqueta->save();
                        }
                        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
                        $propietario->restaurante = $restaurante->id;
                        if ($propietario->save()){
                            return $this->render('menuPropietario', ['nombre' => $restaurante->nombre]);
                        }
                    }
                }
        }

        foreach ($this->etiquetas as $value){
            $etiquetas[$value] = $value;
        }

        return $this->render('crearRestaurante', [
            'model' => $model,
            'etiquetas' => $etiquetas
        ]);
    }

    public function actionFormProducto()
    {
        $model = new formProducto();
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $producto = new Producto();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $producto->nombre = $_POST['formProducto']['nombre'];
                $producto->id_categoria = $_POST['formProducto']['id_categoria'];
                $producto->precio = $_POST['formProducto']['precio'];
                $producto->id_restaurante = $propietario->restaurante;
                $producto->visible = 1;
                if($producto->save()){
                    if(!empty($_POST['formProducto']['alergias'])) {
                        foreach ($_POST['formProducto']['alergias'] as $value) {
                            $alergia = new Supone();
                            $alergia->id_producto = $producto->id_producto;
                            $alergia->id_alergia = $value;
                            $alergia->save();
                        }

                        $array = json_decode($_POST['formProducto']['chips']);
                        foreach ($array as $key => $value) {
                            $ingrediente = new Ingrediente();
                            $ingrediente->nombre = $value->tag;
                            $ingrediente->id_producto = $producto->id_producto;
                            $ingrediente->save();
                        }
                    }
                    $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
                    $productos = Producto::findAll(['id_categoria' => $model->id_categoria, 'id_restaurante' => $propietario->restaurante]);
                    $tmp = 0;
                    $ingredientes = [];
                    foreach ($productos as $value) {
                        if($tmp != 0){
                            $ingredientes = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                            $tmp += 1;
                        }
                        else {
                            $ingredientes_tmp = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                            $ingredientes = array_merge($ingredientes, $ingredientes_tmp);
                        }
                    }
                    return $this->render('menuProductos', ['categoriaSeleccionada' => $model->id_categoria, 'ingredientes' => $ingredientes ,'categorias' => $categorias, 'productos' => $productos]);
                }
            }
        }
        $categoriasdb = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
        foreach($categoriasdb as $key=>$value){
            $categorias[$value->id_categoria] = $value->nombre;
        }
        $alergias_bd = Alergia::find()->all();
        $alergias = [];
        foreach ($alergias_bd as $value){
            $alergias[$value->id] = $value->nombre;
        }
        return $this->render('formProducto', [
            'model' => $model,
            'categorias' => $categorias,
            'alergias' => $alergias
        ]);
    }

    public function actionFormCategoria()
    {
        $model = new Categoria();
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->nombre = $_POST['Categoria']['nombre'];
                $model->id_restaurante = $propietario->restaurante;
                $model->visible = 1;
                if($model->save()){
                    return $this->redirect('menu-categorias');
                }
            }
        }

        return $this->render('formCategoria', [
            'model' => $model,
        ]);
    }

    public function actionFormMenu()
    {
        $model = new nuevoMenu();
        $menu = new Menu();
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $menu->nombre = $_POST['nuevoMenu']['nombre'];
                $menu->id_restaurante = $propietario->restaurante;
                $menu->save();
                $id_menu = $menu->id_menu;
                if($_POST['nuevoMenu']['componente1'] != 'null'){
                    $componente = new ComponenteMenu();
                    $componente->id_menu = $id_menu;
                    $componente->nombre = $_POST['nuevoMenu']['componente1'];
                    $componente->save();
                }

                if($_POST['nuevoMenu']['componente2'] != 'null'){
                    $componente = new ComponenteMenu();
                    $componente->id_menu = $id_menu;
                    $componente->nombre = $_POST['nuevoMenu']['componente2'];
                    $componente->save();
                }

                if($_POST['nuevoMenu']['componente3'] != 'null'){
                    $componente = new ComponenteMenu();
                    $componente->id_menu = $id_menu;
                    $componente->nombre = $_POST['nuevoMenu']['componente3'];
                    $componente->save();
                }

                if($_POST['nuevoMenu']['componente4'] != 'null'){
                    $componente = new ComponenteMenu();
                    $componente->id_menu = $id_menu;
                    $componente->nombre = $_POST['nuevoMenu']['componente4'];
                    $componente->save();
                }

                $componentes = ComponenteMenu::findAll(['id_menu' => $id_menu]);
                $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
                $productos = Producto::findAll(['id_restaurante' => $propietario->restaurante]);
                return $this->render('formMenu2', ['componentes'=>$componentes,'categorias' => $categorias, 'productos' => $productos]);
            }
        }

        return $this->render('formMenu', [
            'model' => $model,
        ]);
    }

    public function actionFormMenu2(){

    }

    public function actionMenuCategorias()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
        $canDelete = [];
        foreach ($categorias as $value){
            $consulta = Producto::findAll(['id_categoria' => $value->id_categoria]);
            if(empty($consulta))
                $canDelete[$value->id_categoria] = true;
            else
                $canDelete[$value->id_categoria] = false;
        }

        return $this->render('menuCategorias', [
            'categorias' => $categorias,
            'canDelete' => $canDelete
        ]);
    }

    public function actionMenuMenus()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $menus = Menu::findAll(['id_restaurante' => $propietario->restaurante]);

        return $this->render('menuMenus', [
            'menus' => $menus
        ]);
    }

    public function actionFormMesa()
    {
        $model = new nuevaMesa();
        $mesa = new Mesa();
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $mesa->numero = $_POST['nuevaMesa']['numero'];
                $mesa->plazas = $_POST['nuevaMesa']['plazas'];
                if($_POST['nuevaMesa']['empleado'] != 'null')
                    $mesa->empleado = $_POST['nuevaMesa']['empleado'];
                else
                    $mesa->empleado = null;
                $mesa->reservada = 0;
                $mesa->restaurante = $propietario->restaurante;
                if ($mesa->save()) {
                    $mesas = Mesa::findAll(['restaurante' => $propietario->restaurante]);
                    return $this->render('mesas', ['mesas' => $mesas]);
                }
            }
        }

        $model->empleado = 'null';
        $listaEmpleados = Empleado::findAll(['restaurante' => $propietario->restaurante]);
        $empleados['null'] = 'Ninguno';
        foreach($listaEmpleados as $key=>$value){
            $empleados[$value->usuario] = $value->usuario;
        }
        return $this->render('formMesa', [
            'model' => $model,
            'empleados' => $empleados
        ]);
    }


    public function actionFormEmpleado()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $model = new Empleado();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->id_restaurante = $propietario->restaurante;
                $model->usuario = substr($model->dni, 0, -1);
                $model->password = substr($model->apellido1, 0, 3) . $model->apellido2 . $model->id_restaurante;
                $model->password = password_hash($model->password, PASSWORD_DEFAULT);
                $model->visible = 1;
                $client = new Client();
                $response = $client->get('http://localhost/servit/web/usuario/empleado', [
                    'nombre' => $model->nombre,
                    'apellidos' => $model->apellido1 . " " . $model->apellido2,
                    'username' => $model->usuario,
                    'anioNacimiento' => '0',
                    'provincia' => '-',
                    'rol' => '1',
                    'password' => $model->password
                ])->send();
                $status = $response->getStatusCode();
                if($status == 200){
                    if($model->save()) {
                        $empleados = Empleado::findAll(['id_restaurante' => $propietario->restaurante]);
                        $passwords = [];
                        foreach ($empleados as $value){
                            $passwords[$value->usuario] = substr($value->apellido1, 0, 3) . $value->apellido2 . $value->id_restaurante;
                        }
                        return $this->redirect('empleados');
                    }
                }
            }
        }
        $roles = [];
        $roles['Camarero'] = 'Camarero';
        $roles['Cocinero'] = 'Cocinero';

        return $this->render('formEmpleado', [
            'model' => $model,
            'roles' => $roles
        ]);
    }

    public function actionRegister()
    {
        $model = new formUnete();

        if ($model->load(Yii::$app->request->post())) {
            $contenido = "<p>Persona que quiere contactar: <b>" . $model->nombre . " " . $model->apellidos . "</b></p><br>"
            . "<p>Correo electrónico: <b>" . $model->correo . "</b></p><br>"
            . "<p>Teléfono: <b>" . $model->telefono . "</b></p><br>"
            . "<p>Su mensaje: " . $model->mensaje . "</p>";
            $message = Yii::$app->mailer->compose();
            $message->setFrom('servitcontacto@gmail.com')
                ->setTo('servitcontacto@gmail.com')
                ->setSubject($model->nombre. " " . $model->apellidos .' quiere contactar')
                ->setHtmlBody($contenido)
                ->send();
            return $this->redirect('index');
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionEmpleados()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $empleados = Empleado::findAll(['id_restaurante' => $propietario->restaurante]);
        $passwords = [];
        $secciones_asignadas = [];
        foreach ($empleados as $value){
            $passwords[$value->usuario] = mb_substr($value->apellido1, 0, 3) . $value->apellido2 . $value->id_restaurante;
            $secciones_asignadas[$value->usuario] = sizeof(Seccion::findAll(['usuario_empleado' => $value->usuario]));
        }
        return $this->render('empleados', ['empleados' => $empleados, 'passwords' => $passwords, 'secciones_asignadas' => $secciones_asignadas]);
    }

    public function actionMesas()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $mesas = Mesa::findAll(['restaurante' => $propietario->restaurante]);
        return $this->render('mesas', ['mesas' => $mesas]);
    }

    public function actionZonas()
    {
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $zonas = Zona::findAll(['id_restaurante' => $propietario->restaurante]);
        $editable = [];
        foreach($zonas as $value){
            $secciones = Seccion::findAll(['id_zona' => $value->id]);
            $seccion_editable = true;
            foreach($secciones as $value2){
                if($value2->estado != '0'){
                    $seccion_editable = false;
                    break;
                }
            }
            if($seccion_editable)
                $editable[$value->id] = true;
            else
                $editable[$value->id] = false;
        }
        return $this->render('zonas', ['zonas' => $zonas, 'editable' => $editable]);
    }

    public function actionSecciones($id_zona = null){
        $propietario = Propietario::findOne(\Yii::$app->user->identity->username);
        $zonas = Zona::findAll(['id_restaurante' => $propietario->restaurante]);
        $zonas_sin_asignar = '';
        foreach ($zonas as $value){
            $secciones = Seccion::findAll(['id_zona' => $value->id]);
            foreach($secciones as $value2){
                if($value2->usuario_empleado == null){
                    if($zonas_sin_asignar == '')
                        $zonas_sin_asignar = $value->nombre;
                    else
                        $zonas_sin_asignar = $zonas_sin_asignar . ", " . $value->nombre;
                    break;
                }
            }
        }
        if($id_zona != null){
            //$request = Yii::$app->request;
            //$categoria = $request->get('categoria');
            $secciones = Seccion::findAll(['id_zona' => $id_zona]);
            $codigos = [];
            $asignaciones = [];
            foreach ($secciones as $value){
                $c = $propietario->restaurante . '.' . $value->id_zona . '.' . $value->numero;
                $codigos[$value->numero] = $c;
                if($value->usuario_empleado != null) {
                    $empleado = Empleado::findOne($value->usuario_empleado);
                    $str = $empleado->nombre . ' ' . $empleado->apellido1;
                    $asignaciones[$value->numero] = $str;
                }
                else
                    $asignaciones[$value->numero] = 'Sin asignar';
            }
            return $this->render('secciones', ['secciones' => $secciones, 'zonaSeleccionada' => $id_zona, 'zonas' => $zonas, 'codigos' => $codigos, 'asignaciones' => $asignaciones, 'zonas_sin_asignar' => $zonas_sin_asignar]);
        }
        return $this->render('secciones', ['zonaSeleccionada' => null, 'zonas' => $zonas, 'secciones' => null, 'zonas_sin_asignar' => $zonas_sin_asignar]);
    }

    public function actionFormZona()
    {
        $model = new formZona();
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $zona = new Zona();
                $zona->es_barra = $model->es_barra;
                $zona->nombre = $model->nombre;
                $zona->id_restaurante = $propietario->restaurante;
                $zona->num_secciones = $model->num_secciones;
                $zona->visible = 1;
                if($zona->save()){
                    $secciones = Seccion::findAll(['id_zona' => $zona->id]);
                    $nsecciones = 1;
                    if(!empty($secciones)){
                        $nsecciones = count($secciones);
                    }
                    $tope = $nsecciones + $zona->num_secciones;
                    for ($x = $nsecciones; $x < $tope; $x++) {
                        $seccion = new Seccion();
                        $seccion->id_zona = $zona->id;
                        $seccion->numero = $x;
                        $seccion->estado = 0;
                        $seccion->visible = 1;
                        $seccion->save();
                    }

                    $zonas = Zona::findAll(['id_restaurante' => $propietario->restaurante]);
                    //return $this->render('zonas', ['zonas' => $zonas]);
                    return $this->redirect(['secciones', 'id_zona' => $zona->id]);
                }
            }
        }

        $opciones = [];
        $opciones['1'] = 'Barra';
        $opciones['0'] = 'Zona';
        return $this->render('formZona', [
            'model' => $model,
            'opciones' => $opciones
        ]);
    }

    public function actionEditarZona(){
        $model = new formZona();
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $zona = Zona::findOne($_POST['formZona']['id_zona']);
                $zona->nombre = $model->nombre;

                if($zona->num_secciones != $model->num_secciones){
                    if ($zona->num_secciones > $model->num_secciones){
                        $num_secciones = $zona->num_secciones;
                        $diferencia = $zona->num_secciones - $model->num_secciones;
                        for ($x = 1; $x <= $diferencia; $x++) {
                            Seccion::deleteAll(['numero' => $num_secciones, 'id_zona' => $zona->id]);
                            $num_secciones--;
                        }
                        $zona->num_secciones = $model->num_secciones;
                    }
                    else{
                        $diferencia = $model->num_secciones - $zona->num_secciones;
                        for ($x = 1; $x <= $diferencia; $x++) {
                            $seccion = new Seccion();
                            $seccion->estado = 0;
                            $seccion->id_zona = $zona->id;
                            $seccion->numero = $zona->num_secciones + $x;
                            $seccion->visible = 1;
                            $seccion->save();
                        }
                        $zona->num_secciones = $model->num_secciones;
                    }
                    $zona->save();
                }
                $request = Yii::$app->request;
                $zona_seleccionada = $zona->id;
                return $this->redirect(['secciones', 'id_zona' => $zona_seleccionada]);
            }
        }

        $request = Yii::$app->request;
        $id_zona = $request->get('id_zona');
        $zona = Zona::findOne($id_zona);
        $model->es_barra = $zona->es_barra;
        $opciones = [];
        $opciones['1'] = 'Barra';
        $opciones['0'] = 'Zona';
        return $this->render('editarZona', [
            'model' => $model,
            'zona' => $zona,
            'opciones' => $opciones
        ]);
    }

    public function actionEliminarZona(){
        $request = Yii::$app->request;
        $id_zona = $request->get('id_zona');
        $zona = Empleado::findOne($id_zona);
        Seccion::deleteAll(['id_zona' => $id_zona]);
        Zona::deleteAll(['id' => $id_zona]);
        return $this->redirect('zonas');
    }

    public function actionEliminarEmpleado(){
        $request = Yii::$app->request;
        $usuarioEmpleado = $request->get('empleado');
        $empleado = Empleado::findOne($usuarioEmpleado);
        $restaurante = $empleado->restaurante;
        Usuario::deleteAll(['username' => $usuarioEmpleado]);

        if(Empleado::deleteAll(['usuario' => $usuarioEmpleado])) {
            $empleados = Empleado::findAll(['id_restaurante' => $restaurante]);
            $passwords = [];
            foreach ($empleados as $value){
                $passwords[$value->usuario] = substr($value->apellido1, 0, 3) . $value->apellido2 . $value->id_restaurante;
            }
            return $this->render('empleados', [
                'empleados' => $empleados,
                'passwords' => $passwords
            ]);
        }
    }

    public function actionEliminarProducto(){
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $request = Yii::$app->request;
        $id_producto = $request->get('id_producto');
        $producto = Producto::findOne(['id_producto' => $id_producto, 'id_restaurante' => $propietario->restaurante]);
        $id_categoria = $producto->id_categoria;

        if(Producto::deleteAll(['id_producto' => $producto->id_producto, 'id_restaurante' => $propietario->restaurante])) {
            $productos = Producto::findAll(['id_categoria' => $id_categoria, 'id_restaurante' => $propietario->restaurante]);
            $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
            $tmp = 0;
            $ingredientes = [];
            foreach ($productos as $value) {
                if($tmp != 0){
                    $ingredientes = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                    $tmp += 1;
                }
                else {
                    $ingredientes_tmp = Ingrediente::findAll(['id_producto' => $value->id_producto]);
                    $ingredientes = array_merge($ingredientes, $ingredientes_tmp);
                }
            }
            return $this->render('menuProductos', ['categoriaSeleccionada' => $id_categoria, 'categorias' => $categorias, 'ingredientes' => $ingredientes ,'productos' => $productos]);
        }
    }

    public function actionEliminarCategoria(){
        $request = Yii::$app->request;
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);
        $id_categoria = $request->get('id_categoria');
        $restaurante = $propietario->restaurante;

        if(Categoria::deleteAll(['id_categoria' => $id_categoria])) {
            $categorias = Categoria::findAll(['id_restaurante' => $propietario->restaurante]);
            $canDelete = [];
            foreach ($categorias as $value){
                $consulta = Producto::findAll(['id_categoria' => $value->id_categoria]);
                if(empty($consulta))
                    $canDelete[$value->id_categoria] = true;
                else
                    $canDelete[$value->id_categoria] = false;
            }

            return $this->render('menuCategorias', ['categorias' => $categorias, 'canDelete' => $canDelete]);
        }
    }

    public function actionEliminarMesa(){
        $request = Yii::$app->request;
        $numeroMesa = $request->get('mesa');
        $propietario = Propietario::findByUsername(\Yii::$app->user->identity->username);

        if(Mesa::deleteAll(['numero' => $numeroMesa, 'restaurante' => $propietario->restaurante])) {
            $mesas = Mesa::findAll(['restaurante' => $propietario->restaurante]);
            return $this->render('mesas', ['mesas' => $mesas]);        }
    }
}
