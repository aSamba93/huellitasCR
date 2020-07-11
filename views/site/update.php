<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
?>
<section>
    <h1>Editar mascota con id <?= Html::encode($_GET["id_mascota"]) ?></h1>
    <a href="<?= Url::toRoute("site/view") ?>">Ir a la lista de mascotas</a><br>
    <h3><?= $msg ?></h3>

    <?php $form = ActiveForm::begin([
        "method" => "post",
        'enableClientValidation' => true,
    ]);
    ?>
    <?= $form->field($model, "id_mascota")->input("hidden")->label(false) ?>
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
        <?= Html::submitButton("Actualizar", ["class" => "btn btn-primary"]) ?>
    </div>
    <?php $form->end() ?>
</section>