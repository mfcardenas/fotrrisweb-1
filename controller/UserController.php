<?php

/**
 * Class UserController
 */
class UserController extends ControllerBase{

    private $entity;
    private $table;

    /**
     * UserController constructor.
     */
    public function __construct() {
        $this->entity = "User";
        $this->table = "user";
        parent::__construct();
    }

    /**
     *
     */
    public function index(){
        
        //Creamos el objeto usuario
        $usuario=new User();

        //Conseguimos todos los usuarios
        $allusers=$usuario->getAll();

        if (is_bool($allusers) || $allusers == null || $allusers == '' || count($allusers) == 0){
            $allusers = [];
        }
       
        //Cargamos la vista index y le pasamos valores
        $this->view("index",$this->entity, array(
            "alluser"=>$allusers,
            "combo" => $this->getCombo()
        ));
    }

    public function add(){
        $keyerrors = [];
        $usuario = new User();
        $this->view("create",$this->entity, array(
            "user"=>$usuario,
            "combo" => $this->getCombo(),
            "keys" => $keyerrors,
            "action" => "Create"
        ));

    }

    public function modify(){
        $keyerrors = [];

        if (isset($_GET["id_user"])) {
            $id=(int)$_GET["id_user"];
            $user = new User();
            $usuario = $user->getById($id);
            $this->view("create", $this->entity, array(
                "user" => $usuario,
                "keys" => $keyerrors,
                "combo" => $this->getCombo(),
                "action" => "Update"
            ));

        }
    }

    public function update(){

        $user = new User();
        $keyerrors = [];
        $result = false;

        if (isset($_POST['username'], $_POST['email'], $_POST['name'], $_POST['id'])) {

            $id =     filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $user->setId($id);
            $name =     filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $user->setName($name);
            $perfil =   filter_input(INPUT_POST, 'id_perfil', FILTER_SANITIZE_STRING);
            $user->setIdPerfil($perfil);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $user->setUsername($username);

            $userapp = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $user->setUserModif($userapp);

            $email =    filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            $snactive =    filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
            $user->setSnActive($snactive);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($keyerrors, "501");
            } else {
                $user->setEmail($email);
            }

            $users = $user->getBy("email", $email);
            if ($users != null && count($users) > 0){
                foreach ($users as $usertmp ){
                    if ($usertmp->getId() != $user->getId()){
                        array_push($keyerrors, "908");
                    }
                }
            }

            $picture = null;
            try {
                //verificar formato, tamanio y existencia de la imagen
                if ( !isset($_FILES["image"]) || $_FILES["image"]["error"] > 0){
                    //array_push($keyerrors, "607");
                } else {
                    $type_img = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                    $size_kb = 1024;

                    if (in_array($_FILES['image']['type'], $type_img) && $_FILES['image']['size'] <= $size_kb * 1024){
                        $imagen_temporal  = $_FILES['image']['tmp_name'];
                        $image_type = $_FILES['image']['type'];
                        $fp     = fopen($imagen_temporal, 'r+b');
                        $picture = fread($fp, filesize($imagen_temporal));
                        fclose($fp);
                        $user->setPicture($picture);
                        $user->setImageType($image_type);
                    } else {
                        array_push($keyerrors, "608");
                    }
                }
            } catch (Exception $e) {

            }

            if (count($keyerrors) == 0) {
                $usermodel = new GlobalModel();
                $result = $usermodel->updateUser($user, $this->table);
            } else {
                $user->setPassword(null);
            }
        } else{
            array_push($keyerrors, "999");
        }

