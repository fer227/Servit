<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contiene".
 *
 * @property int $id_menu
 * @property string $nombre_componente
 * @property int $id_producto
 *
 * @property ComponenteMenu $nombreComponente
 * @property ComponenteMenu $menu
 * @property Producto $producto
 */
class Contiene extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contiene';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_menu', 'nombre_componente', 'id_producto'], 'required'],
            [['id_menu', 'id_producto'], 'integer'],
            [['nombre_componente'], 'string', 'max' => 20],
            [['id_menu', 'nombre_componente', 'id_producto'], 'unique', 'targetAttribute' => ['id_menu', 'nombre_componente', 'id_producto']],
            [['nombre_componente'], 'exist', 'skipOnError' => true, 'targetClass' => ComponenteMenu::className(), 'targetAttribute' => ['nombre_componente' => 'nombre']],
            [['id_menu'], 'exist', 'skipOnError' => true, 'targetClass' => ComponenteMenu::className(), 'targetAttribute' => ['id_menu' => 'id_menu']],
            [['id_producto'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['id_producto' => 'id_producto']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_menu' => 'Id Menu',
            'nombre_componente' => 'Nombre Componente',
            'id_producto' => 'Id Producto',
        ];
    }

    /**
     * Gets query for [[NombreComponente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNombreComponente()
    {
        return $this->hasOne(ComponenteMenu::className(), ['nombre' => 'nombre_componente']);
    }

    /**
     * Gets query for [[Menu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(ComponenteMenu::className(), ['id_menu' => 'id_menu']);
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['id_producto' => 'id_producto']);
    }
}
