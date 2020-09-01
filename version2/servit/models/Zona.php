<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "zona".
 *
 * @property int $id
 * @property int $id_restaurante
 * @property string $nombre
 * @property int $es_barra
 * @property int $num_secciones
 * @property int $visible
 * @property Seccion[] $seccions
 * @property Restaurante $restaurante
 */
class Zona extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zona';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'num_secciones'], 'required'],
            [['id_restaurante', 'es_barra', 'num_secciones', 'visible'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['id_restaurante'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::className(), 'targetAttribute' => ['id_restaurante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_restaurante' => 'Id Restaurante',
            'nombre' => 'Nombre',
            'es_barra' => 'Es Barra',
            'num_secciones' => 'Num Secciones',
        ];
    }

    /**
     * Gets query for [[Seccions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSeccions()
    {
        return $this->hasMany(Seccion::className(), ['id_zona' => 'id']);
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
