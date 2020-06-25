<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id_menu
 * @property int $id_restaurante
 * @property string $nombre
 *
 * @property ComponenteMenu[] $componenteMenus
 * @property Restaurante $restaurante
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
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
            [['id_restaurante'], 'exist', 'skipOnError' => true, 'targetClass' => Restaurante::className(), 'targetAttribute' => ['id_restaurante' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_menu' => 'Id Menu',
            'id_restaurante' => 'Id Restaurante',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[ComponenteMenus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComponenteMenus()
    {
        return $this->hasMany(ComponenteMenu::className(), ['id_menu' => 'id_menu']);
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
