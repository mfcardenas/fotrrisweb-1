<?php

/**
 * Class ProjectController
 */
class ProjectController extends ControllerBase{
    
    private $entity;
    private $table;

    /**
     * ProjectController constructor.
     */
    public function __construct() {
        $this->entity = "Project";
        $this->table = "project";
        parent::__construct();
    }

    /**
     *
     */
    public function index($param){
        
        //Creamos el objeto usuario
        $gm = new GlobalModel();
        $class = "Project";
        $pads = [];
        $keywordsA = [];
        $parameter = $this->getParameter($param);
        $id_user =   $parameter[1];
        $type =  $parameter[3];

        if ($type == 3){
            $allproject = $gm->getListProject($class, true, $id_user);
        } else {
        //Conseguimos todos los projectos
            $allproject = $gm->getListProject($class, false);
        }

        if (is_bool($allproject) || $allproject == null || $allproject == '' || count($allproject) == 0){
            $allproject = [];
        }

        //Cargamos la vista index y le pasamos valores
        $this->view("index", $this->entity, array(
            "allproject"=>$allproject,
            "combo" => $this->getCombo(),
            "pads" => $pads,
            "keywords" => $keywordsA,
        ));
    }

    public function show($param){
        $gm = new GlobalModel();
        $class = "Project";
        $pads = [];
        $keywordsA = [];
        $parameter = $this->getParameter($param);
        $id_user =   $parameter[1];
        $type =  $parameter[3];

        if ($type == 3){
            $allproject = $gm->getListProject($class, true, $id_user);
        } else {
            //Conseguimos todos los projectos
            $allproject = $gm->getListProject($class, false);
        }

        if (is_bool($allproject) || $allproject == null || $allproject == '' || count($allproject) == 0){
            $allproject = [];
        }

        //Cargamos la vista index y le pasamos valores
        $this->view("show", $this->entity, array(
            "allproject"=>$allproject,
            "combo" => $this->getCombo(),
            "pads" => $pads,
            "keywords" => $keywordsA,
        ));
    }

