<?php
class GlobalModel extends ModelBase{
    private $table;
    
    public function __construct(){
        $this->table="User";
        parent::__construct($this->table);
    }
    
    //Metodos de consulta
    public function getUnUsuario(){
        $query="SELECT * FROM USER WHERE email='pepe@ucm.es'";
        $usuario=$this->ejecutarSql($query);
        return $usuario;
    }

    public function updateUser($user, $table){
        $ret = -1;
        $query = $this->fluent()->update($table, array(
            "name" => $user->getName(),
            "username" => $user->getUserName(),
            "email" => $user->getEmail(),
            "id_perfil" => $user->getIdPerfil(),
            "sn_active" => $user->getSnActive(),
            "date_modif" => $this->getToDay(),
            "user_modif" => $user->getUserModif()
        ), $user->getId());
        $ret = $query->execute();

        if ($user->getPassword() != null) {
            echo "Pass Assing -> ".$user->getPassword();
            $query = $this->fluent()->update($table, array(
                "password" => $user->getPassword(),
                "salt" => $user->getSalt(),
                "date_modif" => $this->getToDay(),
                "user_modif" => $user->getUserModif()
            ), $user->getId());
            $qpass = $query->execute();
            $ret = $ret + $qpass;
        }
        return $ret;
    }

    /**
     *
     * @param $user
     * @param $table
     * @return bool|int|PDOStatement
     */
    public function updatePassword($user, $table){
        if ($user->getPassword() != null) {
            $query = $this->fluent()->update($table, array(
                "password" => $user->getPassword(),
                "salt" => $user->getSalt(),
                "date_modif" => $this->getToDay(),
                "user_modif" => $user->getUserModif()
            ), $user->getId());

            $query_pass = $query->execute();
        }
        return $query_pass;
    }

    public function updateSettingUser($user, $table){
        // update name and username for User
        $query = $this->fluent()->update($table, array(
            "name" => $user->getName(),
            "username" => $user->getUserName(),
            "location" => $user->getLocation(),
            "institution" => $user->getInstitution(),
            "date_modif" => $this->getToDay(),
            "user_modif" => $user->getUserModif()
        ), $user->getId());
        $ret_nu = $query->execute();

        // update pass and salt for User
        if ($user->getPassword() != null) {
            $query = $this->fluent()->update($table, array(
                "password" => $user->getPassword(),
                "salt" => $user->getSalt(),
                "date_modif" => $this->getToDay(),
                "user_modif" => $user->getUserModif()
            ), $user->getId());
            $ret_ps = $query->execute();
        }

        // Insert the new user into the database
        if ($user->getPicture() != null) {
            try {
                $query = $this->fluent()->update($table, array(
                    "image" => $user->getPicture(),
                    "image_type" => $user->getImageType()
                ), $user->getId());
                $ret_it = $query->execute();
            } catch (Exception $e) {
                trigger_error($e->getMessage(), E_USER_ERROR);
            }
        }
        return 1;
    }

    public function updateArena($arena, $table){
        $query = $this->fluent()->update($table, array(
            "name" => $arena->getName(),
            "place" => $arena->getPlace(),
            "address" => $arena->getAddress(),
            "responsable" => $arena->getResponsable(),
            "sn_active" => $arena->getSnActive(),
            "date_modif" => $this->getToDay(),
            "user_modif" => $arena->getUserModif()
        ), $arena->getId());
        return  $query->execute();
    }

    public function updatePerfil($perfil, $table){
        $query = $this->fluent()->update($table, array(
            "name" => $perfil->getName(),
            "type" => $perfil->getType(),
            "sn_active" => $perfil->getSnActive(),
            "date_modif" => $this->getToDay(),
            "user_modif" => $perfil->getUserModif()
        ), $perfil->getId());
        return $query->execute();
    }

    public function updateAssign($assing, $table){
        $query = $this->fluent()->update($table, array(
            "id_project" => $assing->getIdProject(),
            "id_user" => $assing->getIdUser(),
            "date_from" => $this->getDateFormatDB($assing->getDatefrom()),
            "date_to" => $this->getDateFormatDB($assing->getDateTo()),
            "sn_active" => $assing->getSnActive(),
            "date_modif" => $this->getToDay(),
            "user_modif" => $assing->getUserModif()
        ), $assing->getId());
        return  $query->execute();
    }

