<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 18/06/16
 * Time: 21:36
 */
require_once 'util.php';
require_once ROOT_PATH.'config/db_connect.php';

if(isset($_GET["id"])){

    $id=(int)$_GET["id"];
    $query = "SELECT image, image_type FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($image, $image_type);
            $stmt->fetch();

            header("Content-type: ". $image_type);
            echo $image;

        }else{
            echo "img/user.jpeg";
        }
    }else {
        echo "img/user.jpeg";
    }
}else{
    echo "img/user.jpeg";
}
