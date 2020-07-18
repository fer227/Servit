<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\httpclient\Client;

/**
 * This is the model class for table "usuario".
 *
 * @property string $username
 * @property string $password
 * @property string $provincia
 * @property string $nombre
 * @property string $apellidos
 * @property int $anioNacimiento
 *  @property int $rol
 */
class Usuario extends Model implements \yii\web\IdentityInterface
{
    public $username;
    public $password;
    public $provincia;
    public $nombre;
    public $apellidos;
    public $anioNacimiento;
    public $rol;
    public $usernames;

    public static $users;

    /**
     * {@inheritdoc}
     */
    /*
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'provincia', 'nombre', 'apellidos', 'anioNacimiento'], 'required'],
            [['anioNacimiento'], 'integer'],
            [['rol'], 'integer'],
            [['username', 'provincia', 'nombre'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 200],
            [['apellidos'], 'string', 'max' => 40],
            [['username'], 'unique'],
        ];
    }

    public static function getUsersFromAPIREST(){
        $client = new Client();
        $response = $client->get('http://localhost/servit/web/usuarios')->send();
        $usuarios = $response->getData();
        foreach ($usuarios as $user){
            $usuarios2[$user['username']] = $user;
        }
        self::$users = $usuarios2;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Usuario',
            'password' => 'Password',
            'provincia' => 'Provincia',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'anioNacimiento' => 'Año de nacimiento',
        ];
    }

    public function getAuthKey(){
        throw new NotSupportedException();
    }

    public function getId(){
        return $this->username;
    }

    public function validateAuthKey($authKey){
        return $this->authkey === $authKey;
    }

    public static function findIdentity($id){
        //return self::findOne($id);
        Usuario::getUsersFromAPIREST();
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $id) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new yii\base\NotSupportedException();
    }

    public static function findByUsername($username){
        Usuario::getUsersFromAPIREST();
        //return self::findOne(['username' => $username]);
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public function validatePassword($password){
        return password_verify($password, $this->password);
        //return $password == $this->password;
    }
}
