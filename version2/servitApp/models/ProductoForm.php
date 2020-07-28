<?php


namespace app\models;


use yii\base\Model;

class ProductoForm extends Model
{
    public $cantidad;
    public $id;


    public function rules()
    {
        return [
            [['cantidad', 'id'], 'required'],
        ];
    }
}