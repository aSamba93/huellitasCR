<?php

namespace app\models;
use Yii;
use yii\base\model;

class FormMascotas extends model{

public $id_mascota;
public $nombre;
public $sexo;
public $edad;
public $castrado;
public $foto;

public function rules()
 {
  return [
      //aqui valida que el id sea un int, sino manda un mensaje 'Id incorrecto'
   ['id_mascota', 'integer', 'message' => 'Id incorrecto'],
      //con la variable "required" valida que el campo tenga un valor, sino tira un mensaje
   ['nombre', 'required', 'message' => 'Campo requerido'],
      //el atributo match permite incluir una expresion regular, que valide las letras de la a la z 
      // las vocales tildadas y la letra ñ
   ['nombre', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
      //validamos un min de 3 y max 50 letras
   ['nombre', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
   ['sexo', 'required', 'message' => 'Campo requerido'],
   ['sexo', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
   ['edad', 'required', 'message' => 'Campo requerido'],
   ['edad', 'integer', 'message' => 'Sólo números enteros'],
   ['castrado', 'required', 'message' => 'Campo requerido'],
      //valida que sea un numero
   ['castrado', 'number', 'message' => 'Sólo números'],
   ['foto', 'file', 'skipOnEmpty' => false,
   'uploadRequired' => 'No has seleccionado ningún archivo',//Error   
   'extensions' => 'jpg, png, pdf',
   'maxSize' => 1024*1024*1, //1 MB
   'tooBig' => 'El tamaño máximo permitido es 1MB', //Error
   'wrongExtension' => 'El archivo {file} no contiene una extensión permitida {extensions}', //Error   
   ],
  ];
 }
 
}