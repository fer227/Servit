<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property string $username
 * @property string $password
 * @property string $provincia
 * @property string $nombre
 * @property string $apellidos
 * @property string $anioNacimiento
 * @property int $rol
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'provincia', 'nombre', 'apellidos', 'anioNacimiento', 'rol'], 'required'],
            [['rol'], 'integer'],
            [['username', 'provincia', 'nombre', 'apellidos', 'anioNacimiento'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 200],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'provincia' => 'Provincia',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'anioNacimiento' => 'Anio Nacimiento',
            'rol' => 'Rol',
        ];
    }
}
