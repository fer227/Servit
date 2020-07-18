<?php


namespace app\models;


use yii\base\Model;

class formRestaurante extends Model
{
    public $nombre;
    public $direccion;
    public $telefono;
    public $horario;
    public $provincia;
    public $localidad;
    public $etiquetas;
    public $imagen;

    public function rules()
    {
        return [
            [['nombre', 'direccion', 'telefono', 'horario', 'provincia', 'localidad', 'etiquetas', 'imagen'], 'required'],
        ];
    }
}