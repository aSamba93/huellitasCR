<?php

namespace app\models;
use Yii;
use yii\base\model;

class FormUpdate extends model{

public $id_mascota;
public $nombre;
public $sexo;
public $edad;
public $castrado;

public function rules()
 {
  return [
   ['id_mascota', 'integer', 'message' => 'Id incorrecto'],
   ['nombre', 'required', 'message' => 'Campo requerido'],
   ['nombre', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
   ['nombre', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
   ['sexo', 'required', 'message' => 'Campo requerido'],
   ['sexo', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
   ['edad', 'required', 'message' => 'Campo requerido'],
   ['edad', 'integer', 'message' => 'Sólo números enteros'],
   ['castrado', 'required', 'message' => 'Campo requerido'],
   ['castrado', 'number', 'message' => 'Sólo números'],
  ];
 }
 
}