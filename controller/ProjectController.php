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
        
        $class = "Project";
        $pads = [];
        $keywordsA = [];
        $parameter = $this->getParameter($param);
        $id_user =   $parameter[1];
        $type =  $parameter[3];

        if ($type == 3){
            $allproject = $this->getGm()->getListProject($class, true, $id_user);
        } else {
        //Conseguimos todos los projectos
            $allproject = $this->getGm()->getListProject($class, false);
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
            "gm" => $this->getGm()
        ));
    }

    public function show($param){
        $class = "Project";
        $pads = [];
        $keywordsA = [];
        $parameter = $this->getParameter($param);
        $id_user =   $parameter[1];
        $type =  $parameter[3];

        if ($type == 3){
            $allproject = $this->getGm()->getListProject($class, true, $id_user);
        } else {
            //Conseguimos todos los projectos
            $allproject = $this->getGm()->getListProject($class, false);
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
            "gm" => $this->getGm()
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
            $userapp    = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $name       = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $id_arena   = filter_input(INPUT_POST, 'id_arena', FILTER_SANITIZE_STRING);
            $ubication  = filter_input(INPUT_POST, 'ubication', FILTER_SANITIZE_STRING);
            $desc_proj  = filter_input(INPUT_POST, 'desc_proj', FILTER_SANITIZE_STRING);
            $date_from  = filter_input(INPUT_POST, 'date_from', FILTER_SANITIZE_STRING);
            $date_to    = filter_input(INPUT_POST, 'date_to', FILTER_SANITIZE_STRING);
            $number_pad = filter_input(INPUT_POST, 'num_pad', FILTER_SANITIZE_STRING);
            $sn_active  = filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
            $sn_abstract    = filter_input(INPUT_POST, 'abstract', FILTER_SANITIZE_STRING);
            $sn_repository  = filter_input(INPUT_POST, 'repository', FILTER_SANITIZE_STRING);
            $images         = filter_input(INPUT_POST, 'images', FILTER_SANITIZE_STRING);

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
            $project->setSnAbstract($sn_abstract);
            $project->setSnRepository($sn_repository);
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
            $i = 1;
            $desc_p1    = filter_input(INPUT_POST, 'desc_p1', FILTER_SANITIZE_STRING);
            $name_p1    = filter_input(INPUT_POST, 'name_p1', FILTER_SANITIZE_STRING);
            $project->setNamePad1($name_p1);
            $project->setDescPad1($desc_p1);

            $padAb = new Pad();
            $padAb->setPadNameView("Public Abstract");
            $padAb->setFilenameConfig($filename_setting);
            $padAb->setSnActive($sn_abstract);
            $padAb->setUserCreate($userapp);
            $padAb->setDescription("Abstract Project");
            $padAb->setType(PAD_ABS);
            $padAb->setId(90);
            array_push($pads, $padAb);

            $padRe = new Pad();
            $padRe->setPadNameView("Repository");
            $padRe->setFilenameConfig($filename_setting);
            $padRe->setSnActive($sn_repository);
            $padRe->setUserCreate($userapp);
            $padRe->setDescription("Repository Project");
            $padRe->setType(PAD_REP);
            $padRe->setId(91);
            array_push($pads, $padRe);

            $pad1 = new Pad();
            $pad1->setPadNameView($name_p1);
            $pad1->setFilenameConfig($filename_setting);
            $pad1->setSnActive($sn_active);
            $pad1->setUserCreate($userapp);
            $pad1->setDescription($desc_p1);
            $pad1->setType(PAD_CON);
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
                $pad2->setType(PAD_CON);
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
                $pad3->setType(PAD_CON);
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
                $pad4->setType(PAD_CON);
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
                $pad5->setType(PAD_CON);
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
                $pad6->setType(PAD_CON);
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
                $pad7->setType(PAD_CON);
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
                $pad8->setType(PAD_CON);
                $pad8->setId($i++);
                array_push($pads, $pad8);
            }

            if ($number_pad > 8) {
                $desc_p9 = filter_input(INPUT_POST, 'desc_p9', FILTER_SANITIZE_STRING);
                $name_p9 = filter_input(INPUT_POST, 'name_p9', FILTER_SANITIZE_STRING);
                $project->setNamePad9($name_p9);
                $project->setDescPad9($desc_p9);
                $arrayDesc[9] = $desc_p9;
                $arrayName[9] = $name_p9;

                $pad9 = new Pad();
                $pad9->setPadNameView($name_p9);
                $pad9->setFilenameConfig($filename_setting);
                $pad9->setSnActive($sn_active);
                $pad9->setUserCreate($userapp);
                $pad9->setDescription($desc_p9);
                $pad9->setType(PAD_CON);
                $pad9->setId($i++);
                array_push($pads, $pad9);
            }

            if ($number_pad > 9) {
                $desc_p10 = filter_input(INPUT_POST, 'desc_p10', FILTER_SANITIZE_STRING);
                $name_p10 = filter_input(INPUT_POST, 'name_p10', FILTER_SANITIZE_STRING);
                $project->setNamePad10($name_p10);
                $project->setDescPad10($desc_p10);
                $arrayDesc[10] = $desc_p10;
                $arrayName[10] = $name_p10;

                $pad10 = new Pad();
                $pad10->setPadNameView($name_p10);
                $pad10->setFilenameConfig($filename_setting);
                $pad10->setSnActive($sn_active);
                $pad10->setUserCreate($userapp);
                $pad10->setDescription($desc_p10);
                $pad10->setType(PAD_CON);
                $pad10->setId($i++);
                array_push($pads, $pad10);
            }

            if ($number_pad > 10) {
                $desc_p11 = filter_input(INPUT_POST, 'desc_p11', FILTER_SANITIZE_STRING);
                $name_p11 = filter_input(INPUT_POST, 'name_p11', FILTER_SANITIZE_STRING);
                $project->setNamePad11($name_p11);
                $project->setDescPad11($desc_p11);
                $arrayDesc[11] = $desc_p11;
                $arrayName[11] = $name_p11;

                $pad11 = new Pad();
                $pad11->setPadNameView($name_p11);
                $pad11->setFilenameConfig($filename_setting);
                $pad11->setSnActive($sn_active);
                $pad11->setUserCreate($userapp);
                $pad11->setDescription($desc_p11);
                $pad11->setType(PAD_CON);
                $pad11->setId($i++);
                array_push($pads, $pad11);
            }

            if ($number_pad > 11) {
                $desc_p12 = filter_input(INPUT_POST, 'desc_p12', FILTER_SANITIZE_STRING);
                $name_p12 = filter_input(INPUT_POST, 'name_p12', FILTER_SANITIZE_STRING);
                $project->setNamePad12($name_p12);
                $project->setDescPad12($desc_p12);
                $arrayDesc[12] = $desc_p12;
                $arrayName[12] = $name_p12;

                $pad12 = new Pad();
                $pad12->setPadNameView($name_p12);
                $pad12->setFilenameConfig($filename_setting);
                $pad12->setSnActive($sn_active);
                $pad12->setUserCreate($userapp);
                $pad12->setDescription($desc_p12);
                $pad12->setType(PAD_CON);
                $pad12->setId($i++);
                array_push($pads, $pad12);
            }

            if ($number_pad > 12) {
                $desc_p13 = filter_input(INPUT_POST, 'desc_p13', FILTER_SANITIZE_STRING);
                $name_p13 = filter_input(INPUT_POST, 'name_p13', FILTER_SANITIZE_STRING);
                $project->setNamePad13($name_p13);
                $project->setDescPad13($desc_p13);
                $arrayDesc[13] = $desc_p13;
                $arrayName[13] = $name_p13;

                $pad13 = new Pad();
                $pad13->setPadNameView($name_p13);
                $pad13->setFilenameConfig($filename_setting);
                $pad13->setSnActive($sn_active);
                $pad13->setUserCreate($userapp);
                $pad13->setDescription($desc_p13);
                $pad13->setType(PAD_CON);
                $pad13->setId($i++);
                array_push($pads, $pad13);
            }

            if ($number_pad > 13) {
                $desc_p14 = filter_input(INPUT_POST, 'desc_p14', FILTER_SANITIZE_STRING);
                $name_p14 = filter_input(INPUT_POST, 'name_p14', FILTER_SANITIZE_STRING);
                $project->setNamePad14($name_p14);
                $project->setDescPad14($desc_p14);
                $arrayDesc[14] = $desc_p14;
                $arrayName[14] = $name_p14;

                $pad14 = new Pad();
                $pad14->setPadNameView($name_p14);
                $pad14->setFilenameConfig($filename_setting);
                $pad14->setSnActive($sn_active);
                $pad14->setUserCreate($userapp);
                $pad14->setDescription($desc_p14);
                $pad14->setType(PAD_CON);
                $pad14->setId($i++);
                array_push($pads, $pad14);
            }

            if ($number_pad > 15) {
                $desc_p15 = filter_input(INPUT_POST, 'desc_p15', FILTER_SANITIZE_STRING);
                $name_p15 = filter_input(INPUT_POST, 'name_p15', FILTER_SANITIZE_STRING);
                $project->setNamePad15($name_p15);
                $project->setDescPad15($desc_p15);
                $arrayDesc[15] = $desc_p15;
                $arrayName[15] = $name_p15;

                $pad15 = new Pad();
                $pad15->setPadNameView($name_p15);
                $pad15->setFilenameConfig($filename_setting);
                $pad15->setSnActive($sn_active);
                $pad15->setUserCreate($userapp);
                $pad15->setDescription($desc_p15);
                $pad15->setType(PAD_CON);
                $pad15->setId($i++);
                array_push($pads, $pad15);
            }

            if (empty($error_msg)) {
                $result = $this->getGm()->createProject($project, $pads, $keywordsA);
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
            $sn_abstract    = filter_input(INPUT_POST, 'abstract', FILTER_SANITIZE_STRING);
            $sn_repository  = filter_input(INPUT_POST, 'repository', FILTER_SANITIZE_STRING);
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
            $project->setSnAbstract($sn_abstract);
            $project->setSnRepository($sn_repository);
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

            $padAb = new Pad();
            $padAb->setPadNameView("Public Abstract");
            $padAb->setFilenameConfig($filename_setting);
            $padAb->setSnActive($sn_abstract);
            $padAb->setUserCreate($userapp);
            $padAb->setDescription("Abstract Project");
            $padAb->setType(PAD_ABS);
            $padAb->setIdProject($id);
            $padAb->setId(90);
            array_push($pads, $padAb);

            $padRe = new Pad();
            $padRe->setPadNameView("Repository");
            $padRe->setFilenameConfig($filename_setting);
            $padRe->setSnActive($sn_repository);
            $padRe->setUserCreate($userapp);
            $padRe->setDescription("Repository Project");
            $padRe->setType(PAD_REP);
            $padRe->setIdProject($id);
            $padRe->setId(91);
            array_push($pads, $padRe);

            $pad1 = new Pad();
            $pad1->setPadNameView($name_p1);
            $pad1->setFilenameConfig($filename_setting);
            $pad1->setSnActive($sn_active);
            $pad1->setUserCreate($userapp);
            $pad1->setDescription($desc_p1);
            $pad1->setType(PAD_CON);
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
                $pad2->setType(PAD_CON);
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
                $pad3->setType(PAD_CON);
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
                $pad4->setType(PAD_CON);
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
                $pad5->setType(PAD_CON);
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
                $pad6->setType(PAD_CON);
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
                $pad7->setType(PAD_CON);
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
                $pad8->setType(PAD_CON);
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
                $pad9->setType(PAD_CON);
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
                $pad10->setType(PAD_CON);
                $pad10->setIdProject($id);
                $pad10->setId($i++);
                array_push($pads, $pad10);
            }

            if ($number_pad > 10) {
                $desc_p11 = filter_input(INPUT_POST, 'desc_p11', FILTER_SANITIZE_STRING);
                $name_p11 = filter_input(INPUT_POST, 'name_p11', FILTER_SANITIZE_STRING);
                $project->setNamePad11($name_p11);
                $project->setDescPad11($desc_p11);
                $arrayDesc[11] = $desc_p11;
                $arrayName[11] = $name_p11;

                $pad11 = new Pad();
                $pad11->setPadNameView($name_p11);
                $pad11->setFilenameConfig($filename_setting);
                $pad11->setSnActive($sn_active);
                $pad11->setUserCreate($userapp);
                $pad11->setDescription($desc_p11);
                $pad11->setType(PAD_CON);
                $pad11->setId($i++);
                array_push($pads, $pad11);
            }

            if ($number_pad > 11) {
                $desc_p12 = filter_input(INPUT_POST, 'desc_p12', FILTER_SANITIZE_STRING);
                $name_p12 = filter_input(INPUT_POST, 'name_p12', FILTER_SANITIZE_STRING);
                $project->setNamePad12($name_p12);
                $project->setDescPad12($desc_p12);
                $arrayDesc[12] = $desc_p12;
                $arrayName[12] = $name_p12;

                $pad12 = new Pad();
                $pad12->setPadNameView($name_p12);
                $pad12->setFilenameConfig($filename_setting);
                $pad12->setSnActive($sn_active);
                $pad12->setUserCreate($userapp);
                $pad12->setDescription($desc_p12);
                $pad12->setType(PAD_CON);
                $pad12->setId($i++);
                array_push($pads, $pad12);
            }

            if ($number_pad > 12) {
                $desc_p13 = filter_input(INPUT_POST, 'desc_p13', FILTER_SANITIZE_STRING);
                $name_p13 = filter_input(INPUT_POST, 'name_p13', FILTER_SANITIZE_STRING);
                $project->setNamePad13($name_p13);
                $project->setDescPad13($desc_p13);
                $arrayDesc[13] = $desc_p13;
                $arrayName[13] = $name_p13;

                $pad13 = new Pad();
                $pad13->setPadNameView($name_p13);
                $pad13->setFilenameConfig($filename_setting);
                $pad13->setSnActive($sn_active);
                $pad13->setUserCreate($userapp);
                $pad13->setDescription($desc_p13);
                $pad13->setType(PAD_CON);
                $pad13->setId($i++);
                array_push($pads, $pad13);
            }

            if ($number_pad > 13) {
                $desc_p14 = filter_input(INPUT_POST, 'desc_p14', FILTER_SANITIZE_STRING);
                $name_p14 = filter_input(INPUT_POST, 'name_p14', FILTER_SANITIZE_STRING);
                $project->setNamePad14($name_p14);
                $project->setDescPad14($desc_p14);
                $arrayDesc[14] = $desc_p14;
                $arrayName[14] = $name_p14;

                $pad14 = new Pad();
                $pad14->setPadNameView($name_p14);
                $pad14->setFilenameConfig($filename_setting);
                $pad14->setSnActive($sn_active);
                $pad14->setUserCreate($userapp);
                $pad14->setDescription($desc_p14);
                $pad14->setType(PAD_CON);
                $pad14->setId($i++);
                array_push($pads, $pad14);
            }

            if ($number_pad > 15) {
                $desc_p15 = filter_input(INPUT_POST, 'desc_p15', FILTER_SANITIZE_STRING);
                $name_p15 = filter_input(INPUT_POST, 'name_p15', FILTER_SANITIZE_STRING);
                $project->setNamePad15($name_p15);
                $project->setDescPad15($desc_p15);
                $arrayDesc[15] = $desc_p15;
                $arrayName[15] = $name_p15;

                $pad15 = new Pad();
                $pad15->setPadNameView($name_p15);
                $pad15->setFilenameConfig($filename_setting);
                $pad15->setSnActive($sn_active);
                $pad15->setUserCreate($userapp);
                $pad15->setDescription($desc_p15);
                $pad15->setType(PAD_CON);
                $pad15->setId($i++);
                array_push($pads, $pad15);
            }

            if (empty($error_msg)) {
                echo "UPDATE PROJECT PAD" . "\n";
                $result = $this->getGm()->updateProject($project, $pads, $keywordsA);
                echo $result . "\n";
            }

        } else {
            array_push($keyerrors, 999);
        }

        if ($result == "100") {
            $param = "id_".$_POST['id_user_log']."_type_".$_POST['type'];
            $this->redirect("project", "index", $param);
        } else {
            array_push($keyerrors, $result);
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
            $ks = $this->getGm()->getKeywordsProj($id, $class_keywords);
            if (!is_array($ks)){
                $ks = array();
            }
            $gp = new Pad();
            $gps = $gp->getBy("id_project", $id);

            $proj = $p->getById($id);

            if (count($gps) > 0){
                foreach ($gps as $gptmp){
                    if ($gptmp->getType() == 'CON'){
                        $param_name = "setNamePad".$gptmp->getId();
                        $param_desc = "setDescPad".$gptmp->getId();
                        $proj->$param_name($gptmp->getPadNameView());
                        $proj->$param_desc($gptmp->getDescription());
                    }
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

