<?php

namespace app\models;
use Yii;
use yii\base\model;
use yii\helpers\Html;

class FormAdoption extends model{
public $identificacion;
public $nombre_completo;
public $telefono;
public $email;
public $tipo_de_casa;
public $direccion;
public $adultos;
public $niños;
public $otras_mascotas;
public $espacio_habitable_designado;
public function rules()
 {
  return [
      //aqui valida que el id sea un int, sino manda un mensaje 'Id incorrecto'
   ['identificacion', 'integer', 'message' => 'Id incorrecto'],
   ['identificacion', 'required', 'message' => 'Campo requerido'],
      //con la variable "required" valida que el campo tenga un valor, sino tira un mensaje
   ['nombre_completo', 'required', 'message' => 'Campo requerido'],
      //el atributo match permite incluir una expresion regular, que valide las letras de la a la z 
      // las vocales tildadas y la letra ñ
   ['nombre_completo', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
      //validamos un min de 3 y max 50 letras
   ['nombre_completo', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
   
   ['telefono', 'required', 'message' => 'Campo requerido'],
   ['telefono', 'integer', 'message' => 'Sólo números'],
   ['email', 'required', 'message' => 'Campo requerido'],
   ['email', 'match', 'pattern' => "/^.{5,50}$/", 'message' => 'Mínimo 5 y máximo 50 caracteres'],
   ['email', 'email', 'message' => 'Formato no válido'],
   ['tipo_de_casa', 'required', 'message' => 'Campo requerido'],
   ['direccion', 'required', 'message' => 'Campo requerido'],  
   ['adultos', 'required', 'message' => 'Campo requerido'],
   ['niños', 'required', 'message' => 'Campo requerido'],
   ['otras_mascotas', 'required', 'message' => 'Campo requerido'],
   ['espacio_habitable_designado', 'required', 'message' => 'Campo requerido'],
  ];
 }
 public function contact($email)
    {
     $body = "Identificacion: ". $this->identificacion."<br>";
     $body .= "Nombre Solicitante: ". $this->nombre_completo."<br>";
     $body .= "Telefono: ". $this->telefono."<br>";
     $body .= "Correo: ". $this->email."<br>";
     $body .= "Direccion: ". $this->direccion."<br>";
     $body .= "Tipo de Casa: ". $this->tipo_de_casa."<br>";
     $body .= "Otras Mascotas: ". $this->otras_mascotas."<br>";
     $body .= "Cantidad de Personas que viven en la casa:<br> Adultos: ". $this->adultos." Niños: ". $this->niños."<br>";     
     $body .= "Espacio habitable designado para mascotas: ". $this->espacio_habitable_designado."<br>";
     
        $content = "<p>Solicitud de Adopcion de " . Html::encode($_GET["nombre"]) . "</p>";
        $content .= "<p>" . $body . "</p>";
        
        if ($this->validate()) {
            Yii::$app->mailer->compose("@app/mail/layouts/html", ["content" => $content])
                ->setTo($email)
                ->setFrom([$this->email => $this->nombre_completo])                
                ->setSubject(Html::encode($_GET["nombre"]))
                ->setTextBody($body)
                ->send();

            return true;
        }
        return false;
    }
 
}