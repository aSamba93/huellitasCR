<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Registro de Usuario';
$this->params['breadcrumbs'][] = $this->title;
?>
<section>
    <h3><?= $msg ?></h3>
    <h1>Registro de Usuarios</h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
     'id' => 'formulario',
     'enableClientValidation' => false,
     'enableAjaxValidation' => true,
    ]);
    ?>
    <div class="form-group">
        <?= $form->field($model, "username")->input("text") ?>   
    </div>
    <div class="form-group">
        <?= $form->field($model, "email")->input("email") ?>   
    </div>
    <div class="form-group">
        <?= $form->field($model, "password")->input("password") ?>   
    </div>
    <div class="form-group">
        <?= $form->field($model, "password_repeat")->input("password") ?>   
    </div>
    <div class="form-group">
        <?= Html::submitButton("Register", ["class" => "btn btn-primary"]) ?>   
    </div>
    <?php $form->end() ?>
</section>
