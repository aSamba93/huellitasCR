<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

?>
<section>
    <h1>Lista de Mascotas</h1>
    <a href="<?= Url::toRoute("site/create") ?>">Registrar una nueva Mascota</a><br><br><br>
    <?php
    $f = ActiveForm::begin([
                "method" => "get",
                "action" => Url::toRoute("site/view"),
                "enableClientValidation" => true,
            ]);
    ?>
    <section class="form-group">
        <div class="row">
            <div class="col-log-8 col-md-8 col-sm-8">
                <?= $f->field($form, "q")->input("search") ?>
            </div>
            <div class="col-log-4 col-md-4 col-sm-4">
                <br>
                <?= Html::submitButton("Buscar", ["class" => "btn btn-primary"]) ?>
            </div>
        </div>
    </section>
    <?php $f->end() ?>
    <section>
        <table class="table table-bordered">
            <tr>
                <th>Id Mascota</th>
                <th>Nombre</th>
                <th>Sexo</th>
                <th>Edad</th>
                <th>Castrado</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($model as $row): ?>
                <tr>
                    <td><?= $row->id_mascota ?></td>
                    <td><?= $row->nombre ?></td>
                    <td><?= $row->sexo ?></td>
                    <td><?= $row->edad ?></td>
                    <td><?= $row->castrado ?></td>
                    <td>
                        <a href="<?= Url::toRoute(["site/update", "id_mascota" => $row->id_mascota]) ?>">Editar</a>            
                    </td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#id_mascota_<?= $row->id_mascota ?>">Eliminar</a>
                        <div class="modal fade" role="dialog" aria-hidden="true" id="id_mascota_<?= $row->id_mascota ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title">Eliminar mascota</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Realmente deseas eliminar a la mascota ID<?= $row->id_mascota ?> llamado <?= $row->nombre ?>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                                        <input type="hidden" name="id_mascota" value="<?= $row->id_mascota ?>">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Eliminar</button>                                
                                        <?= Html::endForm() ?>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?=
    LinkPager::widget([
        "pagination" => $pages,
    ]);
        ?>
    </section>
</section>