<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;

    $this->title = 'Login';
    $this->params['breadcrumbs'][] = $this->title;
?>
<section>
    <h1><?= Html::encode($this->title) ?></h1>    
    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
        <div class="col-lg-offset-1" style="color:#999;">
        <p>En caso de  <strong>olvidar la contraseña</strong> , dirijase al siguiente enlace.<br>
        <a href="<?= Url::toRoute("site/recoverpass") ?>">Recuperar Contraseña</a></p>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>                
            </div>
        </div>
    <?php ActiveForm::end(); ?>    
</section>
