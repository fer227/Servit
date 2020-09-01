<?php


namespace app\models;


use yii\base\Model;

class formZona extends Model
{
    public $nombre;
    public $num_secciones;
    public $es_barra;
    public $id_zona;

    public function rules()
    {
        return [
            [['num_secciones', 'es_barra', 'nombre'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'es_barra' => 'Selecciona una opción',
            'num_secciones' => 'Secciones',
        ];
    }
}