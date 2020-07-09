<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atiende".
 *
 * @property int $id_zona
 * @property int $numero
 * @property string $username
 * @property string $datetime
 * @property float|null $importe
 * @property float|null $propina
 * @property string|null $reclamacion
 * @property int|null $recomendaria
 * @property int|null $repetiria
 * @property int|null $ambiente
 * @property int|null $experiencia
 *
 * @property Seccion $numero0
 * @property Usuario $username0
 * @property Zona $zona
 */
class Atiende extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atiende';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_zona', 'numero', 'username', 'datetime'], 'required'],
            [['id_zona', 'numero', 'recomendaria', 'repetiria', 'ambiente', 'experiencia'], 'integer'],
            [['datetime'], 'safe'],
            [['importe', 'propina'], 'number'],
            [['username'], 'string', 'max' => 20],
            [['reclamacion'], 'string', 'max' => 150],
            [['id_zona', 'numero', 'username', 'datetime'], 'unique', 'targetAttribute' => ['id_zona', 'numero', 'username', 'datetime']],
            [['numero'], 'exist', 'skipOnError' => true, 'targetClass' => Seccion::className(), 'targetAttribute' => ['numero' => 'numero']],
            [['username'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['username' => 'username']],
            [['id_zona'], 'exist', 'skipOnError' => true, 'targetClass' => Zona::className(), 'targetAttribute' => ['id_zona' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_zona' => 'Id Zona',
            'numero' => 'Numero',
            'username' => 'Username',
            'datetime' => 'Datetime',
            'importe' => 'Importe',
            'propina' => 'Propina',
            'reclamacion' => 'Reclamacion',
            'recomendaria' => 'Recomendaria',
            'repetiria' => 'Repetiria',
            'ambiente' => 'Ambiente',
            'experiencia' => 'Experiencia',
        ];
    }

    /**
     * Gets query for [[Numero0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNumero0()
    {
        return $this->hasOne(Seccion::className(), ['numero' => 'numero']);
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

    /**
     * Gets query for [[Zona]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getZona()
    {
        return $this->hasOne(Zona::className(), ['id' => 'id_zona']);
    }
}
