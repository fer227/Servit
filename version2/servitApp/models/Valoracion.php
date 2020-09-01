<?php


namespace app\models;


use yii\base\Model;

class Valoracion extends Model
{
    public $experiencia;
    public $ambiente;
    public $repetirias;
    public $recomendarias;

    public function rules()
    {
        return [
            [['experiencia', 'ambiente', 'repetirias', 'recomendarias'], 'required'],
        ];
    }
}