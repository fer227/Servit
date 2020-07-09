<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supone".
 *
 * @property int $id_alergia
 * @property int $id_producto
 *
 * @property Alergia $alergia
 * @property Producto $producto
 */
class Supone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alergia', 'id_producto'], 'required'],
            [['id_alergia', 'id_producto'], 'integer'],
            [['id_alergia', 'id_producto'], 'unique', 'targetAttribute' => ['id_alergia', 'id_producto']],
            [['id_alergia'], 'exist', 'skipOnError' => true, 'targetClass' => Alergia::className(), 'targetAttribute' => ['id_alergia' => 'id']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_alergia' => 'Id Alergia',
            'id_producto' => 'Id Producto',
        ];
    }

    /**
     * Gets query for [[Alergia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlergia()
    {
        return $this->hasOne(Alergia::className(), ['id' => 'id_alergia']);
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
