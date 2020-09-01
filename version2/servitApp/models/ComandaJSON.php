<?php


namespace app\models;


use yii\base\Model;

class ComandaJSON extends Model
{
    public $json;
    public $zona;
    public $seccion;

    public function rules()
    {
        return [
            [['json', 'zona', 'seccion'], 'required'],
        ];
    }
}