<?php


namespace app\models;


use yii\base\Model;

class editarEmpleadoForm extends Model
{
    public $user;
    public $nombre;
    public $apellido1;
    public $apellido2;
    public $dni;
    public $password;
    public $rol;
    public $old_dni;

    public function rules()
    {
        return [
            [['user', 'rol', 'old_dni', 'nombre', 'apellido1', 'apellido2', 'dni','password'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user' => 'Usuario',
            'nombre' => 'Nombre',
            'dni' => 'DNI',
            'apellido1' => 'Primer apellido',
            'apellido2' => 'Segundo apellido',
            'password' => 'Contraseña',
        ];
    }
}