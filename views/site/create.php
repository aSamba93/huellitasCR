<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'Registro de Mascotas';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Registro de Mascotas</h1>
<a href="<?= Url::toRoute("site/view") ?>">Ir a la lista de Mascotas</a>
<section>
    <?php
    $form = ActiveForm::begin([
                "method" => "post",
                "enableClientValidation" => true]);
    ?>
    <h3><?= $msg ?></h3>
    <div class="form-group">
    <?= $form->field($model, "nombre")->input("text") ?>   
    </div>

    <div class="form-group">
    <?= $form->field($model, "sexo")->input("text") ?>   
    </div>

    <div class="form-group">
    <?= $form->field($model, "edad")->input("text") ?>   
    </div>

    <div class="form-group">
    <?= $form->field($model, "castrado")->input("text") ?>   
    </div>

    <div class="form-group">
        <?= $form->field($model, "foto")->fileInput(['multiple' => false]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton("Agregar", ["class" => "btn btn-primary"]) ?>
    </div>
    <?php $form->end() ?>
</section>