    /**
     *
     */
    public function create(){

        //Creamos el objeto usuario
        $project = new Project();
        $filename_setting = "setting.json";
        $keyerrors = [];
        $pads = [];
        $keywordsA = [];
        $result = '';
        if (isset($_POST['name'], $_POST['id_arena'], $_POST['ubication'], $_POST['num_pad'])) {

            #PROJECT --> DATA
            $userapp   = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $name       = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $id_arena   = filter_input(INPUT_POST, 'id_arena', FILTER_SANITIZE_STRING);
            $ubication  = filter_input(INPUT_POST, 'ubication', FILTER_SANITIZE_STRING);
            $desc_proj  = filter_input(INPUT_POST, 'desc_proj', FILTER_SANITIZE_STRING);
            $date_from  = filter_input(INPUT_POST, 'date_from', FILTER_SANITIZE_STRING);
            $date_to    = filter_input(INPUT_POST, 'date_to', FILTER_SANITIZE_STRING);
            $number_pad = filter_input(INPUT_POST, 'num_pad', FILTER_SANITIZE_STRING);
            $sn_active  = filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
            $images = filter_input(INPUT_POST, 'images', FILTER_SANITIZE_STRING);

            if ($images == ''){
                $images = "img_project_01.png";
            }

            $project->setName($name);
            $project->setIdArena($id_arena);
            $project->setUbication($ubication);
            $project->setDescProject($desc_proj);
            $project->setNumPad($number_pad);
            $project->setDateFrom($date_from);
            $project->setDateTo($date_to);
            $project->setSnActive($sn_active);
            $project->setUserCreate($userapp);
            $project->setImages($images);

            #KEYWORDS ---> DATA
            $keywords   = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_STRING);
            $array_keywords = explode(",", $keywords);
            $keywordsA = [];
            if (count($array_keywords) > 0){
                foreach ($array_keywords as $akey){
                    $keyword = new Keywords();
                    $keyword->setKeyword($akey);
                    $keyword->setSnActive($sn_active);
                    $keyword->setUserCreate($userapp);
                    $keywordsA[] = $keyword;
                }
            }

            #PAD --> DATA
            $desc_p1    = filter_input(INPUT_POST, 'desc_p1', FILTER_SANITIZE_STRING);
            $name_p1    = filter_input(INPUT_POST, 'name_p1', FILTER_SANITIZE_STRING);

            $project->setNamePad1($name_p1);
            $project->setDescPad1($desc_p1);

            $i = 1;
            $pad1 = new Pad();
            $pad1->setPadNameView($name_p1);
            $pad1->setFilenameConfig($filename_setting);
            $pad1->setSnActive($sn_active);
            $pad1->setUserCreate($userapp);
            $pad1->setDescription($desc_p1);
            $pad1->setId($i++);
            $pads = [];
            array_push($pads, $pad1);

            if ($date_to == "") {
                $date_to = null;
            }

            $arrayDesc[1] = $desc_p1;
            $arrayName[1] = $name_p1;

            if ($number_pad > 1) {
                $desc_p2 = filter_input(INPUT_POST, 'desc_p2', FILTER_SANITIZE_STRING);
                $name_p2 = filter_input(INPUT_POST, 'name_p2', FILTER_SANITIZE_STRING);
                $project->setNamePad2($name_p2);
                $project->setDescPad2($desc_p2);
                $arrayDesc[2] = $desc_p2;
                $arrayName[2] = $name_p2;
                $pad2 = new Pad();
                $pad2->setPadNameView($name_p2);
                $pad2->setFilenameConfig($filename_setting);
                $pad2->setSnActive($sn_active);
                $pad2->setUserCreate($userapp);
                $pad2->setDescription($desc_p2);
                $pad2->setId($i++);
                array_push($pads, $pad2);
            }

            if ($number_pad > 2) {
                $desc_p3 = filter_input(INPUT_POST, 'desc_p3', FILTER_SANITIZE_STRING);
                $name_p3 = filter_input(INPUT_POST, 'name_p3', FILTER_SANITIZE_STRING);
                $project->setNamePad3($name_p3);
                $project->setDescPad3($desc_p3);
                $arrayDesc[3] = $desc_p3;
                $arrayName[3] = $name_p3;

                $pad3 = new Pad();
                $pad3->setPadNameView($name_p3);
                $pad3->setFilenameConfig($filename_setting);
                $pad3->setSnActive($sn_active);
                $pad3->setUserCreate($userapp);
                $pad3->setDescription($desc_p3);
                $pad3->setId($i++);
                array_push($pads, $pad3);
            }

            if ($number_pad > 3) {
                $desc_p4 = filter_input(INPUT_POST, 'desc_p4', FILTER_SANITIZE_STRING);
                $name_p4 = filter_input(INPUT_POST, 'name_p4', FILTER_SANITIZE_STRING);
                $project->setNamePad4($name_p4);
                $project->setDescPad4($desc_p4);
                $arrayDesc[4] = $desc_p4;
                $arrayName[4] = $name_p4;

                $pad4 = new Pad();
                $pad4->setPadNameView($name_p4);
                $pad4->setFilenameConfig($filename_setting);
                $pad4->setSnActive($sn_active);
                $pad4->setUserCreate($userapp);
                $pad4->setDescription($desc_p4);
                $pad4->setId($i++);
                array_push($pads, $pad4);
            }

            if ($number_pad > 4) {
                $desc_p5 = filter_input(INPUT_POST, 'desc_p5', FILTER_SANITIZE_STRING);
                $name_p5 = filter_input(INPUT_POST, 'name_p5', FILTER_SANITIZE_STRING);
                $project->setNamePad5($name_p5);
                $project->setDescPad5($desc_p5);
                $arrayDesc[5] = $desc_p5;
                $arrayName[5] = $name_p5;

                $pad5 = new Pad();
                $pad5->setPadNameView($name_p5);
                $pad5->setFilenameConfig($filename_setting);
                $pad5->setSnActive($sn_active);
                $pad5->setUserCreate($userapp);
                $pad5->setDescription($desc_p5);
                $pad5->setId($i++);
                array_push($pads, $pad5);
            }

            if ($number_pad > 5) {
                $desc_p6 = filter_input(INPUT_POST, 'desc_p6', FILTER_SANITIZE_STRING);
                $name_p6 = filter_input(INPUT_POST, 'name_p6', FILTER_SANITIZE_STRING);
                $project->setNamePad6($name_p6);
                $project->setDescPad6($desc_p6);
                $arrayDesc[6] = $desc_p6;
                $arrayName[6] = $name_p6;

                $pad6 = new Pad();
                $pad6->setPadNameView($name_p6);
                $pad6->setFilenameConfig($filename_setting);
                $pad6->setSnActive($sn_active);
                $pad6->setUserCreate($userapp);
                $pad6->setDescription($desc_p6);
                $pad6->setId($i++);
                array_push($pads, $pad6);
            }

            if ($number_pad > 6) {
                $desc_p7 = filter_input(INPUT_POST, 'desc_p7', FILTER_SANITIZE_STRING);
                $name_p7 = filter_input(INPUT_POST, 'name_p7', FILTER_SANITIZE_STRING);
                $project->setNamePad7($name_p7);
                $project->setDescPad7($desc_p7);
                $arrayDesc[7] = $desc_p7;
                $arrayName[7] = $name_p7;

                $pad7 = new Pad();
                $pad7->setPadNameView($name_p7);
                $pad7->setFilenameConfig($filename_setting);
                $pad7->setSnActive($sn_active);
                $pad7->setUserCreate($userapp);
                $pad7->setDescription($desc_p7);
                $pad7->setId($i++);
                array_push($pads, $pad7);
            }

            if ($number_pad > 7) {
                $desc_p8 = filter_input(INPUT_POST, 'desc_p8', FILTER_SANITIZE_STRING);
                $name_p8 = filter_input(INPUT_POST, 'name_p8', FILTER_SANITIZE_STRING);
                $project->setNamePad8($name_p8);
                $project->setDescPad8($desc_p8);
                $arrayDesc[8] = $desc_p8;
                $arrayName[8] = $name_p8;

                $pad8 = new Pad();
                $pad8->setPadNameView($name_p8);
                $pad8->setFilenameConfig($filename_setting);
                $pad8->setSnActive($sn_active);
                $pad8->setUserCreate($userapp);
                $pad8->setDescription($desc_p8);
                $pad8->setId($i++);
                array_push($pads, $pad8);
            }

            if ($number_pad > 8) {
                $desc_p9 = filter_input(INPUT_POST, 'desc_p9', FILTER_SANITIZE_STRING);
                $name_p9 = filter_input(INPUT_POST, 'name_p9', FILTER_SANITIZE_STRING);
                $project->setNamePad8($name_p9);
                $project->setDescPad8($desc_p9);
                $arrayDesc[9] = $desc_p9;
                $arrayName[9] = $name_p9;

                $pad9 = new Pad();
                $pad9->setPadNameView($name_p9);
                $pad9->setFilenameConfig($filename_setting);
                $pad9->setSnActive($sn_active);
                $pad9->setUserCreate($userapp);
                $pad9->setDescription($desc_p9);
                $pad9->setId($i++);
                array_push($pads, $pad9);
            }

            if ($number_pad > 9) {
                $desc_p10 = filter_input(INPUT_POST, 'desc_p10', FILTER_SANITIZE_STRING);
                $name_p10 = filter_input(INPUT_POST, 'name_p10', FILTER_SANITIZE_STRING);
                $project->setNamePad8($name_p10);
                $project->setDescPad8($desc_p10);
                $arrayDesc[10] = $desc_p10;
                $arrayName[10] = $name_p10;

                $pad10 = new Pad();
                $pad10->setPadNameView($name_p10);
                $pad10->setFilenameConfig($filename_setting);
                $pad10->setSnActive($sn_active);
                $pad10->setUserCreate($userapp);
                $pad10->setDescription($desc_p10);
                $pad10->setId($i++);
                array_push($pads, $pad10);
            }

            if (empty($error_msg)) {
                $pm = new GlobalModel();
                $result = $pm->createProject($project, $pads, $keywordsA);
            }

        } else {
            $result = "999";
        }

