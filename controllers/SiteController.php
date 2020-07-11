<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarFormulario;
use yii\widgets\ActiveForm;
use app\models\FormMascotas;
use app\models\FormUpdate;
use app\models\Mascotas;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\helpers\Url;
use app\models\FormRegister;
use app\models\Users;
use yii\web\Session;
use app\models\FormRecoverPass;
use app\models\FormResetPass;
use app\models\FormAdoption;

class SiteController extends Controller {    
    public function actionDonation(){
        return $this->render("donation");
    }    
    public function actionForm() {
        $model = new FormAdoption;
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render("form", ['model' => $model]);
    }
    public function actionAdoption(){
        $table = new Mascotas;
        $model = $table->find()->all();
        return $this->render("adoption",["model" => $model]);   
    }  
    public function actionRecoverpass() {
        //Instancia para validar el formulario
        $model = new FormRecoverPass;

        //Mensaje que será mostrado al usuario en la vista
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Buscar al usuario a través del email
                $table = Users::find()->where("email=:email", [":email" => $model->email]);

                //Si el usuario existe
                if ($table->count() == 1) {
                    //Crear variables de sesión para limitar el tiempo de restablecido del password
                    //hasta que el navegador se cierre
                    $session = new Session;
                    $session->open();

                    //Esta clave aleatoria se cargará en un campo oculto del formulario de reseteado
                    $session["recover"] = $this->randKey("abcdef0123456789", 200);
                    $recover = $session["recover"];

                    //También almacenaremos el id del usuario en una variable de sesión
                    //El id del usuario es requerido para generar la consulta a la tabla users y 
                    //restablecer el password del usuario
                    $table = Users::find()->where("email=:email", [":email" => $model->email])->one();
                    $session["id_recover"] = $table->id;

                    //Esta variable contiene un número hexadecimal que será enviado en el correo al usuario 
                    //para que lo introduzca en un campo del formulario de reseteado
                    //Es guardada en el registro correspondiente de la tabla users
                    $verification_code = $this->randKey("abcdef0123456789", 8);
                    //Columna verification_code
                    $table->verification_code = $verification_code;
                    //Guardamos los cambios en la tabla users
                    $table->save();

                    //Creamos el mensaje que será enviado a la cuenta de correo del usuario
                    $subject = "Recuperar password";
                    $body = "<p>Copie el siguiente código de verificación para restablecer su password ... ";
                    $body .= "<strong>" . $verification_code . "</strong></p>";
                    $body .= "<p><a href='http://yii.local/index.php?r=site/resetpass'>Recuperar password</a></p>";

                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                            ->setTo($model->email)
                            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                            ->setSubject($subject)
                            ->setHtmlBody($body)
                            ->send();

                    //Vaciar el campo del formulario
                    $model->email = null;

                    //Mostrar el mensaje al usuario
                    $msg = "Le hemos enviado un mensaje a su cuenta de correo para que pueda resetear su password";
                } else { //El usuario no existe
                    $msg = "Ha ocurrido un error";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("recoverpass", ["model" => $model, "msg" => $msg]);
    }
    public function actionResetpass() {
        //Instancia para validar el formulario
        $model = new FormResetPass;

        //Mensaje que será mostrado al usuario
        $msg = null;

        //Abrimos la sesión
        $session = new Session;
        $session->open();

        //Si no existen las variables de sesión requeridas lo expulsamos a la página de inicio
        if (empty($session["recover"]) || empty($session["id_recover"])) {
            return $this->redirect(["site/index"]);
        } else {

            $recover = $session["recover"];
            //El valor de esta variable de sesión la cargamos en el campo recover del formulario
            $model->recover = $recover;

            //Esta variable contiene el id del usuario que solicitó restablecer el password
            //La utilizaremos para realizar la consulta a la tabla users
            $id_recover = $session["id_recover"];
        }

        //Si el formulario es enviado para resetear el password
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Si el valor de la variable de sesión recover es correcta
                if ($recover == $model->recover) {
                    //Preparamos la consulta para resetear el password, requerimos el email, el id 
                    //del usuario que fue guardado en una variable de session y el código de verificación
                    //que fue enviado en el correo al usuario y que fue guardado en el registro
                    $table = Users::findOne(["email" => $model->email, "id" => $id_recover, "verification_code" => $model->verification_code]);

                    //Encriptar el password
                    $table->password = crypt($model->password, Yii::$app->params["salt"]);

                    //Si la actualización se lleva a cabo correctamente
                    if ($table->save()) {

                        //Destruir las variables de sesión
                        $session->destroy();

                        //Vaciar los campos del formulario
                        $model->email = null;
                        $model->password = null;
                        $model->password_repeat = null;
                        $model->recover = null;
                        $model->verification_code = null;

                        $msg = "Enhorabuena, password reseteado correctamente, redireccionando a la página de login ...";
                        $msg .= "<meta http-equiv='refresh' content='5; " . Url::toRoute("site/login") . "'>";
                    } else {
                        $msg = "Ha ocurrido un error";
                    }
                } else {
                    $model->getErrors();
                }
            }
        }

