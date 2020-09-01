<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restaurante".
 *
 * @property int $id
 * @property string $direccion
 * @property int $telefono
 * @property string|null $ruta
 * @property string $provincia
 * @property string $localidad
 * @property string $nombre
 * @property string $hora_apertura
 * @property string $hora_cierre
 *
 * @property Categoria[] $categorias
 * @property Clasifica[] $clasificas
 * @property Etiqueta[] $nombres
 * @property Empleado[] $empleados
 * @property Menu[] $menus
 * @property Mesa[] $mesas
 * @property Producto[] $productos
 * @property Propietario[] $propietarios
 */
class Restaurante extends \yii\db\ActiveRecord
{
    public $imagen;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restaurante';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['telefono'], 'integer'],
            [['hora_apertura', 'hora_cierre'], 'safe'],
            [['direccion', 'ruta'], 'string', 'max' => 100],
            [['provincia', 'localidad', 'nombre'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'ruta' => 'Ruta',
            'provincia' => 'Provincia',
            'localidad' => 'Localidad',
            'nombre' => 'Nombre',
            'hora_apertura' => 'Hora Apertura',
            'hora_cierre' => 'Hora Cierre',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $ruta_imagen = 'uploads/' . $this->nombre . '.' . $this->imagen->extension;
            $this->imagen->saveAs($ruta_imagen);
            $this->updateAttributes(['ruta' => $ruta_imagen]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets query for [[Categorias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::className(), ['id_restaurante' => 'id']);
    }

    /**
     * Gets query for [[Clasificas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClasificas()
    {
        return $this->hasMany(Clasifica::className(), ['id_restaurante' => 'id']);
    }

    /**
     * Gets query for [[Nombres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNombres()
    {
        return $this->hasMany(Etiqueta::className(), ['nombre' => 'nombre'])->viaTable('clasifica', ['id_restaurante' => 'id']);
    }

    /**
     * Gets query for [[Empleados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::className(), ['restaurante' => 'id']);
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id_restaurante' => 'id']);
    }

    /**
     * Gets query for [[Mesas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMesas()
    {
        return $this->hasMany(Mesa::className(), ['restaurante' => 'id']);
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['id_restaurante' => 'id']);
    }

    /**
     * Gets query for [[Propietarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPropietarios()
    {
        return $this->hasMany(Propietario::className(), ['restaurante' => 'id']);
    }
}
