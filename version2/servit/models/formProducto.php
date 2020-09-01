<?php


namespace app\models;


use yii\base\Model;

class formProducto extends Model
{
    public $precio;
    public $id_categoria;
    public $chips;
    public $nombre;
    public $alergias;

    public function rules()
    {
        return [
            [['precio', 'id_categoria', 'nombre'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'precio' => 'Precio',
            'id_categoria' => 'Categoria',
        ];
    }
}