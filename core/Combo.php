<?php

class Combo {

    private $db;

    /**
     * @return mysqli
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * @param mysqli $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    private function getDefaultOption(){
        return "<option value='' >Select</option>";
    }

    /**
     * Combo constructor.
     */
    public function __construct() {
        require_once 'connect.php';
        $this->conn = new ConnectDB();
        $this->db = $this->conn->conexion();
    }


    /**
     * @param null $selected_value
     * @param bool $blank_opt
     * @return string
     */
    public function getStatus($selected_value=null, $blank_opt=true) {

        $strCombo = ($blank_opt) ? $this->getDefaultOption() : "";

        if ($selected_value != null && $selected_value != '') {
            if ($selected_value == 'S') {
                $strCombo = $strCombo . "<option value='S' selected>Active</option>";
                $strCombo = $strCombo . "<option value='N'>No Active</option>";
            } else {
                $strCombo = $strCombo . "<option value='S'>Active</option>";
                $strCombo = $strCombo . "<option value='N' selected>No Active</option>";
            }
        } else {
            $strCombo = $strCombo . "<option value='S'>Active</option>";
            $strCombo = $strCombo . "<option value='N'>No Active</option>";
        }
        return $strCombo;

    }

    /**
     * Function getComboPerfiles.
     * Return list of Perfil for use in input type select.
     * @param null $selected_value value selected for default
     * @param bool $blank_opt add option value equal blank with text 'Select'
     * @param bool $status status f register in db active/not active
     * @return string
     */
    public function getPerfiles($selected_value=null, $blank_opt=true,$status=true) {
        $strComboPerfil = ($blank_opt) ? $this->getDefaultOption() : "";
        $sn_active = ($status)?"S":"N";

        try {
            if ($comboPerfil = $this->db->prepare("SELECT id, name, type FROM perfil  
                                  WHERE sn_active = ? order by id")) {
                $comboPerfil->bind_param('s', $sn_active );  // Bind "$sn_active" to parameter.
                $comboPerfil->execute();    // Execute the prepared query.

                $comboPerfil->bind_result($id, $name, $type);

                while ($comboPerfil->fetch()) {
                    $selected = "";
                    if ($selected_value != null && $selected_value != '') {
                        if ($id == $selected_value) {
                            $selected = "selected";
                        }
                    }
                    $strComboPerfil .= " <option value='" . $id . "' " . $selected . ">" . $name . "</option>";
                }
                $comboPerfil->close();

            }
        } catch (Exception $e){

        }
        return $strComboPerfil;
    }

    /**
     * Function getComboPerfiles.
     * Return list of Perfil for use in input type select.
     * @param null $selected_value value selected for default
     * @param bool $blank_opt add option value equal blank with text 'Select'
     * @param bool $status status f register in db active/not active
     * @return string
     */
    public function getPerfil($type=1, $selected_value=null, $blank_opt=true,$status=true) {
        $strComboPerfil = ($blank_opt) ? $this->getDefaultOption() : "";
        $sn_active = ($status)?"S":"N";

        try {
            if ($comboPerfil = $this->db->prepare("SELECT id, name, type FROM perfil  
                                  WHERE sn_active = ? AND type = ? order by id")) {
                $comboPerfil->bind_param('si', $sn_active, $type );  // Bind "$sn_active" and $type perfil to parameter.
                $comboPerfil->execute();    // Execute the prepared query.
                $comboPerfil->bind_result($id, $name, $type);
                while ($comboPerfil->fetch()) {
                    $selected = "";
                    if ($selected_value != null && $selected_value != '') {
                        if ($id == $selected_value) {
                            $selected = "selected";
                        }
                    }
                    $strComboPerfil .= " <option value='" . $id . "' " . $selected . ">" . $name . "</option>";
                }
                $comboPerfil->close();
            }
        } catch (Exception $e){

        }
        return $strComboPerfil;
    }

    /**
     * @param null $selected_value
     * @param bool $blank_opt
     * @param bool $status
     * @return string
     */
    public function getArenas($selected_value=null, $blank_opt=true, $status=true, $am=false, $id_user=0) {
        $strComboArena = ($blank_opt) ? $this->getDefaultOption() : "";
        $sn_active = ($status)?"S":"N";

        if($am){
            $query_arena = "SELECT ar.id, ar.name, ar.place, ar.address, ar.responsable FROM arena AS ar WHERE ar.sn_active = ? AND ar.id IN ( SELECT DISTINCT am.id_arena FROM arena_manager AS am WHERE am.id_user = ?) ORDER BY ar.id";
        } else {
            $query_arena = "SELECT id, name, place, address, responsable FROM arena WHERE sn_active = ? order by id";
        }
        if ($comboArena = $this->db->prepare($query_arena)) {
            if($am){
                $comboArena->bind_param('si', $sn_active, $id_user);
            } else {
                $comboArena->bind_param('s', $sn_active);
            }
            $comboArena->execute();
            $comboArena->bind_result($id, $name, $place, $address, $responsable);
            while ($comboArena->fetch()) {
                $selected = "";
                if ($selected_value != null && $selected_value != '') {
                    if ($id == $selected_value) {
                        $selected = "selected";
                    }
                }
                $strComboArena .= " <option value='" . $id . "' " . $selected . ">" . $name . " - " . $place . "</option>";
            }
            $comboArena->close();
        }
        return $strComboArena;
    }

    /**
     * @param null $selected_value
     * @param bool $blank_opt
     * @param bool $status
     * @return string
     */
    public function getProjects($selected_value=null, $blank_opt=true, $status=true, $perfil=1, $id_user) {
        $strComboProjects = ($blank_opt) ? $this->getDefaultOption() : "";
        $sn_active = ($status)?"S":"N";

        if ($perfil == 3){
            $query = "SELECT pr.id, pr.name FROM project AS pr WHERE pr.sn_active = ? AND pr.id_arena in (SELECT distinct am.id_arena FROM arena_manager AS am WHERE am.id_user = ?)";
        } else {
            $query = "SELECT id, name FROM project WHERE sn_active = ? ORDER BY name";
        }
        if ($comboProjects = $this->db->prepare($query)) {
            if ($perfil == 3) {
                $comboProjects->bind_param('si', $sn_active, $id_user);
            } else {
                $comboProjects->bind_param('s', $sn_active);
            }
            $comboProjects->execute();    // Execute the prepared query.
            $comboProjects->bind_result($id, $name);

            while ($comboProjects->fetch()) {
                $selected = "";
                if ($selected_value != null && $selected_value != '') {
                    if ($id == $selected_value) {
                        $selected = "selected";
                    }
                }
                $strComboProjects .= " <option value='" . $id . "' ".$selected.">" . $name . "</option>";
            }
            $comboProjects->close();
        }
        return $strComboProjects;
    }

    /**
     * @param $email
     * @param null $selected_value
     * @param bool $blank_opt
     * @param bool $status
     * @return string
     */
    public function getProjectAssign($email, $selected_value=null, $blank_opt=true, $status=true) {
        $strComboProjectU = ($blank_opt) ? $this->getDefaultOption() : "";
        $sn_active = ($status)?"S":"N";

        if ($email != '') {
            if ($comboProjectU = $this->db->prepare("SELECT pr.id, pr.name FROM assigned_project_user as ap, project as pr, user as us WHERE ap.id_project = pr.id and ap.id_user = us.id and ap.sn_active = ? and pr.sn_active = ? and us.email = ? group by pr.id")) {
                $comboProjectU->bind_param('sss', $sn_active, $sn_active, $email);  // Bind "$email" to parameter.
                $comboProjectU->execute();    // Execute the prepared query.

                $comboProjectU->bind_result($id, $name);

                while ($comboProjectU->fetch()) {
                    $selected = "";
                    if ($selected_value != null && $selected_value != '') {
                        if ($id == $selected_value) {
                            $selected = "selected";
                        }
                    }
                    $strComboProjectU .= " <option value='" . $id . "' ".$selected.">" . $name . "</option>";
                }
                $comboProjectU->close();

            }
        }
        return $strComboProjectU;
    }

    /**
     * @param $email
     * @return string
     */
    public function getLinkProject($email) {
        $strListProjectU = "";
        if ($email != '') {
            if ($listProjectU = $this->db->prepare("SELECT pr.id, pr.name FROM assigned_project_user as ap, project as pr, user as us WHERE ap.id_project = pr.id and ap.id_user = us.id and ap.sn_active = 'S' and pr.sn_active = 'S' and us.email = ? group by pr.id")) {
                $listProjectU->bind_param('s', $email);  // Bind "$email" to parameter.
                $listProjectU->execute();    // Execute the prepared query.

                $listProjectU->bind_result($id, $name);

                while ($listProjectU->fetch()) {
                    $strListProjectU .= "<li><a href='home.php?id_project=" . $id . "'>" . $name . "</a></li>";
                }
                $listProjectU->close();

            }
        }
        return $strListProjectU;
    }

    /**
     * @param $id_project
     * @return string
     */
    public function getDescProject($id_project) {
        $descProject = "";
        if ($id_project != '') {

            if ($listProjectU = $this->db->prepare("SELECT name FROM project WHERE id = ?")) {
                $listProjectU->bind_param('s', $id_project);  // Bind "$email" to parameter.
                $listProjectU->execute();    // Execute the prepared query.

                $listProjectU->bind_result($name);

                while ($listProjectU->fetch()) {
                    $descProject .= "" . $name . "";
                }
                $listProjectU->close();

            }
        }
        return $descProject;
    }

    /**
     * @param $id_user
     * @return string
     */
    public function getNameUser($id_user) {
        $desc = "";
        if ($id_user != '') {

            if ($listu = $this->db->prepare("SELECT name FROM user WHERE id = ?")) {
                $listu->bind_param('s', $id_user);  // Bind "$email" to parameter.
                $listu->execute();    // Execute the prepared query.

                $listu->bind_result($name);

                while ($listu->fetch()) {
                    $desc .= "" . $name . "";
                }
                $listu->close();

            }
        }
        return $desc;
    }

    /**
     * @param $id_user
     * @return string
     */
    public function getEmailUser($id_user) {
        $desc = "";
        if ($id_user != '') {

            if ($listu = $this->db->prepare("SELECT email FROM user WHERE id = ?")) {
                $listu->bind_param('s', $id_user);  // Bind "$email" to parameter.
                $listu->execute();    // Execute the prepared query.

                $listu->bind_result($email);

                while ($listu->fetch()) {
                    $desc .= "" . $email . "";
                }
                $listu->close();

            }
        }
        return $desc;
    }

    /**
     * @param $id_project
     * @return string
     */
    public function getArenaProject($id_project) {
        $desc = "";
        if ($id_project != '') {

            if ($listu = $this->db->prepare("SELECT ar.name FROM project as pr, arena as ar WHERE ar.id = pr.id_arena AND pr.id = ?")) {
                $listu->bind_param('s', $id_project);  // Bind "$email" to parameter.
                $listu->execute();    // Execute the prepared query.

                $listu->bind_result($name);

                while ($listu->fetch()) {
                    $desc .= "" . $name . "";
                }
                $listu->close();

            }
        }
        return $desc;
    }

    /**
     * @param null $selected_value
     * @param bool $blank_opt
     * @param bool $status
     * @return string
     */
    public function getUser($selected_value=null, $blank_opt=true,$status=true) {
        $strComboUser = ($blank_opt) ? $this->getDefaultOption() : "";
        $sn_active = ($status) ? "S" : "N";

        if ($comboUser = $this->db->prepare("SELECT id, name FROM user  
                                  WHERE sn_active = ? order by name")) {
            $comboUser->bind_param('s', $sn_active);  // Bind "$sn_active" to parameter.
            $comboUser->execute();    // Execute the prepared query.
            $comboUser->bind_result($id, $name);

            while ($comboUser->fetch()) {
                $selected = "";
                if ($selected_value != null && $selected_value != '') {
                    if ($id == $selected_value) {
                        $selected = "selected";
                    }
                }
                $strComboUser .= " <option value='" . $id . "' ".$selected.">" . $name . "</option>";
            }
            $comboUser->close();
        }
        return $strComboUser;
    }

    /**
     * Function get user with perfil Arena Manager (3)
     * @param null $selected_value
     * @param bool $blank_opt
     * @return string
     */
    public function getUserManagerArena($selected_value=null, $blank_opt=true) {
        $strComboUser = ($blank_opt) ? $this->getDefaultOption() : "";

        if ($comboUser = $this->db->prepare(" SELECT u.id, u.name FROM user AS u, perfil AS p WHERE u.id_perfil = p.id AND p.type = 3 AND u.sn_active = 'S' AND p.sn_active = 'S' ")) {
            $comboUser->execute();    // Execute the prepared query.
            $comboUser->bind_result($id, $name);

            while ($comboUser->fetch()) {
                $selected = "";
                if ($selected_value != null && $selected_value != '') {
                    $list_user = explode(",", $selected_value);
                    foreach ($list_user as $user_) {
                        if ($user_ != "") {
                            if ($id == $user_) {
                                $selected = "selected";
                            }
                        }
                    }
                }
                $strComboUser .= " <option value='" . $id . "' ".$selected.">" . $name . "</option>";
            }
            $comboUser->close();
        }
        return $strComboUser;
    }

    /**
     * @param null $selected_value
     * @param bool $blank_opt
     * @param int $size
     * @param int $default
     * @return string
     */
    public function getNumPad($selected_value=null, $blank_opt=false, $size=10, $default=1){
        $strCombo = ($blank_opt) ? $this->getDefaultOption() : "";


        if ($selected_value == '' || $selected_value == null){
            $selected_value = $default;
        }

        for ($i = 1; $i <= $size; $i++){
            $selected = "";
            $disabled = "";
            if ($selected_value != null && $selected_value != '') {
                if ($i < $selected_value) {
                    $disabled = "disabled";
                }
                if ($i == $selected_value) {
                    $selected = "selected";
                }
            }
            $strCombo = $strCombo."<option value='".$i."' ".$selected." ".$disabled.">".$i."</option>";

        }

        return $strCombo;
    }

    /**
     * @return mixed
     */
    public function getStyleTags(){

        $class_tag = array(1 => 'label label-default',
            2 => 'label label-primary',
            3 => 'label label-success',
            4 => 'label label-info',
            5 => 'label label-warning',
            6 => 'label label-danger');

        $index = rand( 1 , 6 );

        return $class_tag[$index];

    }


}