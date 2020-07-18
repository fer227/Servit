<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "incluye".
 *
 * @property int $id_pedido
 * @property int $id_producto
 * @property int $cantidad
 * @property int $cantidad_entregada
 *
 * @property Pedido $pedido
 * @property Producto $producto
 */
class Incluye extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'incluye';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pedido', 'id_producto', 'cantidad', 'cantidad_entregada'], 'required'],
            [['id_pedido', 'id_producto', 'cantidad', 'cantidad_entregada'], 'integer'],
            [['id_pedido', 'id_producto'], 'unique', 'targetAttribute' => ['id_pedido', 'id_producto']],
            [['id_pedido'], 'exist', 'skipOnError' => true, 'targetClass' => Pedido::className(), 'targetAttribute' => ['id_pedido' => 'id_pedido']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pedido' => 'Id Pedido',
            'id_producto' => 'Id Producto',
            'cantidad' => 'Cantidad',
            'cantidad_entregada' => 'Cantidad Entregada',
        ];
    }

    /**
     * Gets query for [[Pedido]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPedido()
    {
        return $this->hasOne(Pedido::className(), ['id_pedido' => 'id_pedido']);
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['id_producto' => 'id_producto']);
    }
}
