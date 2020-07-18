<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clasifica".
 *
 * @property int $id_restaurante
 * @property string $nombre
 *
 * @property Etiqueta $nombre0
 * @property Restaurante $restaurante
 */
class Clasifica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clasifica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_restaurante', 'nombre'], 'required'],
            [['id_restaurante'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['id_restaurante', 'nombre'], 'unique', 'targetAttribute' => ['id_restaurante', 'nombre']],
            [['nombre'], 'exist', 'skipOnError' => true, 'targetClass' => Etiqueta::className(), 'targetAttribute' => ['nombre' => 'nombre']],
            [['id_restaurante'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::className(), 'targetAttribute' => ['id_restaurante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_restaurante' => 'Id Restaurante',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Nombre0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNombre0()
    {
        return $this->hasOne(Etiqueta::className(), ['nombre' => 'nombre']);
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
