<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'Formulario';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1>Formulario de <?= Html::encode($_GET["nombre"]) ?></h1><hr style="border:2px solid black">
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <section class="alert alert-success">
            <p>Gracias por enviar su solicitud de adopcion. Su respuesta sera enviada con la mayor brevedad posible.</p>
            <a href="<?= Url::toRoute("site/adoption") ?>">Ir a la lista de adopciones</a>            
        </section>
            

    <?php else: ?>       
        <?php $form = ActiveForm::begin([
        "method" => "post",
        'enableClientValidation' => true,
        ]);
        ?>        
        <section style="border:1px solid black;border-radius: 8px;" class="col-lg-4 col-md-4 col-sm-4">
            <h2>Información del Hogar</h2><br>  
            <div class="form-group">            
                 <?= $form->field($model, "tipo_de_casa")->dropDownList(['Propia' => 'Propia', 'Alquilada' => 'Alquilada']) ?> 
            </div>
            <div class="form-group">            
                <?= $form->field($model, 'direccion')->textarea(['rows' => '4']) ?>            
            </div>
            <div class="form-group" style="border-top:1px dashed #d0d0d0;border-left:1px dashed #d0d0d0;border-right:1px dashed #d0d0d0;">  
                <h4>Integrantes del Hogar</h4><hr> 
                <div class="form-group col-lg-6 col-md-6 col-sm-6" style="border-bottom:1px dashed #d0d0d0;border-left:1px dashed #d0d0d0;">            
                    <?= $form->field($model, "adultos")->dropDownList(['Solo yo' => 'Solo yo', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6']) ?> 
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6" style="border-bottom:1px dashed #d0d0d0;border-right:1px dashed #d0d0d0;">            
                    <?= $form->field($model, "niños")->dropDownList(['No' => 'No', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ]) ?>          
                </div>                      
            </div>
        </section> 
        <section style="border:1px solid black;border-radius: 8px;" class="col-lg-4 col-md-4 col-sm-4">
            <h2>Información Personal</h2><br>           
            <div class="form-group">
                <?= $form->field($model, "identificacion")->input("text") ?>   
            </div>
            <div class="form-group">
                <?= $form->field($model, "nombre_completo")->input("text") ?>   
            </div>
            <div class="form-group">
                <?= $form->field($model, "telefono")->input("text") ?>   
            </div>
            <div class="form-group">
                <?= $form->field($model, "email")->input("text") ?>   
            </div>
        </section>
        <section style="border:1px solid black;border-radius: 8px;" class="col-lg-4 col-md-4 col-sm-4">
            <h2>Información Mascotas</h2><br>  
            <div class="form-group">
                <?= $form->field($model, "otras_mascotas")->dropDownList(['No tengo' => 'No tengo', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6' ]) ?>           
            </div>
            <div class="form-group">
                <?= $form->field($model, "espacio_habitable_designado")->dropDownList(['Patio' => 'Patio', 'Interior' => 'Interior', 'Ambos' => 'Ambos']) ?>  
            </div>
            <div class="form-group">           
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">
                    Terminos y condiciones
                </button>
                <?= Html::submitButton("Enviar Solicitud", ["class" => "btn btn-primary"]) ?>
                <section class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">                  
                      <section class="modal-body">
                          <h3>Terminos y condiciones</h3><br>
                          <p>
                            °El o la perr@ o gat@ no pasará amarrad@ o encerrad@ en espacios inadecuados.
                            <br />
                            °Debe portar con un collar con la placa de identificación, con los números 
                            telefónicos de su adoptante.
                            <br />
                            °Cuando la familia se ausente en la casa y no pueda llevarl@ (vacaciones,ect) debe buscar a una persona encargada, responsable 
                            para que le brinde agua, alimento y los cuidados que se requieran.
                            <br />
                            °Si hay niñ@s pequeños en casa, se debe supervisar SIEMPRE, cuando jueguen ya que
                            en ocaciones los niños no miden el peligro y si el animal es lastimado puede reaccionar en defensa.<br />
                            °Se realizarán visitas sin previo aviso a la residencia 
                            para verificar el estado físico y psicológico del adoptado o adoptada, además se solicitará información y fotografías de su estado.<br />
                            °Nunca deben alimentar a la mascota con comida elaborada para humanos, ya que al contener condimentos y otras sustancias nocivas para el organismos de los animalitos,
                            produciéndole daños.
                            <br />
                            °Adoptar a un animalito implica adquirir una compañía por años, la labor de cuido o caza de 
                            plagas es extra, pero no se debe pretender que se adquiere únicamente para eso, y olvidar que ama y siente.
                            <br />
                            °Si por alguna razón usted no puede cuidar más del animalit@, se compromete a devolvrlo a HUELLTAS CR de forma inmediata,
                            no "regalarlo", no dejarlo que sufra descuido u abandono previo a su devolución, para realizar un nuevo proceso de adopción
                            con todos lo requisitos.
                            <br />
                            <br />
                            "RECUERDE: Usted adopta un ser viv@ que necesita amor y cuidados, que implica gastos a nivel económico y esfuerzo (limpiar, sacarlo a 
                            pasear, darle de comer, jugar con él, etc). Si su labor es efectiva, tendrá un@ gran amig@ y compañer@ por muchos años y recibirá aún más 
                            de lo que da, sin lugar a dudas."
                            <br />
                            <br />
                            <br />
                            ** Adopto a este nuevo miembro de mi familia en buen estado de salud **
                          </p>                         
                      </section>
                      <section class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> Aceptar</button>                    
                      </section>
                    </div>
                  </div>
                </section>
            </div>        
        </section>
        <?php $form->end() ?>
    <?php endif; ?>


