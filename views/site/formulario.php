<?php
    use yii\helpers\Url;
    use yii\helpers\Html;
?>
<h1>FORMULARIO</h1>
<h3> <?= $mensaje?> </h3>
<?= HTML::beginForm(url::toRoute("site/request"),"get", ['class' => 'form-inline']); ?>
    <section class="form-group">
        <?= HTML::Label("Introduce tu nombre","nombre")?>   
        <?= HTML::TextInput("nombre",null, ["class" => "form-control"])?> 
    </section>
    <?= HTML::SubmitInput("Enviar", ["class" => "btn btn-primary"])?>
<?= HTML::endForm() ?>
