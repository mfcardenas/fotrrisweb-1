<?php

require_once 'util.php';
require_once ROOT_PATH . 'config/db_connect.php';
require_once 'gerror.php';
require_once "recaptchalib.php";

$secret = "6LcQghkUAAAAAN5Bz38v-xo6hKF2nXuZiuP1d_5D";
$response = null;
$reCaptcha = new ReCaptcha($secret);

if (isset($_POST["g-recaptcha-response"])) {
    $response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"], $_POST["g-recaptcha-response"]);

    if ($response != null && $response->success) {
        if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
            $error_msg = false;
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $perfil = filter_input(INPUT_POST, 'perfil', FILTER_SANITIZE_STRING);

            // Sanitize and validate the data passed in
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $userapp = filter_input(INPUT_POST, 'userapp', FILTER_SANITIZE_STRING);
            $sn_active = filter_input(INPUT_POST, 'sn_active', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Not a valid email
                $error_msg = "key=501";
            }

            $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
            if (strlen($password) != 128) {
                // The hashed pwd should be 128 characters long. If it's not, something really odd has happened
                $error_msg = "key=502";
            }

            // Username validity and password validity have been checked client side.
            // This should should be adequate as nobody gains any advantage from
            // breaking these rules.

            $prep_stmt = "SELECT id FROM user WHERE email = ? LIMIT 1";
            $stmt = $mysqli->prepare($prep_stmt);

            if ($stmt) {
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $error_msg = "key=503";
                }
            } else {
                $error_msg = "key=908";
            }

            $picture = null;
            $image_type = null;

            try {
                if (!empty($_FILES["imgpicture"]["size"])) {
                    //verificar formato, tamanio y existencia de la imagen
                    if ($_FILES["imgpicture"]["error"] > 0) {
                        $error_msg = "key=607";
                    } else {
                        $type_img = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                        $size_kb = 1024;

                        if (in_array($_FILES['imgpicture']['type'], $type_img) && $_FILES['imgpicture']['size'] <= $size_kb * 1024) {
                            $image_type = $_FILES['imgpicture']['type'];
                            $imagen_temporal = $_FILES['imgpicture']['tmp_name'];
                            $fp = fopen($imagen_temporal, 'r+b');
                            $picture = fread($fp, filesize($imagen_temporal));
                            fclose($fp);

                            //$picture = mysqli_real_escape_string($mysqli, $picture);

                        } else {
                            $error_msg = "key=608";
                        }
                    }
                }
            } catch (Exception $e) {
                trigger_error($e->getMessage(), E_USER_ERROR);
            }
            // TODO:
            // We'll also have to account for the situation where the user doesn't have
            // rights to do registration, by checking what type of user is attempting to
            // perform the operation.
            if ($error_msg == "") {
                try {
                    // Create a random salt
                    $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

                    // Create salted password
                    $password = hash('sha512', $password . $random_salt);

                    // Insert the new user into the database
                    if ($insert_stmt = $mysqli->prepare("INSERT INTO user (name, username, email, password, salt, id_perfil, sn_active, date_create, user_create, image, image_type) VALUES (?, ?, ?, ?, ?, ?, ?, sysdate(), ?, ?, ? )")) {
                        $null = NULL;
                        $insert_stmt->bind_param('sssssissbs', $name, $username, $email, $password, $random_salt, $perfil, $sn_active, $userapp, $null, $image_type);
                        $insert_stmt->send_long_data(8, $picture);

                        if (!$insert_stmt->execute()) {
                            trigger_error($insert_stmt->error, E_USER_ERROR);
                            exit();
                        } else {

                        }
                    }
                    header('Location: ./login.php?key=103&type=NS');
                } catch (Exception $e) {
                    trigger_error($e->getMessage(), E_USER_ERROR);
                }
                exit();
            } else {
                header('Location: ../login.php?' . $error_msg . '&type=NE&sec=register');
            }
        }
    } else {
        header('Location: ../login.php?key=735&type=NE&sec=login');
        exit();
    }
}

