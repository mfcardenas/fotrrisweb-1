<?php

/**
 * Class PerfilController
 */
class PerfilController extends ControllerBase{
    
    private $entity;
    private $table;

    /**
     * PerfilController constructor.
     */
    public function __construct() {
        $this->entity = "Perfil";
        $this->table = "perfil";
        parent::__construct();
    }

    /**
     *
     */
    public function index(){
        
        //Creamos el objeto usuario
        $perfil=new Perfil();

        //Conseguimos todos los perfiles
        $allperfil=$perfil->getAll();

        if (is_bool($allperfil) || $allperfil == null || $allperfil == '' || count($allperfil) == 0){
            $allperfil = [];
        }

        //Cargamos la vista index y le pasamos valores
        $this->view("index", $this->entity, array(
            "allperfil"=>$allperfil,
            "combo" => $this->getCombo()
        ));
    }

    /**
     *
     */
    public function create(){

        $perfil = new Perfil();
        $keyerrors = [];
        $result = "";

        try {
            if (isset($_POST['name'], $_POST['type'], $_POST['sn_active'])) {
                
                $name =     filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $perfil->setName($name);

                $type =   filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
                $perfil->setType($type);

                $snactive =    filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
                $perfil->setSnActive($snactive);

                $user =  filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
                $perfil->setUserCreate($user);

                $result = $perfil->save();
            } else{
                array_push($keyerrors, "999");
            }
        } catch (Exception $e){
            array_push($keyerrors, "999");
        }

        if ($result == "100") {
            $this->redirect("perfil", "index");
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "perfil" => $perfil,
                "combo" => $this->getCombo(),
                "action" => "Create"
            ));
        }
    }

    /**
     *
     */
    public function update(){

        $perfil = new Perfil();
        $keyerrors = [];
        $result = 0;

        try {
            if (isset($_POST['name'], $_POST['type'], $_POST['sn_active'], $_POST['id'])) {

                $name =     filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $perfil->setName($name);

                $type =   filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
                $perfil->setType($type);

                $snactive =    filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
                $perfil->setSnActive($snactive);

                $id =  filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
                $perfil->setId($id);

                $user =  filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
                $perfil->setUserModif($user);

                $result = $this->getGm()->updatePerfil($perfil, $this->table);

            } else{
                array_push($keyerrors, "999");
            }
        } catch (Exception $e){
            array_push($keyerrors, "999");
        }

        if ($result >= 0) {
            $this->redirect("perfil", "index");
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "perfil" => $perfil,
                "combo" => $this->getCombo(),
                "action" => "Update"
            ));
        }
    }

    /**
     *
     */
    public function modify(){
        $keyerrors = [];

        if (isset($_GET["id_perfil"])) {
            $id=(int)$_GET["id_perfil"];
            $p = new Perfil();
            $perfil = $p->getById($id);
            $this->view("create", $this->entity, array(
                "perfil" => $perfil,
                "keys" => $keyerrors,
                "combo" => $this->getCombo(),
                "action" => "Update"
            ));

        }
    }


    /**
     *
     */
    public function delete(){
        if(isset($_GET["id_perfil"])){
            $id=(int)$_GET["id_perfil"];
            $perfil=new Perfil();
            $perfil->inactiveById($id);
        }
        $this->redirect('perfil', 'index');
    }

    /**
     * @return mixed
     */
    public function add(){
        $keyerrors = [];
        $perfil = new Perfil();
        $this->view("create",$this->entity, array(
            "perfil"=>$perfil,
            "combo" => $this->getCombo(),
            "keys" => $keyerrors,
            "action" => "Create"
        ));

    }

    /**
     * @return mixed
     */
    public function chstatus(){
        if(isset($_GET["id_perfil"], $_GET['status'])){
            $id=(int)$_GET["id_perfil"];
            $status = (string)$_GET['status'];
            $perfil = new Perfil();
            $perfil->changeStatusById($id, $status);
        }
        $this->redirect('perfil', 'index');
    }


}
?>