        if ($result >= 0) {
            $this->redirect("user", "index");
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "user" => $user,
                "combo" => $this->getCombo(),
                "action" => "Update"
            ));
        }
    }

    public function create(){

        $user = new User();
        $keyerrors = [];
        $result = "";

        try {
            if (isset($_POST['username'], $_POST['email'], $_POST['name'], $_POST['p'])) {

                $name =     filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $user->setName($name);
                $perfil =   filter_input(INPUT_POST, 'id_perfil', FILTER_SANITIZE_STRING);
                $user->setIdPerfil($perfil);
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $user->setUsername($username);
                $email =    filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

                $userapp = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
                $user->setUserCreate($userapp);

                $snactive =    filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
                $user->setSnActive($snactive);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($keyerrors, "501");
                } else {
                    $user->setEmail($email);
                }

                $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
                if (strlen($password) != 128) {
                    array_push($keyerrors, "502");
                }
                $user->setPassword($password);

                $userstmp = $user->getBy("email", $email);
                if ($userstmp != null && count($userstmp) > 0){
                    array_push($keyerrors, "503");
                }

                $picture = null;
                try {
                    //verificar formato, tamanio y existencia de la imagen
                    if ( !isset($_FILES["image"]) || $_FILES["image"]["error"] > 0){
                        //array_push($keyerrors, "607");
                    } else {
                        $type_img = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                        $size_kb = 1024;

                        if (in_array($_FILES['image']['type'], $type_img) && $_FILES['image']['size'] <= $size_kb * 1024){
                            $image_type = $_FILES['image']['type'];
                            $imagen_temporal  = $_FILES['image']['tmp_name'];
                            $fp     = fopen($imagen_temporal, 'r+b');
                            $picture = fread($fp, filesize($imagen_temporal));
                            fclose($fp);
                            $user->setPicture($picture);
                            $user->setImageType($image_type);
                        } else {
                            array_push($keyerrors, "608");
                        }
                    }
                } catch (Exception $e) {

                }

                if (count($keyerrors) == 0) {
                    $result = $user->save();
                } else {
                    $user->setPassword(null);
                }
            } else{
                array_push($keyerrors, "999");
            }
        } catch (Exception $e){
            array_push($keyerrors, "999");
        }

        if ($result != '') {
            $this->redirect("user", "index");
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "user" => $user,
                "combo" => $this->getCombo(),
                "action" => "Create"
            ));
        }
    }

    public function chstatus(){
        if(isset($_GET["id_user"], $_GET['status'])){
            $id=(int)$_GET["id_user"];
            $status = (string)$_GET['status'];
            $usuario = new User();
            $usuario->changeStatusById($id, $status);
        }
        $this->redirect('user', 'index');
    }

    /**
     *
     */
    public function delete(){
        if(isset($_GET["id_user"])){ 
            $id=(int)$_GET["id_user"];
            $usuario=new User();
            $usuario->inactiveById($id);
        }
        $this->redirect('user', 'index');
    }

    /**
     * Function update settings.
     */
    public function upsetting(){

        $user = new User();
        $keyerrors = [];
        $result = false;

        if (isset($_POST['username'], $_POST['name'], $_POST['id'])) {

            $id =     filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $user->setId($id);

            $name =     filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $user->setName($name);

            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $user->setUsername($username);

            $userapp = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $user->setUserModif($userapp);

            $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
            $institution = filter_input(INPUT_POST, 'institution', FILTER_SANITIZE_STRING);

            if ($location != '') {
                $user->setLocation($location);
            } else{
                $user->setLocation(null);
            }

            if ($institution != '') {
                $user->setInstitution($institution);
            } else{
                $user->setInstitution(null);
            }

            $password = filter_input(INPUT_POST, 'pwr', FILTER_SANITIZE_STRING);

            if ($password != ""){
                // Create a random salt
                $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

                // Create salted password
                $password = hash('sha512', $password . $random_salt);

                // Set password in project
                $user->setPassword($password);
                $user->setSalt($random_salt);
            }else{
                $user->setPassword(null);
                $user->setSalt(null);
            }

            $picture = null;
            $image_type = null;
            try {
                if (!empty($_FILES["image"]["size"])){
                    if ( $_FILES["image"]["error"] > 0){
                        array_push($keyerrors, "607");
                    } else {
                        $type_img = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                        $size_kb = 1024;
                        if (in_array($_FILES['image']['type'], $type_img) && $_FILES['image']['size'] <= $size_kb * 1024){
                            $imagen_temporal  = $_FILES['image']['tmp_name'];
                            $fp     = fopen($imagen_temporal, 'r+b');
                            $picture = fread($fp, filesize($imagen_temporal));
                            $image_type = $_FILES['image']['type'];
                            fclose($fp);
                        } else {
                            array_push($keyerrors, "608");
                        }
                    }
                }
            } catch (Exception $e) {
                trigger_error($e->getMessage(), E_USER_ERROR);
            }

            if ($picture != null){

                $user->setPicture($picture);
                $user->setImageType($image_type);
            }else{
                $user->setPicture(null);
                $user->setImageType(null);
            }

            if (count($keyerrors) == 0) {
                $usermodel = new GlobalModel();
                $result = $usermodel->updateSettingUser($user, $this->table);
            } else {
                $user->setPassword(null);
            }
        } else{
            array_push($keyerrors, "999");
        }

        if ($result >= 0) {
            $this->redirect("project", "show");
        } else {
            $this->view("setting", $this->entity , array(
                "keys" => $keyerrors,
                "user" => $user,
                "combo" => $this->getCombo(),
                "action" => "Update"
            ));
        }
    }

    /**
     *  Function redirect Setting.
     */
    public function setting(){
        $keyerrors = [];
        if(isset($_GET["iu"])){
            $iu = $_GET["iu"];
            $user = new User();
            $user = $user->getById($iu);
        }

        $this->view("setting",$this->entity, array(
            "user"=> $user,
            "action" => "Update",
            "keys" => $keyerrors,
            "combo" => $this->getCombo()
        ));
    }

    
    public function imagesUser(){
        if(isset($_GET["id_user"])){
            $id=(int)$_GET["id_user"];
            
        }
    }

}