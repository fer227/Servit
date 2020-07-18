<?php


namespace app\models;


use yii\base\Model;

class formUnete extends Model
{
    public $nombre;
    public $apellidos;
    public $mensaje;
    public $telefono;
    public $correo;

    public function rules()
    {
        return [
            [['nombre', 'correo', 'apellidos', 'telefono', 'mensaje'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'mensaje' => 'Mensaje',
            'telefono' => 'Teléfono',
            'correo' => 'Correo electrónico'
        ];
    }
}