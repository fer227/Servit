<?php


namespace app\models;


use yii\base\Model;

class editarPropietario extends Model
{
    public $nombre;
    public $apellidos;
    public $username;
    public $password;
    public $old_username;
    public $correo;
    public $usernames;

    public function rules()
    {
        return [
            [['nombre', 'apellidos', 'username', 'correo','old_username'], 'required'],
            [['password'], 'string', 'max' => 100]
        ];
    }
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'username' => 'Usuario',
            'password' => 'Contraseña',
            'correo' => 'Correo electrónico'
        ];
    }
}