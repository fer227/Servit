<?php


namespace app\models;


use yii\base\Model;
use yii\web\UploadedFile;

class editarInformacionForm extends Model
{
    public $old_nombre;
    public $new_nombre;
    public $telefono;
    public $direccion;
    public $imagen = null;
    public $provincia;
    public $localidad;
    public $etiquetas;
    public $hora_apertura;
    public $hora_cierre;

    public function rules()
    {
        return [
            [['old_nombre', 'new_nombre', 'telefono', 'direccion', 'hora_apertura', 'hora_cierre', 'provincia', 'localidad', 'etiquetas'], 'required'],
            [['imagen'], 'file', 'extensions' => 'png, jpg']
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imagen->saveAs('uploads/' . $this->old_nombre . '.' . $this->imagen->extension);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'new_nombre' => 'Nombre del restaurante',
            'telefono' => 'Telefono',
            'direccion' => 'Dirección',
            'imagen' => 'Logo o foto del restaurante',
            'horario' => 'Describa el horario de su local',
            'provincia' => 'Provincia',
            'localidad' => 'Localidad',
            'hora_apertura' => 'Selecciona la hora de apertura de tu local',
            'hora_cierre' => 'Selecciona la hora de cierre de tu local'
        ];
    }
}