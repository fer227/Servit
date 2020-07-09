<?php


namespace app\models;


use yii\base\Model;

class formPropietario extends Model
{
    public $nombre;
    public $apellidos;
    public $username;
    public $nombre_restaurante;
    public $password;
    public $correo;
    public $usernames;

    public function rules()
    {
        return [
            [['nombre', 'apellidos', 'username', 'nombre_restaurante', 'correo', 'password'], 'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'username' => 'Usuario',
            'nombre_restaurante' => 'Nombre del restaurante',
            'password' => 'Contraseña',
            'correo' => 'Correo electrónico'
        ];
    }
}