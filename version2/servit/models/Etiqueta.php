<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "etiqueta".
 *
 * @property string $nombre
 *
 * @property Clasifica[] $clasificas
 * @property Restaurante[] $restaurantes
 */
class Etiqueta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'etiqueta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 20],
            [['nombre'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Clasificas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClasificas()
    {
        return $this->hasMany(Clasifica::className(), ['nombre' => 'nombre']);
    }

    /**
     * Gets query for [[Restaurantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantes()
    {
        return $this->hasMany(Restaurante::className(), ['id' => 'id_restaurante'])->viaTable('clasifica', ['nombre' => 'nombre']);
    }
}
