<?php

require_once dirname(__DIR__) . '/config/db_connect.php';

function getComboPerfiles($mysqli, $selected_value){
    $strComboPerfil="";
    // Using prepared statements means that SQL injection is not possible.
    $sn_active = "S";
    if ($comboPerfil = $mysqli->prepare("SELECT id, name, type FROM perfil  
                                  WHERE sn_active = ? order by id")) {
        $comboPerfil->bind_param('s', $sn_active);  // Bind "$sn_active" to parameter.
        $comboPerfil->execute();    // Execute the prepared query.

        $comboPerfil->bind_result($id, $name, $type);

        while ($comboPerfil->fetch()) {
            $selected = "";
            if ($selected_value != null && $selected_value != ''){
                if ($id == $selected_value){
                    $selected = "selected";
                }
            }
            $strComboPerfil .=" <option value='".$id."' ".$selected.">".$name."</option>"; //concatenamos options para luego ser insertado en el HTML
        }
        $comboPerfil->close();
        return $strComboPerfil;
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function getComboArenas($mysqli, $selected_value){
    $strComboArena="<option value='' selected>Select</option>";
    // Using prepared statements means that SQL injection is not possible.
    $sn_active = "S";
    if ($comboArena = $mysqli->prepare("SELECT id, name, place, address, responsable FROM arena  
                                  WHERE sn_active = ? order by id")) {
        $comboArena->bind_param('s', $sn_active);  // Bind "$sn_active" to parameter.
        $comboArena->execute();    // Execute the prepared query.

        $comboArena->bind_result($id, $name, $place, $address, $responsable);

        while ($comboArena->fetch()) {
            $selected = "";
            if ($selected_value != null && $selected_value != ''){
                if ($id == $selected_value){
                    $selected = "selected";
                }
            }
            $strComboArena .=" <option value='".$id."' ".$selected.">".$name." - ".$responsable."</option>"; //concatenamos options para luego ser insertado en el HTML
        }
        $comboArena->close();
        return $strComboArena;
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function getComboProjects($mysqli){
    $strComboProjects="<option value='' selected>Select</option>";
    // Using prepared statements means that SQL injection is not possible.
    $sn_active = "S";
    if ($comboProjects = $mysqli->prepare("SELECT id, name FROM project  
                                  WHERE sn_active = ? and sysdate() BETWEEN date_from and IFNULL(date_to,sysdate()) ORDER BY name")) {
        $comboProjects->bind_param('s', $sn_active);  // Bind "$sn_active" to parameter.
        $comboProjects->execute();    // Execute the prepared query.

        $comboProjects->bind_result($id, $name);

        while ($comboProjects->fetch()) {
            $strComboProjects .=" <option value='".$id."'>".$name."</option>"; //concatenamos options para luego ser insertado en el HTML
        }
        $comboProjects->close();
        return $strComboProjects;
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }

}


function getComboProjectU($mysqli, $email){
    //$strComboProjectU="<option value='' selected>Select</option>";
    $strComboProjectU = "";
    // Using prepared statements means that SQL injection is not possible.
    if($email != ''){

        if ($comboProjectU = $mysqli->prepare("SELECT pr.id, pr.name FROM assigned_project_user as ap, project as pr, user as us WHERE ap.id_project = pr.id and ap.id_user = us.id and ap.sn_active = 'S' and pr.sn_active = 'S' and us.email = ? group by pr.id")) {
            $comboProjectU->bind_param('s', $email);  // Bind "$email" to parameter.
            $comboProjectU->execute();    // Execute the prepared query.

            $comboProjectU->bind_result($id, $name);

            while ($comboProjectU->fetch()) {
                $strComboProjectU .=" <option value='".$id."'>".$name."</option>"; //concatenamos options para luego ser insertado en el HTML
            }
            $comboProjectU->close();
            return $strComboProjectU;
        } else {
            // Could not create a prepared statement
            header("Location: ../error.php?err=Database error: cannot prepare statement");
            exit();
        }
    }

}

function getListProjectU($mysqli, $email){
    $strListProjectU = "";

    // Using prepared statements means that SQL injection is not possible.
    if($email != ''){

        if ($listProjectU = $mysqli->prepare("SELECT pr.id, pr.name FROM assigned_project_user as ap, project as pr, user as us WHERE ap.id_project = pr.id and ap.id_user = us.id and ap.sn_active = 'S' and pr.sn_active = 'S' and us.email = ? group by pr.id")) {
            $listProjectU->bind_param('s', $email);  // Bind "$email" to parameter.
            $listProjectU->execute();    // Execute the prepared query.

            $listProjectU->bind_result($id, $name);

            while ($listProjectU->fetch()) {
                $strListProjectU .="<li><a href='home.php?id_project=".$id."'>".$name."</a></li>";
            }
            $listProjectU->close();
            return $strListProjectU;
        } else {
            // Could not create a prepared statement
            header("Location: ../error.php?err=Database error: cannot prepare statement");
            exit();
        }
    }

}

function getDescProject($mysqli, $id_project){
    $descProject = "";

    // Using prepared statements means that SQL injection is not possible.
    if($id_project != ''){

        if ($listProjectU = $mysqli->prepare("SELECT name FROM project WHERE id = ?")) {
            $listProjectU->bind_param('s', $id_project);  // Bind "$email" to parameter.
            $listProjectU->execute();    // Execute the prepared query.

            $listProjectU->bind_result($name);

            while ($listProjectU->fetch()) {
                $descProject .="".$name."";
            }
            $listProjectU->close();
            return $descProject;
        } else {
            // Could not create a prepared statement
            header("Location: ../error.php?err=Database error: cannot prepare statement");
            exit();
        }
    }
}



function getComboUser($mysqli){
    $strComboUser="<option value='' selected>Select</option>";
    // Using prepared statements means that SQL injection is not possible.
    $sn_active = "S";
    if ($comboUser = $mysqli->prepare("SELECT id, name FROM user  
                                  WHERE sn_active = ? order by name")) {
        $comboUser->bind_param('s', $sn_active);  // Bind "$sn_active" to parameter.
        $comboUser->execute();    // Execute the prepared query.

        $comboUser->bind_result($id, $name);

        while ($comboUser->fetch()) {
            $strComboUser .=" <option value='".$id."'>".$name."</option>"; //concatenamos options para luego ser insertado en el HTML
        }
        $comboUser->close();
        return $strComboUser;
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }

}


function getComboSN($selected_value){

    $strCombo = "<option value='' >Select</option>";
    if($selected_value != null && $selected_value != ''){
        if ($selected_value == 'S') {
            $strCombo = $strCombo."<option value='S' selected>Active</option>";
            $strCombo = $strCombo."<option value='N'>No Active</option>";
        } else{
            $strCombo = $strCombo."<option value='S'>Active</option>";
            $strCombo = $strCombo."<option value='N' selected>No Active</option>";
        }
    }

    return $strCombo;

}
