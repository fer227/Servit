<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "componente_menu".
 *
 * @property string $nombre
 * @property int $id_menu
 *
 * @property Menu $menu
 */
class ComponenteMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'componente_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'id_menu'], 'required'],
            [['id_menu'], 'integer'],
            [['nombre'], 'string', 'max' => 20],
            [['nombre', 'id_menu'], 'unique', 'targetAttribute' => ['nombre', 'id_menu']],
            [['id_menu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['id_menu' => 'id_menu']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'id_menu' => 'Id Menu',
        ];
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id_menu' => 'id_menu']);
    }
}
