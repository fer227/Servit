<?php


namespace app\models;


use yii\base\Model;

class Perfil extends Model
{
    public $nombre;
    public $apellidos;
    public $username;
    public $correo;
    public $usernames;

    public function rules()
    {
        return [
            [['nombre', 'apellidos', 'username', 'correo'], 'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'username' => 'Usuario',
            'correo' => 'Correo electrónico'
        ];
    }
}