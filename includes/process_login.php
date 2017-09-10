<?php
require_once 'util.php';
require_once ROOT_PATH.'config/db_connect.php';
require_once ('functions.php');

require_once "recaptchalib.php";

$secret = "6Lf1gRkUAAAAAPvgRdWjpk1P913pXXeneKFmA_9I";
$response = null;
$reCaptcha = new ReCaptcha($secret);

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // The hashed password.

    if (login($email, $password, $mysqli) == true) {
        // Login success
        header("Location: ../home.php");
        exit();
    } else {
        // Login failed
        header('Location: ../login.php?key=504&type=NE&sec=login');
        exit();
    }
} else {
    // The correct POST variables were not sent to this page.
    header('Location: ../login.php?key=504&type=NE&sec=login');
    exit();
}

