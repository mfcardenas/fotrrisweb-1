<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 12/06/16
 * Time: 19:26
 */

function gestErrorNotifications($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        // Error no contemplado
        return;
    }

    switch ($errno) {
        case E_USER_ERROR:
            echo "<div class=\"my-notify-error\"><b>ERROR: </b> [$errno] $errstr<br />";
            echo "  Error fatal en la línea $errline en el archivo $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />";
            echo "Cancel Action...<br /></div>";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<div class=\"my-notify-warning\"><b>WARNING</b> [$errno] $errstr</div>";
            break;

        case E_USER_NOTICE:
            echo "<div class=\"my-notify-info\"><b>NOTICE</b> [$errno] $errstr</div>";
            break;

        default:
            echo "<div class=\"my-notify-error\">Tipo de error desconocido: [$errno] $errstr<br/>";
            echo "  Error fatal en la línea $errline en el archivo $errfile";
            echo "</div>";
            break;
    }

    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}

$ge = set_error_handler("gestErrorNotifications");


function getNotification($key, $type) {
    $class = "my-notify-info";

    if ($type == 'NS') {
        $class = "my-notify-success";
    }

    if ($type == 'NE') {
        $class = "my-notify-error";
    }

    if ($type == 'NW') {
        $class = "my-notify-warning";
    }

    if ($type == 'NI') {
        $class = "my-notify-info";
    }

    if ($type == '' || $type == null) {
        $class = "my-notify-info";
    }

    return "<div class='" . $class . "' >" . getMsgError($key) . "</div>";

}

function getMsgError($key) {
    $hashError = array(
        100 => "Record saved correctly",
        101 => "Saved registry with errors",
        102 => "User create correctly",
        103 => "User create correctly. Please, login now!",
        200 => "Delete record",
        300 => "Could not delete the record",
        901 => "Could not save record",
        999 => "You need to fill all required fields of the form",
        909 => "Can not be created the pad project",
        908 => "Database error",
        501 => "The email address you entered is not valid",
        502 => "Invalid password configuration",
        503 => "A user with this email address already exists",
        504 => "The user and password do not match an active account",
        505 => "It is not possible to update the user's password. Failed to encrypt the password.",
        607 => "Could not save picture",
        608 => "Not allowed image, the maximum allowed size is 1 Megabyte",
        710 => "Coult not save project",
        711 => "Error traying save data of project",
        720 => "Coult not save keyword",
        721 => "Coult not save keyword project relations",
        730 => "Coult not save Pad",
        735 => "The reCAPTCHA is incorrect, try again.",
        739 => "Email invalidad for reset password",
        740 => "Not found email in FoTRRIS",
        741 => "It is not possible to send the new password. Contact the FoTRRIS WebMaster",
        742 => "The new password will be sent to your email. Wait a few minutes."
        
    );


    return $hashError[$key];
}

?>