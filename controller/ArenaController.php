<?php

/**
 * Class ArenaController
 */
class ArenaController extends ControllerBase{
    
    private $entity;
    private $table;

    /**
     * ArenaController constructor.
     */
    public function __construct() {
        $this->entity = "Arena";
        $this->table = "arena";
        parent::__construct();
    }

    /**
     *
     */
    public function index(){
        
        $class = "Arena";
        //Conseguimos todos las arenas
        $allarena = $this->getGm()->getListArenas($class);
        if (is_bool($allarena) || $allarena == null || $allarena == '' || count($allarena) == 0){
            $allarena = [];
        }

        //Cargamos la vista index y le pasamos valores
        $this->view("index", $this->entity, array(
            "allarena"=>$allarena,
            "combo" => $this->getCombo()
        ));
    }

    public function add(){
        $keyerrors = [];
        $arena = new Arena();
        $this->view("create",$this->entity, array(
            "arena"=>$arena,
            "combo" => $this->getCombo(),
            "keys" => $keyerrors,
            "action" => "Create"
        ));

    }

    public function modify(){
        $keyerrors = [];

        if (isset($_GET["id_arena"])) {
            $id=(int)$_GET["id_arena"];
            $arena = new Arena();
            $arenas = $arena->getById($id);
            $user_list = $this->__getListManager($id);
            $arenas->setIdUserList($user_list);
            //echo "-------".$user_list;
            $this->view("create", $this->entity, array(
                "arena" => $arenas,
                "keys" => $keyerrors,
                "combo" => $this->getCombo(),
                "action" => "Update"
            ));

        }
    }

    private function __getListManager($id_arena){
        $am = new ArenaManager();
        $id_user_list = "";

        $allam = $am->getBy($column="id_arena", $id_arena);
        if (!is_array($allam) || empty($allam)){
            $allam = [];
        }
        foreach ($allam as $am_){
            $id_user_list = $id_user_list.$am_->getIdUser().",";
        }
        return $id_user_list;
    }

    public function update() {
        $arena = new Arena();
        $keyerrors = [];
        $result = 0;

        if (isset($_POST['name'], $_POST['address'], $_POST['place'], $_POST['responsable'], $_POST['id'], $_POST['sn_active'])) {
            $id =     filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $arena->setId($id);
            $name =     filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $arena->setName($name);
            $responsable =   filter_input(INPUT_POST, 'responsable', FILTER_SANITIZE_STRING);
            $arena->setResponsable($responsable);
            $place = filter_input(INPUT_POST, 'place', FILTER_SANITIZE_STRING);
            $arena->setPlace($place);
            $address =    filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
            $arena->setAddress($address);
            $snactive =    filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
            $arena->setSnActive($snactive);
            $user =     filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $arena->setUserModif($user);
            $id_user_list =     filter_input(INPUT_POST, 'id_user_list', FILTER_SANITIZE_STRING);

            $result = $this->getGm()->updateArena($arena, $this->table);

            $list_user = explode(",", $id_user_list);
            $result_am = "";

            $am = new ArenaManager();
            $am->deleteBy($column="id_arena", $arena->getId());

            foreach ($list_user as $user_){
                if ($user_ != "") {
                    $am = new ArenaManager();
                    $am->setIdArena($arena->getId());
                    $am->setIdUser($user_);
                    $am->setUserCreate($user);
                    $am->setSnActive('S');
                    $result_am = $result_am. "-". $am->save();
                }
            }

            //echo "-------------".$result."-AM: ".$result_am;
        } else{
            array_push($keyerrors, "999");
        }

        if ($result >= 0) {
            $this->redirect("arena", "index");
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "arena" => $arena,
                "combo" => $this->getCombo(),
                "action" => "Update"
            ));
        }
    }


    /**
     * Create Arena.
     */
    public function create(){

        $arena = new Arena();
        $keyerrors = [];
        $result = "";

        if (isset($_POST['name'], $_POST['address'], $_POST['place'], $_POST['responsable'], $_POST['sn_active'])) {
            $name =     filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $arena->setName($name);
            $responsable =   filter_input(INPUT_POST, 'responsable', FILTER_SANITIZE_STRING);
            $arena->setResponsable($responsable);
            $place = filter_input(INPUT_POST, 'place', FILTER_SANITIZE_STRING);
            $arena->setPlace($place);
            $address =    filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
            $arena->setAddress($address);
            $snactive =    filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
            $arena->setSnActive($snactive);
            $user =     filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $arena->setUserCreate($user);

            $id_user_list =     filter_input(INPUT_POST, 'id_user_list', FILTER_SANITIZE_STRING);
            $arena->setIdUserList($id_user_list);


            $result = $arena->save();
            $list_user = explode(",", $id_user_list);
            $result_am = "";

            foreach ($list_user as $user_){
                if ($user_ != "") {
                    $am = new ArenaManager();
                    $am->setIdArena($arena->getId());
                    $am->setIdUser($user_);
                    $am->setUserCreate($user);
                    $am->setSnActive('S');
                    $result_am = $result_am. "-". $am->save();
                }
            }

            //echo "-------------".$result."-AM: ".$result_am;
        }else{
            array_push($keyerrors, "999");
        }

        if ($result == "100") {
            $this->redirect("arena", "index");
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "arena" => $arena,
                "combo" => $this->getCombo(),
                "action" => "Create"
            ));
        }
    }

    /**
     * Change Status Arena.
     */
    public function chstatus(){
        if(isset($_GET["id_arena"], $_GET['status'])){
            $id=(int)$_GET["id_arena"];
            $status = (string)$_GET['status'];
            $arena = new Arena();
            $arena->changeStatusById($id, $status);
        }
        $this->redirect('arena', 'index');
    }

    /**
     *
     */
    public function delete(){
        if(isset($_GET["id_arena"])){
            $id=(int)$_GET["id_arena"];
            $arena=new Arena();
            $arena->inactiveById($id);
        }
        $this->redirect('arena', 'index');
    }
    
    
    public function manager(){
        if(isset($_GET["id_user"])){
            $id_user =  $_GET["id_user"];
            $this->getGm()->setManagerArena($id_user, "arena");
        }
    }

}
?>
