<?php


namespace app\models;


use yii\base\Model;

class nuevoMenu extends Model
{
    public $nombre;
    public $componente1;
    public $componente2;
    public $componente3;
    public $componente4;

    public function rules()
    {
        return [
            [['nombre', 'componente1', 'componente2'], 'required'],
        ];
    }
}