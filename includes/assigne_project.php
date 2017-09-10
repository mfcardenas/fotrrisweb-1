<?php

require_once 'util.php';
require_once ROOT_PATH.'config/db_connect.php';
require_once ('gerror.php');

if (isset($_POST['id_project'], $_POST['id_user'], $_POST['date_from'], $_POST['sn_active'])) {

    $error_msg = "";

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    
    $id_project = filter_input(INPUT_POST, 'id_project', FILTER_SANITIZE_STRING);
    
    $id_user = filter_input(INPUT_POST, 'id_user', FILTER_SANITIZE_STRING);
    
    $date_from = filter_input(INPUT_POST, 'date_from', FILTER_SANITIZE_STRING);
    
    $date_to = filter_input(INPUT_POST, 'date_to', FILTER_SANITIZE_STRING);
    
    $sn_active = filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
    
    if ($id_project == "") {
        $error_msg .= 'id_project,';
    }
    
    if ($id_user == "") {
        $error_msg .= 'id_user,';
    }
    
    if ($date_from == "") {
        $error_msg .= 'date_from,';
    }
    
    if ($sn_active == "") {
        $error_msg .= 'sn_active,';
    }
    
    if (empty($error_msg)) {
        try {
            // Insert the new user into the database 
            if ($insert_stmt = $mysqli->prepare("INSERT INTO assigned_project_user (id_project, id_user, date_from, date_to, sn_active, user_create, date_create) VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'),STR_TO_DATE(?, '%d/%m/%Y'), ?, sysdate(), ? )")) {

                $insert_stmt->bind_param("iissss", $id_project, $id_user, $date_from, $date_to, $sn_active, $username);

                // Execute the prepared query.
                if (! $insert_stmt->execute()) {
                    trigger_error($insert_stmt->error, E_USER_ERROR);
                    exit();
                }
            }
            header('Location: /assigne_projects_user.php?key=100&type=NS');
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        exit();
    }else{
        trigger_error(getMsgError(999), E_USER_ERROR);
    }
} else {
    trigger_error(getMsgError(999), E_USER_ERROR);
}