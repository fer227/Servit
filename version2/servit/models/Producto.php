<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property int $id_producto
 * @property int $id_restaurante
 * @property float $precio
 * @property int $id_categoria
 * @property string $nombre
 * @property int $visible
 * @property Categoria $categoria
 * @property Restaurante $restaurante
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['precio', 'id_categoria', 'nombre'], 'required'],
            [['id_restaurante', 'id_categoria', 'visible'], 'integer'],
            [['precio'], 'number'],
            [['nombre'], 'string', 'max' => 20],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['id_categoria' => 'id_categoria']],
            [['id_restaurante'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::className(), 'targetAttribute' => ['id_restaurante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_producto' => 'Id Producto',
            'id_restaurante' => 'Id Restaurante',
            'precio' => 'Precio',
            'id_categoria' => 'Categoría',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id_categoria' => 'id_categoria']);
    }

    /**
     * Gets query for [[Restaurante]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurante()
    {
        return $this->hasOne(Restaurante::className(), ['id' => 'id_restaurante']);
    }
}