    /**
     * @param $class
     * @param bool $am_sw
     * @param int $id_user
     * @return array|bool|stdClass
     */
    public function getListProject($class, $am_sw=false, $id_user=0){
        $am_sw_script = "";
        if ($am_sw) {
            $am_sw_script = " AND pr.id_arena IN ( SELECT DISTINCT am.id_arena FROM arena_manager AS am WHERE am.id_user = ". $id_user ." ) ";
        }
        $query = "SELECT ".
            "  pr.id ".
            ", pr.name ".
            ", pr.id_arena ".
            ", ar.name as name_arena ".
            ", pr.ubication ".
            ", pr.desc_project ".
            ", pr.date_from  ".
            ", pr.date_to ".
            ", pr.sn_active ".
            ", pr.sn_abstract ".
            ", pr.sn_repository ".
            ", pr.num_pad ".
            ", nk.num_keywords ".
            ", nu.num_user ".
            ", pr.user_create ".
            ", pr.date_create ".
            ", pr.images ".
        "FROM  ".
          "project AS pr, arena as ar,  ".
          "(SELECT pr1.id, count(us.id_user) as num_user FROM project as pr1 LEFT JOIN assigned_project_user as us ON (pr1.id = us.id_project) GROUP BY pr1.id) as nu, ".
          "(SELECT pr2.id, count(pk.id_keyword) as num_keywords FROM project as pr2 LEFT JOIN keyword_project as pk ON (pr2.id = pk.id_project) GROUP BY pr2.id) as nk  ".
        "WHERE  ".
          "pr.id_arena = ar.id ".
            $am_sw_script.
          "AND pr.id = nu.id ".
          "AND pr.id = nk.id ".
        "ORDER BY pr.name  ";
        $projects =  $this->ejecutarSqlCl($query, $class);
        return $projects;
    }

    /**
     * @param $class
     * @return array|bool|stdClass
     */
    public function getListArenas($class){
        $query =
            "SELECT ".
              "ar.id, ".
              "ar.name, ".
              "ar.place, ".
              "ar.address, ".
              "ar.responsable, ".
              "ar.sn_active, ".
              "mm.managers ".
            "FROM ".
              "arena AS ar, ".
            "(SELECT ".
              "ar.id,  ".
              "COUNT(am.id_user) AS managers  ".
            "FROM  ".
              "arena AS ar  ".
            "LEFT JOIN ".
              "arena_manager AS am ON(ar.id = am.id_arena) ".
            "GROUP BY  ".
              "ar.id) AS mm ".
            "WHERE ".
              "ar.id = mm.id ";

        $arenas =  $this->ejecutarSqlCl($query, $class);
        return $arenas;
    }

    public function getAssignProject($id_user, $class, $sw = false) {
        $query = "SELECT apu.*, pr.name as name_project, ar.name as name_hub, usr.name as name_user, usr.email " .
            " FROM assigned_project_user AS apu, project AS pr, arena AS ar, user AS usr WHERE ".
            " apu.id_project = pr.id AND apu.id_user = usr.id AND pr.id_arena = ar.id AND pr.sn_active = 'S' ";

        if ($sw){
            $query = $query . "AND pr.id_arena IN ( SELECT DISTINCT am.id_arena FROM arena_manager AS am WHERE am.id_user = ".$id_user." ) ;";
        }
        return $this->ejecutarSqlCl($query, $class );
    }

    /**
     * @param $id_user
     * @param $class
     * @return array|bool|stdClass
     */
    public function __getAssignProjectManager($id_user, $class){
        $query = "SELECT ".
                 "    apu.* ".
                 "  FROM ".
                 "     assigned_project_user AS apu, ".
                 "     project AS pr, ".
                 "     arena AS ar ".
                 "   WHERE ".
                 "     apu.id_project = pr.id AND pr.id_arena = ar.id AND pr.sn_active = 'S' AND pr.id_arena IN ( ".
                 "     SELECT DISTINCT ".
                 "      am.id_arena ".
                 "     FROM ".
                 "       arena_manager AS am ".
                 "    WHERE ".
                 "      am.id_user = ".$id_user.
                 "   ) ";
        return $this->ejecutarSqlCl($query, $class );
    }

    /**
     * @param $id_project
     * @param $class
     * @return array|bool|stdClass
     */
    public function getKeywordsProj($id_project, $class){
        $query = "SELECT ".
                    " ke.id, ".
                    " ke.keyword ".
                    " FROM  ".
                    "  keywords AS ke, ".
                    "  keyword_project AS kp ".
                    "WHERE ".
                    "  ke.id = kp.id_keyword AND kp.id_project = " . $id_project;
        return $this->ejecutarSqlCl($query, $class );
    }

