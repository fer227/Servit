<?php


namespace app\models;


use yii\base\Model;

class Propina extends Model
{
    public $propina;
    public $total;

    public function rules()
    {
        return [
            [['propina', 'total'], 'required'],
        ];
    }
}