<?php

require_once 'global.php';   // Needed because functions.php is not included

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
if ($mysqli->connect_error) {
    header("Location: /error.php?err=" . $mysqli->error);
    exit();
}else {
    mysqli_set_charset($mysqli,"utf8");
}