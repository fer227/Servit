<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property int $id_pedido
 * @property string $username
 * @property string $datetime
 * @property string $nota
 * @property int $estado
 * @property float $precio_total
 *
 * @property Incluye[] $incluyes
 * @property Producto[] $productos
 * @property Usuario $username0
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'datetime', 'estado', 'precio_total'], 'required'],
            [['datetime'], 'safe'],
            [['estado'], 'integer'],
            [['precio_total'], 'number'],
            [['username'], 'string', 'max' => 20],
            [['nota'], 'string', 'max' => 100],
            [['username'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['username' => 'username']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pedido' => 'Id Pedido',
            'username' => 'Username',
            'datetime' => 'Datetime',
            'nota' => 'Nota',
            'estado' => 'Estado',
            'precio_total' => 'Precio Total',
        ];
    }

    /**
     * Gets query for [[Incluyes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIncluyes()
    {
        return $this->hasMany(Incluye::className(), ['id_pedido' => 'id_pedido']);
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['id_producto' => 'id_producto'])->viaTable('incluye', ['id_pedido' => 'id_pedido']);
    }

    /**
     * Gets query for [[Username0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsername0()
    {
        return $this->hasOne(Usuario::className(), ['username' => 'username']);
    }
}
