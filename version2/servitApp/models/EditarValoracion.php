<?php


namespace app\models;


use yii\base\Model;

class EditarValoracion extends Model
{
    public $experiencia;
    public $ambiente;
    public $repetirias;
    public $recomendarias;
    public $username;
    public $datetime;
    public $id_zona;
    public $seccion;

    public function rules()
    {
        return [
            [['experiencia', 'ambiente', 'repetirias', 'recomendarias', 'username', 'seccion', 'id_zona', 'datetime'], 'required'],
        ];
    }
}