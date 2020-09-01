<?php


namespace app\models;


use yii\base\Model;

class Perfil extends Model
{
    public $nombre;
    public $apellidos;
    public $anioNacimiento;
    public $provincia;
    public $usernames;

    public function rules()
    {
        return [
            [['nombre', 'apellidos', 'anioNacimiento', 'provincia'], 'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'anioNacimiento' => 'Año de nacimiento',
            'provincia' => 'Provincia'
        ];
    }
}