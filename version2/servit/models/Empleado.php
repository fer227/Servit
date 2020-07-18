<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empleado".
 *
 * @property string $usuario
 * @property string $dni
 * @property string $nombre
 * @property string $apellido1
 * @property string $apellido2
 * @property string $password
 * @property string $rol
 * @property int $id_restaurante
 * @property int $visible
 * @property Restaurante $restaurante
 * @property Mesa[] $mesas
 */
class Empleado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empleado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dni', 'nombre', 'apellido1', 'apellido2', 'rol'], 'required'],
            [['id_restaurante', 'visible'], 'integer'],
            [['usuario', 'nombre'], 'string', 'max' => 15],
            [['dni'], 'string', 'max' => 9],
            [['password'], 'string', 'max' => 200],
            [['apellido1', 'apellido2', 'rol'], 'string', 'max' => 20],
            [['usuario'], 'unique'],
            [['id_restaurante'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::className(), 'targetAttribute' => ['id_restaurante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'dni' => 'DNI',
            'nombre' => 'Nombre',
            'apellido1' => 'Primer apellido',
            'apellido2' => 'Segundo apellido',
            'password' => 'Contraseña',
            'rol' => 'Rol',
            'id_restaurante' => 'Id Restaurante',
        ];
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

    /**
     * Gets query for [[Mesas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMesas()
    {
        return $this->hasMany(Mesa::className(), ['empleado' => 'usuario']);
    }
}
