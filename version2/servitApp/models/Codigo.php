<?php


namespace app\models;


use yii\base\Model;

class Codigo extends Model
{
    public $codigo;
    public function rules()
    {
        return [
            ['codigo', 'required'],
        ];
    }
}