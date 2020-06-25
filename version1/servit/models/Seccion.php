<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seccion".
 *
 * @property int $numero
 * @property int $id_zona
 * @property int $estado
 * @property int|null $plazas
 * @property int $visible
 * @property string|null $usuario_empleado
 *
 * @property Empleado $usuarioEmpleado
 * @property Zona $zona
 */
class Seccion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seccion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero', 'id_zona', 'estado'], 'required'],
            [['numero', 'id_zona', 'estado', 'plazas', 'visible'], 'integer'],
            [['usuario_empleado'], 'string', 'max' => 15],
            [['numero', 'id_zona'], 'unique', 'targetAttribute' => ['numero', 'id_zona']],
            [['usuario_empleado'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['usuario_empleado' => 'usuario']],
            [['id_zona'], 'exist', 'skipOnError' => true, 'targetClass' => Zona::className(), 'targetAttribute' => ['id_zona' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'numero' => 'Numero',
            'id_zona' => 'Id Zona',
            'estado' => 'Estado',
            'plazas' => 'Plazas',
            'visible' => 'Visible',
            'usuario_empleado' => 'Empleado asignado',
        ];
    }

    /**
     * Gets query for [[UsuarioEmpleado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioEmpleado()
    {
        return $this->hasOne(Empleado::className(), ['usuario' => 'usuario_empleado']);
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