    /**
     * getUsersProject
     * @param $id_project
     * @param $class
     * @return array|bool|object|stdClass
     */
    public function getUsersProject($id_project){
        $query = "select COUNT(ap.id_user) as num " .
            " from assigned_project_user ap, project pr ".
            " WHERE ".
            " pr.id = ap.id_project AND ".
            " pr.sn_active = 'S' AND ".
            " ap.sn_active = 'S' AND ".
            " pr.id = " . $id_project;

        return $this->ejecutarSql($query);
    }

    /**
     * @return string
     */
    public function getToDay(){
        $today = getdate();
        return $value = $today["year"]."-".$today["mon"]."-".$today["mday"];
    }

    /**
     * @param null $fecha
     * @return null|string
     */
    public function getDateFormatDB($fecha=null){
        if($fecha == null || $fecha == ''){
            return null;
        } else {
            list($day, $month, $year) = explode('/', $fecha);
            $val = $year . "-" . $month . "-" . $day;
            return $val;
        }
    }

    /**
     * @param $id_project
     * @return string
     */
    public function setImageProject($id_project){
        echo "setImageProject";
        $upfile = "true";
        $msg = "";
        $file_size = $_FILES['file_img_project']["size"];
        echo "setImageProject => ".$file_size ;
        $target_file = "img-project/".basename($_FILES["file_img_project"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if ($file_size > 200000) {
            echo "El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo<BR>";
            $upfile = "false";
        }

        $check = getimagesize($_FILES["file_img_project"]["tmp_name"]);
        if($check == false) {
            echo" Tu archivo tiene que ser JPG, GIF o PNG. Otros archivos no son permitidos<BR>";
            $upfile = "false";
        }

        $file_name = "";

        if($upfile == "true"){
            $file_name = "img-project-" . $id_project .".". $imageFileType;
            $add = DOCROOT.'img-project/' . $file_name;
            echo $add."\n";
            if(move_uploaded_file($_FILES["file_img_project"]["tmp_name"], $add)){
                //echo "La imagen se ha guardado correctamente";
            }else {
                $file_name = "img_project_sn.png";
            }
        } else {
            $file_name = "img_project_sn.png";
        }
        return $file_name;
    }

    /**
     * @param $project
     * @param $pads
     * @param $keywords
     * @return string
     */
    public function createProject($project, $pads, $keywords){
        $sw_pad = false;
        $id_project = 0;
        $key = "";
        $tproject = "project";
        $tpad = "group_pad";
        try {
            //$this->fluent()->getPdo()->beginTransaction();
            $query = $this->fluent()->insertInto($tproject, array(
                "name" => $project->getName(),
                "id_arena" => $project->getIdArena(),
                "ubication" => $project->getUbication(),
                "desc_project" => $project->getDescProject(),
                "date_from" => $this->getDateFormatDB($project->getDatefrom()),
                "date_to" => $this->getDateFormatDB($project->getDateTo()),
                "sn_active" => $project->getSnActive(),
                "sn_abstract" => $project->getSnAbstract(),
                "sn_repository" => $project->getSnRepository(),
                "date_create" => $this->getToDay(),
                "user_create" => $project->getUserCreate(),
                "num_pad" => $project->getNumPad(),
                "images" => $project->getImages()
            ));
            $result = $query->execute();

            if ($result >= 0) {
                $id_project = $result;
                $project->setId($id_project);
                $sw_pad = true;
            } else{
                $sw_pad = false;
                $key="710";
            }

            if ($sw_pad && $id_project != 0 && count($keywords) > 0){

                foreach ($keywords as $keyword) {
                    $id_keyword = 0;
                    $keyword_param = strtolower(trim($keyword->getKeyword()));
                    if ($keyword_param == ''){
                        continue;
                    }
                    if ($stmt = $this->db()->prepare("SELECT id FROM keywords WHERE keyword = ? LIMIT 1")) {
                        $stmt->bind_param('s', $keyword_param);
                        $stmt->execute();   // Execute the prepared query.
                        $stmt->store_result();

                        if ($stmt->num_rows == 1) {
                            $stmt->bind_result($id);
                            $stmt->fetch();
                            $id_keyword = $id;
                        } else{
                            //Solo se guardarán aquellos keywords que no existan en BD
                            $query2 = $this->fluent()->insertInto("keywords", array(
                                "keyword" => $keyword_param,
                                "sn_active" => $keyword->getSnActive(),
                                "user_create" => $keyword->getUserCreate(),
                                "date_create" => $this->getToDay()
                            ));
                            $res_keya = $query2->execute();

                            if ($res_keya >= 0) {
                                $id_keyword = $res_keya;
                            } else {
                                $key = "720";
                            }
                        }

                        //Crear nuevamente las nuevas relaciones keyword-project
                        if ($id_keyword != 0) {
                            $query3 = $this->fluent()->insertInto("keyword_project", array(
                                "id_project" => $id_project,
                                "id_keyword" => $id_keyword,
                                "sn_active" => $keyword->getSnActive(),
                                "user_create" => $keyword->getUserCreate(),
                                "date_create" => $this->getToDay()
                            ));
                            $res_keyc = $query3->execute();

                            if ($res_keyc == -1) {
                                $key = "721";
                            }
                        }
                    }
                }
            }

            // Insert the new user into the database
            if ($sw_pad && $id_project != 0 && count($pads) > 0) {
                foreach ($pads as $pad){
                    $query = $this->fluent()->insertInto($tpad, array(
                        "id" => $pad->getId(),
                        "pad_name" => $this->getPadName($project, $pad->getId(), $pad->getType()),
                        "filename_config" => $pad->getFilenameConfig(),
                        "description" => $pad->getDescription(),
                        "user_create" => $pad->getUserCreate(),
                        "sn_active" => $pad->getSnActive(),
                        "pad_name_view" => $pad->getPadNameView(),
                        "type" => $pad->getType(),
                        "id_project" => $id_project,
                        "date_create" => $this->getToDay()
                    ));
                    // echo "-----------> " . $query->getQuery() . "<br/>";
                    $res_pad = $query->execute();

                    if ($res_pad == -1) {
                        $key="730";
                    }
                }
            } else {

            }
            if ($key == ''){
                $key = "100"; //header('Location: ./projects.php?key=100&type=NS');
            }
        } catch (Exception $e) {
            $key = "711";
        }
        return $key;

    }

    public function updateProject($project, $pads, $keywords){
        $sw_pad = false;
        $id_project = $project->getId();
        $key = "";
        $tproject = "project";
        $tpad = "group_pad";

        try {
            $query = $this->fluent()->update($tproject, array(
                "name" => $project->getName(),
                "id_arena" => $project->getIdArena(),
                "ubication" => $project->getUbication(),
                "desc_project" => $project->getDescProject(),
                "date_from" => $this->getDateFormatDB($project->getDatefrom()),
                "date_to" => $this->getDateFormatDB($project->getDateTo()),
                "sn_active" => $project->getSnActive(),
                "sn_abstract" => $project->getSnAbstract(),
                "sn_repository" => $project->getSnRepository(),
                "date_modif" => $this->getToDay(),
                "user_modif" => $project->getUserCreate(),
                "num_pad" => $project->getNumPad(),
                "images" => $project->getImages()
            ), $project->getId());

            $res = $query->execute();

            if ($res >= 0) {
                $sw_pad = true;
            } else {
                $sw_pad = false;
                $key = "710";
            }

            if ($sw_pad && $id_project != 0) {
                // Elimminar toda relación keyword-project
                $kp = new KeywordsProject();
                $res_keyb = $kp->deleteBy("id_project", $id_project);

                if (count($keywords) > 0) {
                    foreach ($keywords as $keyword) {
                        $id_keyword = 0;
                        $keyword_param = strtolower(trim($keyword->getKeyword()));
                        if ($keyword_param == ''){
                            continue;
                        }
                        if ($stmt = $this->db()->prepare("SELECT id FROM keywords WHERE keyword = ? LIMIT 1")) {
                            $stmt->bind_param('s', $keyword_param);
                            $stmt->execute();   // Execute the prepared query.
                            $stmt->store_result();

                            if ($stmt->num_rows == 1) {
                                // If the keyword exists get variables from result.
                                $stmt->bind_result($id);
                                $stmt->fetch();
                                $id_keyword = $id;
                            } else {
                                //Solo se guardarán aquellos keywords que no existan en BD
                                $query2 = $this->fluent()->insertInto("keywords", array(
                                    "keyword" => $keyword_param,
                                    "sn_active" => $keyword->getSnActive(),
                                    "user_create" => $keyword->getUserCreate(),
                                    "date_create" => $this->getToDay()
                                ));
                                $res_keya = $query2->execute();

                                if ($res_keya >= 0) {
                                    $id_keyword = $this->fluent()->getPdo()->lastInsertId();
                                } else {
                                    $key = "720";
                                }
                            }
                            //Crear nuevamente las nuevas relaciones keyword-project
                            if ($id_keyword != 0) {
                                $query3 = $this->fluent()->insertInto("keyword_project", array(
                                    "id_project" => $keyword->getIdProject(),
                                    "id_keyword" => $id_keyword,
                                    "sn_active" => $keyword->getSnActive(),
                                    "user_create" => $keyword->getUserCreate(),
                                    "date_create" => $this->getToDay()
                                ));
                                $res_keyc = $query3->execute();

                                if ($res_keyc == -1) {
                                    $key = "721";
                                }
                            }
                        }
                    }
                }

                // Insert the new user into the database
                if (count($pads) > 0) {
                    foreach ($pads as $pad) {
                        if ($stmt = $this->db()->prepare("SELECT id FROM group_pad WHERE id = ? AND id_project = ? LIMIT 1")) {
                            $id_pad = $pad->getId();
                            $id_project = $pad->getIdProject();
                            $stmt->bind_param('ii', $id_pad, $id_project);
                            $stmt->execute();   // Execute the prepared query.
                            $stmt->store_result();
                            // UPDATE PAD
                            if ($stmt->num_rows >= 1) {
                                $query4 = $this->fluent()->update($tpad, array(
                                    "filename_config" => $pad->getFilenameConfig(),
                                    "description" => $pad->getDescription(),
                                    "user_modif" => $pad->getUserCreate(),
                                    "sn_active" => $pad->getSnActive(),
                                    "pad_name_view" => $pad->getPadNameView(),
                                    "date_modif" => $this->getToDay()
                                ));
                                $query4->where(array(
                                    "id_project" => $pad->getIdProject(),
                                    "id" => $pad->getId()));
                                // echo "-----------> " . $query4->getQuery() . "<br/>";
                                // echo "-----------> " . implode(" ",$query4->getParameters()) . "<br/>";
                                $res_keyd = $query4->execute();
                                echo "UPDATE: ".$query4->getQuery(true) . "\n\n";
                                if ($res_keyd == -1) {
                                    $key = "730";
                                }
                            }else{
                                $query5 = $this->fluent()->insertInto($tpad, array(
                                    "id" => $pad->getId(),
                                    "pad_name" => $this->getPadName($project, $pad->getId(), $pad->getType()),
                                    "filename_config" => $pad->getFilenameConfig(),
                                    "description" => $pad->getDescription(),
                                    "user_create" => $pad->getUserCreate(),
                                    "sn_active" => $pad->getSnActive(),
                                    "pad_name_view" => $pad->getPadNameView(),
                                    "type" => $pad->getType(),
                                    "id_project" => $id_project,
                                    "date_create" => $this->getToDay()
                                ));
                                // echo "-----------> " . $query5->getQuery() . "<br/>";
                                // echo "-----------> " . implode(" ",$query5->getParameters()) . "<br/>";
                                $res_pad = $query5->execute();
                                echo "INSERT: ".$query5->getQuery(true) . "\n\n";
                                if ($res_pad == -1) {
                                    $key="730";
                                }
                            }
                        }
                    }
                }
            }

            if ($key == ''){
                $key = "100"; //header('Location: ./projects.php?key=100&type=NS');
            }
        } catch (Exception $e) {
            $key = "711";
        }
        return $key;

    }

    private function getPadName($project, $num, $type){
        $pad_name = "PD";
        $pad_name .= str_pad($project->getId(), 4, "0", STR_PAD_LEFT);
        $pad_name .= str_pad($project->getIdArena(), 4, "0", STR_PAD_LEFT);
        if ($type == 'CON'){         #PAD con CONtenido
            $pad_name .= "PADA" . str_pad($num, 6, "0", STR_PAD_LEFT);
        } else {
            $pad_name .= "PADA" . str_pad($type, 6, "0", STR_PAD_LEFT);
        }
        return $pad_name;
    }

    public function setManagerArena($id_user, $table){
        $query = $this->fluent()->insertInto($table, array(
            "name" => "-",
            "place" => "-"
        ));
    }

    /**
     * Function get PAD Abstract.
     * @param $id
     */
    public function getPadAbsProject($id){
        $pad = '';
        if ($stmt = $this->db()->prepare("SELECT pad_name FROM group_pad WHERE id_project = ? and type = 'ABS' LIMIT 1")){
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($pad);
                $stmt->fetch();
            }
        }
        return $pad;
    }

}
?>
