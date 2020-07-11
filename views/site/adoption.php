<?php

use yii\helpers\Url;
$this->title = 'Adoption';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 style="text-align: center">Adopciones</h1>
<section class="contenedor">    
    <?php foreach ($model as $row): ?>
    <section class="contenedor__card">
        <p class="card__title"><?=$row->nombre?></p>
        <img class="card__img" src="fotosMascotas/<?= $row->foto ?>" ><br><br>
        <a href="#" class="card__boton" data-toggle="modal" data-target="#id_mascota_<?= $row->id_mascota ?>">Datos</a>
        <section class="modal fade" role="dialog" aria-hidden="true" id="id_mascota_<?= $row->id_mascota ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                     <section class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Mascota: <?= $row->id_mascota ?></h4>
                    </section>
                    <section class="modal-body">
                        <img class="modal__img" src="fotosMascotas/<?= $row->foto ?>" >                                                
                        <p><b>Nombre: </b> <?=$row->nombre?><br>
                        <b>Edad: </b> <?=$row->edad?> años<br>
                        <b>Sexo: </b> <?=$row->sexo?><br>
                        <b><?php                            
                            if($row->castrado==1){
                                $castrado="Castrado";
                            }else{
                                $castrado="No está castrado";
                            }
                            ?>
                        <?=$castrado?></b>
                        </p>
                    </section>
                    <section class="modal-footer">                        
                        <a href="<?= Url::toRoute(["site/form", "nombre" => $row->nombre]) ?>" class="btn btn-primary">Adoptar</a>                        
                    </section>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </section><!-- /.modal -->
    </section>        
    <?php endforeach; ?>
</section>