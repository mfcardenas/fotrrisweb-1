<?php

require_once 'util.php';
require_once ROOT_PATH.'config/db_connect.php';
require_once 'gerror.php';

$error_msg = "";
$arrayDesc = array();
$arrayName = array();
$id_project = "";

if (isset($_POST['name'], $_POST['id_arena'], $_POST['ubication'], $_POST['number_pad'])) {

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

    if ($name == "") {
        $error_msg .= '<p class="error">Field name is required</p>';
    }

    $id_arena = filter_input(INPUT_POST, 'id_arena', FILTER_SANITIZE_STRING);
    $ubication = filter_input(INPUT_POST, 'ubication', FILTER_SANITIZE_STRING);
    $desc_proj = filter_input(INPUT_POST, 'desc_proj', FILTER_SANITIZE_STRING);
    $date_from = filter_input(INPUT_POST, 'date_from', FILTER_SANITIZE_STRING);
    $date_to = filter_input(INPUT_POST, 'date_to', FILTER_SANITIZE_STRING);
    $number_pad = filter_input(INPUT_POST, 'number_pad', FILTER_SANITIZE_STRING);

    $desc_p1 = filter_input(INPUT_POST, 'desc_p1', FILTER_SANITIZE_STRING);
    $name_p1 = filter_input(INPUT_POST, 'name_p1', FILTER_SANITIZE_STRING);

    $sn_active = filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);

    $keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_STRING);

    $array_keywords = explode(",", $keywords);

    if ($sn_active == "") {
        $sn_active == 'S';
    }

    if ($date_from == "") {
        $error_msg .= '<p class="error">Is necessary date from to assign project</p>';
    }

    if ($date_to == "") {
        $date_to = null;
    }

    $arrayDesc[1] = $desc_p1;
    $arrayName[1] = $name_p1;

    if ($number_pad > 1) {
        $desc_p2 = filter_input(INPUT_POST, 'desc_p2', FILTER_SANITIZE_STRING);
        $name_p2 = filter_input(INPUT_POST, 'name_p2', FILTER_SANITIZE_STRING);
        $arrayDesc[2] = $desc_p2;
        $arrayName[2] = $name_p2;
    }

    if ($number_pad > 2) {
        $desc_p3 = filter_input(INPUT_POST, 'desc_p3', FILTER_SANITIZE_STRING);
        $name_p3 = filter_input(INPUT_POST, 'name_p3', FILTER_SANITIZE_STRING);
        $arrayDesc[3] = $desc_p3;
        $arrayName[3] = $name_p3;
    }

    if ($number_pad > 3) {
        $desc_p4 = filter_input(INPUT_POST, 'desc_p4', FILTER_SANITIZE_STRING);
        $name_p4 = filter_input(INPUT_POST, 'name_p4', FILTER_SANITIZE_STRING);
        $arrayDesc[4] = $desc_p4;
        $arrayName[4] = $name_p4;
    }

    if ($number_pad > 4) {
        $desc_p5 = filter_input(INPUT_POST, 'desc_p5', FILTER_SANITIZE_STRING);
        $name_p5 = filter_input(INPUT_POST, 'name_p5', FILTER_SANITIZE_STRING);
        $arrayDesc[5] = $desc_p5;
        $arrayName[5] = $name_p5;
    }

    if ($number_pad > 5) {
        $desc_p6 = filter_input(INPUT_POST, 'desc_p6', FILTER_SANITIZE_STRING);
        $name_p6 = filter_input(INPUT_POST, 'name_p6', FILTER_SANITIZE_STRING);
        $arrayDesc[6] = $desc_p6;
        $arrayName[6] = $name_p6;
    }

    if ($number_pad > 6) {
        $desc_p7 = filter_input(INPUT_POST, 'desc_p7', FILTER_SANITIZE_STRING);
        $name_p7 = filter_input(INPUT_POST, 'name_p7', FILTER_SANITIZE_STRING);
        $arrayDesc[7] = $desc_p7;
        $arrayName[7] = $name_p7;
    }

    if (empty($error_msg)) {

        $create_pad = true;

        try {


            // Insert the new user into the database
            if ($insert_stmt_p = $mysqli->prepare("INSERT INTO project (name, id_arena, ubication, desc_project, date_from, date_to, sn_active, date_create, user_create) VALUES (?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y'),STR_TO_DATE(?, '%d/%m/%Y'), ?,sysdate(),?)")) {

                $insert_stmt_p->bind_param('sissssss', $name, $id_arena, $ubication, $desc_proj, $date_from, $date_to, $sn_active, $username);
                // Execute the prepared query.

                if (!$insert_stmt_p->execute()) {
                    $create_pad = false;
                    $mysqli->rollback();
                    trigger_error($insert_stmt_p->error, E_USER_ERROR);
                    //header('Location: ../error.php?err=failure INSERT: CREATE PROJECT ' . $insert_stmt_p->error);
                    exit();
                } else {
                    $id_project = $insert_stmt_p->insert_id;
                }

            }

            if ($create_pad && $id_project != 0 && count($array_keywords) > 0){
                foreach ($array_keywords as $keyword) {
                    if ($stmt = $mysqli->prepare("SELECT id, keyword FROM keywords WHERE keyword = ? LIMIT 1")) {
                        // Bind "$user_id" to parameter.
                        $stmt->bind_param('s', strtolower(trim($keyword)));
                        $stmt->execute();   // Execute the prepared query.
                        $stmt->store_result();

                        if ($stmt->num_rows == 1) {
                            // If the user exists get variables from result.
                            $stmt->bind_result($id_keyword_, $keyword_);
                            $stmt->fetch();
                            $id_keyword = $id_keyword_;
                        } else{
                            //Solo se guardan aquellos keywords que no existan en BD previamente
                            if ($insert_stmt_k = $mysqli->prepare("INSERT INTO keywords (keyword) VALUES (?)")) {
                                $insert_stmt_k->bind_param('s', strtolower(trim($keyword)));

                                if (!$insert_stmt_k->execute()) {
                                    $mysqli->rollback();
                                    trigger_error($insert_stmt_k->error, E_USER_ERROR);
                                    exit();
                                } else{
                                    $id_keyword = $insert_stmt_k->insert_id;
                                }
                            }
                        }

                        if ($id_keyword != 0 && $insert_stmt_pk = $mysqli->prepare("INSERT INTO keyword_project (id_project, id_keyword) VALUES (?, ?)")){
                            $insert_stmt_pk->bind_param('ii', $id_project, $id_keyword);
                            if (!$insert_stmt_pk->execute()) {
                                $mysqli->rollback();
                                trigger_error($insert_stmt_pk->error, E_USER_ERROR);
                            }
                        }
                    }
                }
            }

            // Insert the new user into the database
            if ($create_pad && $id_project != 0) {
                if ($insert_stmt_g = $mysqli->prepare("INSERT INTO group_pad (pad_name, filename_config, sn_active, pad_name_view, id_project, description, date_create, user_create) VALUES (?, ?, ?, ?, ?, ?, sysdate(), ?)")) {

                    $filename_setting = "setting.json";

                    for ($i = 1; $i <= $number_pad; $i++) {
                        $pad_name = "PD";
                        $pad_name .= str_pad($id_project, 4, "0", STR_PAD_LEFT);
                        $pad_name .= str_pad($id_arena, 4, "0", STR_PAD_LEFT);
                        $pad_name .= "PADA" . str_pad($i, 6, "0", STR_PAD_LEFT);

                        $insert_stmt_g->bind_param('ssssiss', $pad_name, $filename_setting, $sn_active, $arrayName[$i], $id_project, $arrayDesc[$i], $username);

                        // Execute the prepared query.
                        if (!$insert_stmt_g->execute()) {
                            $mysqli->rollback();
                            trigger_error($insert_stmt_g->error, E_USER_ERROR);
                            exit();
                        }
                    }
                }
            } else {
                trigger_error(getMsgError(909), E_USER_ERROR);
            }
            header('Location: ./projects.php?key=100&type=NS');
        } catch (Exception $e) {
            $mysqli->rollback();
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        exit();
    } else {
        trigger_error(getMsgError(999), E_USER_ERROR);
    }
}