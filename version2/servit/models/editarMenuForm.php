<?php


namespace app\models;


use yii\base\Model;

class editarMenuForm extends Model
{
    public $old_name;
    public $new_name;
    public $categoria1;
    public $categoria2;
    public $categoria3;
    public $categoria4;

    public function rules()
    {
        return [
            [['old_name', 'new_name', 'categoria1'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'new_name' => 'Nombre',
            '$categoria1' => 'Categoría 1',
            '$categoria2' => 'Categoría 2',
            '$categoria3' => 'Categoría 3',
            '$categoria4' => 'Categoría 4'
        ];
    }
}