        return $this->render("resetpass", ["model" => $model, "msg" => $msg]);
    }
    private function randKey($str = '', $long = 0) {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str) - 1;
        for ($x = 0; $x < $long; $x++) {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
    public function actionConfirm() {
        $table = new Users;
        if (Yii::$app->request->get()) {

            //Obtenemos el valor de los parámetros get
            $id = Html::encode($_GET["id"]);
            $authKey = $_GET["authKey"];

            if ((int) $id) {
                //Realizamos la consulta para obtener el registro
                $model = $table
                        ->find()
                        ->where("id=:id", [":id" => $id])
                        ->andWhere("authKey=:authKey", [":authKey" => $authKey]);

                //Si el registro existe
                if ($model->count() == 1) {
                    $activar = Users::findOne($id);
                    $activar->activate = 1;
                    if ($activar->update()) {
                        echo "Enhorabuena registro llevado a cabo correctamente, redireccionando ...";
                        echo "<meta http-equiv='refresh' content='8; " . Url::toRoute("site/login") . "'>";
                    } else {
                        echo "Ha ocurrido un error al realizar el registro, redireccionando ...";
                        echo "<meta http-equiv='refresh' content='8; " . Url::toRoute("site/login") . "'>";
                    }
                } else { //Si no existe redireccionamos a login
                    return $this->redirect(["site/login"]);
                }
            } else { //Si id no es un número entero redireccionamos a login
                return $this->redirect(["site/login"]);
            }
        }
    }
    public function actionRegister() {
        //Creamos la instancia con el model de validación
        $model = new FormRegister;

        //Mostrará un mensaje en la vista cuando el usuario se haya registrado
        $msg = null;

        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        //Validación cuando el formulario es enviado vía post
        //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
        //También previene por si el usuario tiene desactivado javascript y la
        //validación mediante ajax no puede ser llevada a cabo
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                //Preparamos la consulta para guardar el usuario
                $table = new Users;
                $table->username = $model->username;
                $table->email = $model->email;
                //Encriptamos el password
                $table->password = crypt($model->password, Yii::$app->params["salt"]);
                //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
                //clave será utilizada para activar el usuario
                $table->authKey = $this->randKey("abcdef0123456789", 200);
                //Creamos un token de acceso único para el usuario
                $table->accessToken = $this->randKey("abcdef0123456789", 200);

                //Si el registro es guardado correctamente
                if ($table->insert()) {
                    //Nueva consulta para obtener el id del usuario
                    //Para confirmar al usuario se requiere su id y su authKey
                    $user = $table->find()->where(["email" => $model->email])->one();
                    $id = urlencode($user->id);
                    $authKey = urlencode($user->authKey);

                    $subject = "Confirmar registro";
                    $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
                    $body .= "<a href='http://yii.local/index.php?r=site/confirm&id=" . $id . "&authKey=" . $authKey . "'>Confirmar</a>";

                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                            ->setTo($user->email)
                            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                            ->setSubject($subject)
                            ->setHtmlBody($body)
                            ->send();

                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;

                    $msg = "Enhorabuena, ahora sólo falta que confirmes tu registro en tu cuenta de correo";
                } else {
                    $msg = "Ha ocurrido un error al llevar a cabo tu registro";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("register", ["model" => $model, "msg" => $msg]);
    }
    public function actionUpdate() {

        $model = new FormUpdate;
        $msg = null;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $table = Mascotas::findOne($model->id_mascota);
                if ($table) {
                    $table->id_mascota = $model->id_mascota;
                    $table->nombre = $model->nombre;
                    $table->sexo = $model->sexo;
                    $table->edad = $model->edad;
                    $table->castrado = $model->castrado;
                    if ($table->update()) {
                        $msg = "Los datos de la mascota han sido actualizados";
                    } else {
                        $msg = "Los datos de la mascota no se han podido actualizar";
                    }
                } else {
                    $msg = "La mascota seleccionada no ha sido encontrada";
                }
            } else {
                $model->getErrors();
            }
        }
        if (Yii::$app->request->get("id_mascota")) {
            $id_mascota = Html::encode($_GET["id_mascota"]);
            if ((int) $id_mascota) {
                $table = Mascotas::findOne($id_mascota);
                if ($table) {
                    $model->id_mascota = $table->id_mascota;
                    $model->nombre = $table->nombre;
                    $model->sexo = $table->sexo;
                    $model->edad = $table->edad;
                    $model->castrado = $table->castrado;
                } else {
                    return $this->redirect(["site/view"]);
                }
            } else {
                return $this->redirect(["site/view"]);
            }
        } else {
            return $this->redirect(["site/view"]);
        }
        return $this->render("update", ["model" => $model, "msg" => $msg]);
    }
    public function actionDelete() {
        if (Yii::$app->request->post()) {
            $id_mascota = Html::encode($_POST["id_mascota"]);
            if ((int) $id_mascota) {
                if (Mascotas::deleteAll("id_mascota=:id_mascota", [":id_mascota" => $id_mascota])) {
                    echo "Mascota con id $id_mascota eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("site/view") . "'>";
                } else {
                    echo "Ha ocurrido un error al eliminar la mascota, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("site/view") . "'>";
                }
            } else {
                echo "Ha ocurrido un error al eliminar la mascota, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; " . Url::toRoute("site/view") . "'>";
            }
        } else {
            return $this->redirect(["site/view"]);
        }
    }
    public function actionView() {
        $form = new FormSearch;
        $search = null;
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $table = Mascotas::find()
                        ->where(["like", "id_mascota", $search])
                        ->orWhere(["like", "nombre", $search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 5,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
            } else {
                $form->getErrors();
            }
        } else {
            $table = Mascotas::find();
            $count = clone $table;
            $pages = new Pagination([
                "pageSize" => 5,
                "totalCount" => $count->count()
            ]);
            $model = $table
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
        }
        return $this->render("view", [
                    "model" => $model,
                    "form" => $form,
                    "search" => $search,
                    "pages" => $pages]);
    }
    public function actionCreate() {
        $model = new FormMascotas;
        $msg = null;
        if ($model->load(Yii::$app->request->post())) {
            $model->foto = UploadedFile::getInstance($model, 'foto');
            if ($model->validate()) {                
                $table = new Mascotas;
                $table->nombre = $model->nombre;
                $table->sexo = $model->sexo;
                $table->edad = $model->edad;
                $table->castrado = $model->castrado;  
                $table->foto = $model->foto->baseName . '.' . $model->foto->extension ;
                $model->foto->saveAs('fotosMascotas/' . $table->foto);
                
                if ($table->insert()) {
                    $msg = "Enhorabuena registro guardado correctamente";
                    $model->nombre = null;
                    $model->sexo = null;
                    $model->edad = null;
                    $model->castrado = null;
                    $model->foto = null;
                } else {
                    $msg = "Ha ocurrido un error al insertar el registro";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("create", ['model' => $model, 'msg' => $msg]);
    }
    public function actionFormulario($mensaje = null) {
        return $this->render("formulario", ["mensaje" => $mensaje]);
    }
    public function actionRequest() {
        $mensaje = null;
        if (isset($_REQUEST["nombre"])) {
            $mensaje = "Bien, haz enviado tu nombre correctamente " . $_REQUEST["nombre"];
        }
        $this->redirect(["site/formulario", "mensaje" => $mensaje]);
    }
    public function actionValidarformulario() {

        $model = new ValidarFormulario;
        if ($model->load(Yii::$app->request->post())) {
            //si enviamos el formulario
            if ($model->validate()) {
                //consultar en una bd
            } else {
                $model->getErrors();
            }
        }
        return $this->render("validarformulario", ["model" => $model]);
    }
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                        [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
                    'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }

}
