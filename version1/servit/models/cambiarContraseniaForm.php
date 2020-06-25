<?php


namespace app\models;


use yii\base\Model;

class cambiarContraseniaForm extends Model
{
    public $old_password;
    public $new_password;

    public function rules()
    {
        return [
            [['old_password', 'new_password'], 'required'],
        ];
    }
}