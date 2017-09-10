<?php

/**
 * Class AssignController
 */
class AssignController extends ControllerBase{
    
    private $entity;
    private $table;

    /**
     * AssignController constructor.
     */
    public function __construct() {
        $this->entity = "Assign";
        $this->table = "assigned_project_user";
        parent::__construct();
    }

    /**
     *
     */
    public function index($param){
        //Creamos el objeto usuario
        $assign=new Assign();
        $parameter = $this->getParameter($param);
        $id_user =   $parameter[1];
        $type =  $parameter[3];
        $class = "Assign";
        if ($type == 3){
            $allassign=$this->getGm()->getAssignProject($id_user, $class, true);
            // echo "-------getAssignProjectManager";
        }else{
            $allassign=$this->getGm()->getAssignProject($id_user, $class, false);
            // echo "-------getAll";
        }
        
        if (is_bool($allassign) || $allassign == null || $allassign == '' || count($allassign) == 0){
            $allassign = [];
        }

        //Cargamos la vista index y le pasamos valores
        $this->view("index", $this->entity, array(
            "allassign"=>$allassign,
            "combo" => $this->getCombo()
        ));
    }

    /**
     *
     */
    public function create(){
        $assign = new Assign();
        $keyerrors = [];
        $result = "";

        try {
            if (isset($_POST['id_project'], $_POST['id_user'], $_POST['sn_active'], $_POST['date_from'])) {
                
                $id_project = filter_input(INPUT_POST, 'id_project', FILTER_SANITIZE_STRING);
                $assign->setIdProject($id_project);

                $id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
                $assign->setIdUser($id_user);

                $snactive = filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
                $assign->setSnActive($snactive);

                $datefrom = filter_input(INPUT_POST, 'date_from', FILTER_SANITIZE_STRING);
                $assign->setDateFrom($datefrom);

                $dateto = filter_input(INPUT_POST, 'date_to', FILTER_SANITIZE_STRING);
                $assign->setDateTo($dateto);

                $user = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
                $assign->setUserCreate($user);

                $result = $assign->save();
            } else{
                array_push($keyerrors, "999");
            }
        } catch (Exception $e){
            array_push($keyerrors, "999");
        }

        if ($result == "100") {
            $param = "id_".$_POST['id_user_log']."_type_".$_POST['type'];
            $this->redirect("assign", "index", $param);
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "assign" => $assign,
                "combo" => $this->getCombo(),
                "action" => "Create"
            ));
        }
    }

    /**
     *
     */
    public function update(){
        $assign = new assign();
        $keyerrors = [];
        $result = 0;

        try {
            if (isset($_POST['id_project'], $_POST['id_user'], $_POST['sn_active'], $_POST['date_from'], $_POST['id'])) {

                $id_project =     filter_input(INPUT_POST, 'id_project', FILTER_SANITIZE_STRING);
                $assign->setIdProject($id_project);

                $id_user =   filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
                $assign->setIdUser($id_user);

                $snactive =    filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
                $assign->setSnActive($snactive);

                $datefrom =    filter_input(INPUT_POST, 'date_from', FILTER_SANITIZE_STRING);
                $assign->setDateFrom($datefrom);

                $dateto =    filter_input(INPUT_POST, 'date_to', FILTER_SANITIZE_STRING);
                $assign->setDateTo($dateto);

                $id =  filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
                $assign->setId($id);

                $user =  filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
                $assign->setUserModif($user);

                //$pm = new GlobalModel();
                $result = $this->getGm()->updateAssign($assign, $this->table);

            } else{
                array_push($keyerrors, "999");
            }
        } catch (Exception $e){
            array_push($keyerrors, "999");
        }

        if ($result >= 0) {
            $param = "id_".$_POST['id_user_log']."_type_".$_POST['type'];
            $this->redirect("assign", "index", $param);
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "assign" => $assign,
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
        if (isset($_GET["id_assign"])) {
            $id=(int)$_GET["id_assign"];
            $p = new assign();
            $assign = $p->getById($id);
            $this->view("create", $this->entity, array(
                "assign" => $assign,
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
        if(isset($_GET["id_assign"])){
            $id=(int)$_GET["id_assign"];
            $assign=new assign();
            $assign->deleteById($id);
        }
        $this->redirect('assign', 'index');
    }

    /**
     * @return mixed
     */
    public function add(){
        $keyerrors = [];
        $assign = new assign();
        $this->view("create",$this->entity, array(
            "assign"=>$assign,
            "combo" => $this->getCombo(),
            "keys" => $keyerrors,
            "action" => "Create"
        ));
    }

    /**
     * @return mixed
     */
    public function chstatus($param){
        if(isset($_GET["id_assign"], $_GET['status'])){
            $id=(int)$_GET["id_assign"];
            $status = (string)$_GET['status'];
            $assign = new assign();
            $assign->changeStatusById($id, $status);
        }
        $this->redirect('assign', 'index', $param);
    }
}
?>
