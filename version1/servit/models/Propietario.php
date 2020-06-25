<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "propietario".
 *
 * @property string $nombre
 * @property string $apellidos
 * @property string $username
 * @property string $password
 * @property int|null $restaurante
 * @property string $correo
 * @property string $visible
 * @property Restaurante $restaurante0
 */
class Propietario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'propietario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellidos', 'username', 'password', 'correo'], 'required'],
            [['restaurante', 'visible'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['correo'], 'string', 'max' => 30],
            [['apellidos'], 'string', 'max' => 40],
            [['username'], 'string', 'max' => 25],
            [['password'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['restaurante'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::className(), 'targetAttribute' => ['restaurante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'username' => 'Username',
            'password' => 'Password',
            'restaurante' => 'Restaurante',
        ];
    }

    /**
     * Gets query for [[Restaurante0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurante0()
    {
        return $this->hasOne(Restaurante::className(), ['id' => 'restaurante']);
    }

    public function getAuthKey(){
        throw new yii\base\NotSupportedException();
    }

    public function getId(){
        return $this->username;
    }

    public function validateAuthKey($authKey){
        return $this->authkey === $authKey;
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new yii\base\NotSupportedException();
    }

    public static function findByUsername($username){
        return self::findOne(['username' => $username]);
    }

    public function validatePassword($password){
        return password_verify($password, $this->password);
    }
}
