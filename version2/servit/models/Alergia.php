<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alergia".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Supone[] $supones
 * @property Producto[] $productos
 */
class Alergia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alergia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Supones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupones()
    {
        return $this->hasMany(Supone::className(), ['id_alergia' => 'id']);
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['id_producto' => 'id_producto'])->viaTable('supone', ['id_alergia' => 'id']);
    }
}