        if ($result == "100") {
            $param = "id_".$_POST['id_user_log']."_type_".$_POST['type'];
            $this->redirect("project", "index", $param);
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "project" => $project,
                "combo" => $this->getCombo(),
                "pads" => $pads,
                "keywords" => $keywordsA,
                "action" => "Create"
            ));
        }

    }

    /**
     *
     */
    public function update(){

        //Creamos el objeto usuario
        $project=new Project();
        $filename_setting = "setting.json";
        $keyerrors = [];
        $pads = [];
        $keywordsA = [];
        $result = '';
        if (isset($_POST['name'], $_POST['id_arena'], $_POST['ubication'], $_POST['num_pad'], $_POST['id'])) {

            #PROJECT --> DATA
            $id         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
            $userapp    = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $name       = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $id_arena   = filter_input(INPUT_POST, 'id_arena', FILTER_SANITIZE_STRING);
            $ubication  = filter_input(INPUT_POST, 'ubication', FILTER_SANITIZE_STRING);
            $desc_proj  = filter_input(INPUT_POST, 'desc_proj', FILTER_SANITIZE_STRING);
            $date_from  = filter_input(INPUT_POST, 'date_from', FILTER_SANITIZE_STRING);
            $date_to    = filter_input(INPUT_POST, 'date_to', FILTER_SANITIZE_STRING);
            $number_pad = filter_input(INPUT_POST, 'num_pad', FILTER_SANITIZE_STRING);
            $sn_active  = filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
            $images  = filter_input(INPUT_POST, 'images', FILTER_SANITIZE_STRING);

            $project->setId($id);
            $project->setName($name);
            $project->setIdArena($id_arena);
            $project->setUbication($ubication);
            $project->setDescProject($desc_proj);
            $project->setNumPad($number_pad);
            $project->setDateFrom($date_from);
            $project->setDateTo($date_to);
            $project->setSnActive($sn_active);
            $project->setUserCreate($userapp);
            $project->setImages($images);
     
            #KEYWORDS ---> DATA
            $keywords   = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_STRING);
            $array_keywords = explode(",", $keywords);
            $project->setKeywords($keywords);

            if (count($array_keywords) > 0){
                foreach ($array_keywords as $akey){
                    $keyword = new Keywords();
                    $keyword->setKeyword($akey);
                    $keyword->setSnActive($sn_active);
                    $keyword->setUserCreate($userapp);
                    $keyword->setIdProject($id);
                    $keywordsA[] = $keyword;
                }
            }

            #PAD --> DATA
            $i = 1;
            $desc_p1    = filter_input(INPUT_POST, 'desc_p1', FILTER_SANITIZE_STRING);
            $name_p1    = filter_input(INPUT_POST, 'name_p1', FILTER_SANITIZE_STRING);
            $project->setNamePad1($name_p1);
            $project->setDescPad1($desc_p1);

            $pad1 = new Pad();
            $pad1->setPadNameView($name_p1);
            $pad1->setFilenameConfig($filename_setting);
            $pad1->setSnActive($sn_active);
            $pad1->setUserCreate($userapp);
            $pad1->setDescription($desc_p1);
            $pad1->setIdProject($id);
            $pad1->setId($i++);

            array_push($pads, $pad1);

            if ($date_to == "") {
                $date_to = null;
            }

            $arrayDesc[1] = $desc_p1;
            $arrayName[1] = $name_p1;

            if ($number_pad > 1) {
                $desc_p2 = filter_input(INPUT_POST, 'desc_p2', FILTER_SANITIZE_STRING);
                $name_p2 = filter_input(INPUT_POST, 'name_p2', FILTER_SANITIZE_STRING);
                $project->setNamePad2($name_p2);
                $project->setDescPad2($desc_p2);
                $arrayDesc[2] = $desc_p2;
                $arrayName[2] = $name_p2;
                $pad2 = new Pad();
                $pad2->setPadNameView($name_p2);
                $pad2->setFilenameConfig($filename_setting);
                $pad2->setSnActive($sn_active);
                $pad2->setUserCreate($userapp);
                $pad2->setDescription($desc_p2);
                $pad2->setIdProject($id);
                $pad2->setId($i++);
                array_push($pads, $pad2);
            }

            if ($number_pad > 2) {
                $desc_p3 = filter_input(INPUT_POST, 'desc_p3', FILTER_SANITIZE_STRING);
                $name_p3 = filter_input(INPUT_POST, 'name_p3', FILTER_SANITIZE_STRING);
                $project->setNamePad3($name_p3);
                $project->setDescPad3($desc_p3);
                $arrayDesc[3] = $desc_p3;
                $arrayName[3] = $name_p3;

                $pad3 = new Pad();
                $pad3->setPadNameView($name_p3);
                $pad3->setFilenameConfig($filename_setting);
                $pad3->setSnActive($sn_active);
                $pad3->setUserCreate($userapp);
                $pad3->setDescription($desc_p3);
                $pad3->setIdProject($id);
                $pad3->setId($i++);
                array_push($pads, $pad3);
            }

            if ($number_pad > 3) {
                $desc_p4 = filter_input(INPUT_POST, 'desc_p4', FILTER_SANITIZE_STRING);
                $name_p4 = filter_input(INPUT_POST, 'name_p4', FILTER_SANITIZE_STRING);
                $project->setNamePad4($name_p4);
                $project->setDescPad4($desc_p4);
                $arrayDesc[4] = $desc_p4;
                $arrayName[4] = $name_p4;

                $pad4 = new Pad();
                $pad4->setPadNameView($name_p4);
                $pad4->setFilenameConfig($filename_setting);
                $pad4->setSnActive($sn_active);
                $pad4->setUserCreate($userapp);
                $pad4->setDescription($desc_p4);
                $pad4->setIdProject($id);
                $pad4->setId($i++);
                array_push($pads, $pad4);
            }

            if ($number_pad > 4) {
                $desc_p5 = filter_input(INPUT_POST, 'desc_p5', FILTER_SANITIZE_STRING);
                $name_p5 = filter_input(INPUT_POST, 'name_p5', FILTER_SANITIZE_STRING);
                $project->setNamePad5($name_p5);
                $project->setDescPad5($desc_p5);
                $arrayDesc[5] = $desc_p5;
                $arrayName[5] = $name_p5;

                $pad5 = new Pad();
                $pad5->setPadNameView($name_p5);
                $pad5->setFilenameConfig($filename_setting);
                $pad5->setSnActive($sn_active);
                $pad5->setUserCreate($userapp);
                $pad5->setDescription($desc_p5);
                $pad5->setIdProject($id);
                $pad5->setId($i++);
                array_push($pads, $pad5);
            }

            if ($number_pad > 5) {
                $desc_p6 = filter_input(INPUT_POST, 'desc_p6', FILTER_SANITIZE_STRING);
                $name_p6 = filter_input(INPUT_POST, 'name_p6', FILTER_SANITIZE_STRING);
                $project->setNamePad6($name_p6);
                $project->setDescPad6($desc_p6);
                $arrayDesc[6] = $desc_p6;
                $arrayName[6] = $name_p6;

                $pad6 = new Pad();
                $pad6->setPadNameView($name_p6);
                $pad6->setFilenameConfig($filename_setting);
                $pad6->setSnActive($sn_active);
                $pad6->setUserCreate($userapp);
                $pad6->setDescription($desc_p6);
                $pad6->setIdProject($id);
                $pad6->setId($i++);
                array_push($pads, $pad6);
            }

            if ($number_pad > 6) {
                $desc_p7 = filter_input(INPUT_POST, 'desc_p7', FILTER_SANITIZE_STRING);
                $name_p7 = filter_input(INPUT_POST, 'name_p7', FILTER_SANITIZE_STRING);
                $project->setNamePad7($name_p7);
                $project->setDescPad7($desc_p7);
                $arrayDesc[7] = $desc_p7;
                $arrayName[7] = $name_p7;

                $pad7 = new Pad();
                $pad7->setPadNameView($name_p7);
                $pad7->setFilenameConfig($filename_setting);
                $pad7->setSnActive($sn_active);
                $pad7->setUserCreate($userapp);
                $pad7->setDescription($desc_p7);
                $pad7->setIdProject($id);
                $pad7->setId($i++);
                array_push($pads, $pad7);
            }

            if ($number_pad > 7) {
                $desc_p8 = filter_input(INPUT_POST, 'desc_p8', FILTER_SANITIZE_STRING);
                $name_p8 = filter_input(INPUT_POST, 'name_p8', FILTER_SANITIZE_STRING);
                $project->setNamePad8($name_p8);
                $project->setDescPad8($desc_p8);
                $arrayDesc[8] = $desc_p8;
                $arrayName[8] = $name_p8;

                $pad8 = new Pad();
                $pad8->setPadNameView($name_p8);
                $pad8->setFilenameConfig($filename_setting);
                $pad8->setSnActive($sn_active);
                $pad8->setUserCreate($userapp);
                $pad8->setDescription($desc_p8);
                $pad8->setIdProject($id);
                $pad8->setId($i++);
                array_push($pads, $pad8);
            }

            if ($number_pad > 8) {
                $desc_p9 = filter_input(INPUT_POST, 'desc_p9', FILTER_SANITIZE_STRING);
                $name_p9 = filter_input(INPUT_POST, 'name_p9', FILTER_SANITIZE_STRING);
                $project->setNamePad8($name_p9);
                $project->setDescPad8($desc_p9);
                $arrayDesc[9] = $desc_p9;
                $arrayName[9] = $name_p9;

                $pad9 = new Pad();
                $pad9->setPadNameView($name_p9);
                $pad9->setFilenameConfig($filename_setting);
                $pad9->setSnActive($sn_active);
                $pad9->setUserCreate($userapp);
                $pad9->setDescription($desc_p9);
                $pad9->setIdProject($id);
                $pad9->setId($i++);
                array_push($pads, $pad9);
            }

            if ($number_pad > 9) {
                $desc_p10 = filter_input(INPUT_POST, 'desc_p10', FILTER_SANITIZE_STRING);
                $name_p10 = filter_input(INPUT_POST, 'name_p10', FILTER_SANITIZE_STRING);
                $project->setNamePad8($name_p10);
                $project->setDescPad8($desc_p10);
                $arrayDesc[10] = $desc_p10;
                $arrayName[10] = $name_p10;

                $pad10 = new Pad();
                $pad10->setPadNameView($name_p10);
                $pad10->setFilenameConfig($filename_setting);
                $pad10->setSnActive($sn_active);
                $pad10->setUserCreate($userapp);
                $pad10->setDescription($desc_p10);
                $pad10->setIdProject($id);
                $pad10->setId($i++);
                array_push($pads, $pad10);
            }

//            $upfile = "true";
//            $msg = "";
//            if (!empty($_FILES['file_img_project']["size"])) {
//                $file_size = $_FILES['file_img_project']["size"];
//
//                $target_file = "img-project/".basename($_FILES["file_img_project"]["name"]);
//                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
//
//                if ($file_size > 200000) {
//                    $msg = $msg."El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo<BR>";
//                    $upfile = "false";
//                }
//
//                $check = getimagesize($_FILES["file_img_project"]["tmp_name"]);
//                if($check == false) {
//                    $msg = $msg." Tu archivo tiene que ser JPG, GIF o PNG. Otros archivos no son permitidos<BR>";
//                    $upfile = "false";
//                }
//
//                $file_name = "img-project-" . $project->getId() .".". $imageFileType;
//
//                if($upfile == "true"){
//                    $add = DOCROOT.'img-project/' . $file_name;
//                    echo $add."\n";
//                    if(move_uploaded_file($_FILES["file_img_project"]["tmp_name"], $add)){
//                        $project->setImages($file_name);
//                        echo "Ha sido subido satisfactoriamente";
//                    }else{
//                        $project->setImages("img_project_sn.png");
//                        echo "Error al subir el archivo";
//                    }
//                }else{
//                    echo $msg;
//                }
//            }

            if (empty($error_msg)) {
                $pm = new GlobalModel();
                $result = $pm->updateProject($project, $pads, $keywordsA);
            }

        } else {
            $keyerrors[] = "999";
        }

        if ($result == "100") {
            $param = "id_".$_POST['id_user_log']."_type_".$_POST['type'];
            $this->redirect("project", "index", $param);
        } else {
            $this->view("create", $this->entity , array(
                "keys" => $keyerrors,
                "project" => $project,
                "combo" => $this->getCombo(),
                "pads" => $pads,
                "keywords" => $keywordsA,
                "action" => "Update"
            ));
        }

    }

    /**
     *
     */
    public function delete(){
        if(isset($_GET["id_project"])){
            $id=(int)$_GET["id_project"];
            $project=new Project();
            $project->inactiveById($id);
        }
        $this->redirect('project', 'index');
    }

    /**
     *
     */
    public function modify(){
        $keyerrors = [];
        //Class PHP Keywords
        $class_keywords = "Keywords";

        if (isset($_GET["id_project"])) {
            $id=(int)$_GET["id_project"];
            $p = new Project();
            $gm = new GlobalModel();
            $ks = $gm->getKeywordsProj($id, $class_keywords);
            if (!is_array($ks)){
                $ks = array();
            }
            $gp = new Pad();
            $gps = $gp->getBy("id_project", $id);

            $proj = $p->getById($id);

            if (count($gps) > 0){
                foreach ($gps as $gptmp){
                    $param_name = "setNamePad".$gptmp->getId();
                    $param_desc = "setDescPad".$gptmp->getId();
                    $proj->$param_name($gptmp->getPadNameView());
                    $proj->$param_desc($gptmp->getDescription());
                }
            }
            $this->view("create", $this->entity, array(
                "project" => $proj,
                "keys" => $keyerrors,
                "combo" => $this->getCombo(),
                "action" => "Update",
                "keywords" => $ks
            ));

        }
    }

    /**
     * @return mixed
     */
    public function add(){
        $keyerrors = [];
        $proj = new Project();
        $keywords = [];
        $this->view("create",$this->entity, array(
            "project"=>$proj,
            "combo" => $this->getCombo(),
            "keys" => $keyerrors,
            "action" => "Create",
            "keywords" => $keywords
        ));

    }

    /**
     * @return mixed
     */
    public function chstatus($param){
        if(isset($_GET["id_project"], $_GET['status'])){
            $id=(int)$_GET["id_project"];
            $status = (string)$_GET['status'];
            $proj = new Project();
            $proj->changeStatusById($id, $status);
        }
        $this->redirect('project', 'index', $param);
    }

    public function join(){
        if(isset($_GET["id_project"], $_GET['id_user'], $_GET['nam'])){
            $id_project = (int)$_GET["id_project"];
            $id_user = (int)$_GET["id_user"];
            $user = (String)$_GET["nam"];
            $assign = new Assign();
            $assign->setIdUser($id_user);
            $assign->setIdProject($id_project);
            $date_from = new DateTime();
            $assign->setDateFrom(date_format($date_from, 'd/m/Y'));
            $date_to = $date_from->add(new DateInterval('P0Y12M0DT23H59M59S'));
            $assign->setDateTo(date_format($date_to, 'd/m/Y'));
            $assign->setUserCreate($user);
            $assign->setSnActive('N');
            $assign->save();
        }
        $this->redirect('project', 'show');

    }

    }

