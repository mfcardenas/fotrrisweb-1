<?php

require_once 'util.php';
require_once ROOT_PATH.'config/db_connect.php';

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name 
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);

    if(!isset($_SESSION)){
        session_start();
        session_regenerate_id();
    }

    //session_start();            // Start the PHP session
    //session_regenerate_id();    // regenerated the session, delete the old one.
}

function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt, id_perfil FROM user WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $salt, $id_perfil);
        $stmt->fetch();
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);

        if ($stmt->num_rows >= 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches 
                // the password the user submitted.

                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['id_user'] = $user_id;
                    $_SESSION['email'] = $email;
                    $_SESSION['type'] = $id_perfil;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);

                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

                    // Login successful. 
                    return true;
                } else {
                    // Password is not correct 
                    // We record this attempt in the database 
                    $now = time();
                    if (!$mysqli->query("INSERT INTO login_attempts(id_user, time) 
                                    VALUES ('$user_id', '$now')")) {
                        header("Location: ../error.php?err=Database error: login_attempts");
                        exit();
                    }

                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=dberror-login--". $mysqli->error());
        exit();
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();

    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time 
                                  FROM login_attempts 
                                  WHERE id_user = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement checkbrute");
        exit();
    }
}

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['id_user'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['id_user'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM user 
				      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Could not prepare statement
            header("Location: ../error.php?err=Database error: cannot prepare statement login_check");
            exit();
        }
    } else {
        // Not logged in 
        return false;
    }
}

/**
 * Get esc url.
 * @param $url
 * @return mixed|string
 */
function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    
    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);
    
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

/**
* Get pad for project and user and by reference email
*/
function getPadHtmlUserProject($mysqli, $id_project){
    
    // Using prepared statements means that SQL injection is not possible. 
    $elementHtml = array();
    
    $script = array();
    $section = array();
    $tab = array();
    $sw = true;
     
    if ($scriptPad = $mysqli->prepare("SELECT pad_name, pad_name_view, description, filename_config, type FROM group_pad WHERE sn_active = 'S' and id_project = ? order by pad_name")) {
        
        $scriptPad->bind_param('s', $id_project);  // Bind "$id_project" to parameter.
        $scriptPad->execute();    // Execute the prepared query.
        
        $scriptPad->bind_result($pad_name, $pad_name_view, $description, $filename_config, $type);
        $classActive = "active";
        
        $aUrl = curHost();
       
        while ($scriptPad->fetch()) {
            //create tab link top
            $color = "";
            if ($type == PAD_ABS){
                $color = "bck bck_b";
            }
            if ($type == PAD_REP){
                $color = "bck bck_g";
            }
            $tab[] = "<li class='".$classActive." ". $color . "'><a id='tab_link_".$pad_name."' href='#tab".$pad_name."'>".$pad_name_view."</a></li>";
            
            //create div html content pad
            if ($type == PAD_REP){
                $script[] = "$('#tab_link_".$pad_name."').click(function() {" .
                    "$('#repository_iframe').css('display', 'block');" .
                    "});";
                $locale = getenv("LANGUAGE");
                $section[] = "<section id='tab".$pad_name."' class='tab-content ".$classActive."'><div>" .
                    " <div id='repository_iframe' class='embed-container' style='display: none;'><iframe id='repiframe' height='400' width='900' " .
                    "src='repository.php?lang=" . $locale . "&id=".$id_project."'>" .
                    "<p>Your browser does not support iframes.</p></iframe></div></div>" .
                    "</section>";
            }else{
                //create script load pad
                $script[] = "$('#tab_link_".$pad_name."').click(function() {".
                    "$('#div".$pad_name."').pad(".
                    "{'padId':'".$pad_name."', 'plugins':{'pageview':'true'}, 'showControls':'true', 'showChat':'true', 'showLineNumbers':'true', 'userName':'".$_SESSION['username']."', 'width':'100', ".
                    "'height':600, 'border':1, 'borderStyle':'solid', 'userColor':'true', 'host':'". URL_SERVER_PAD."', 'baseUrl':'/p/', 'useMonospaceFont' :". "'false', 'noColors': 'false', 'alwaysShowChat':'true'});".
                    "$('#repository_iframe').css('display', 'none');" .
                    "});";

                $section[] = "<section id='tab".$pad_name."' class='tab-content ".$classActive."'><div><div id='div".$pad_name."'></div></div></section>";
            }
            
            if($sw){
                $script[] = "$('#tab_link_".$pad_name."').click();";
                $classActive = "";
                $sw = false;
            }
                        
        }
        $elementHtml[] = array("script", $script);
        $elementHtml[] = array("tab", $tab);
        $elementHtml[] = array("section", $section);
        $scriptPad->close();
        return $elementHtml;
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement getPadUserProject");
        exit();
    }
}


/**
* Get body html for pad (for project and user and by reference email).
*/
function getBodyPadUsrProject($mysqli, $email){
    
}

/**
 * Get CUR Page URL
 * @return string
 */
function curPageURL() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/**
 * @param $params
 * @param null $url
 * @return mixed|null|string
 */
function setParameterForURL($params){
    $url = str_replace("/", "", $_SERVER["REQUEST_URI"]);
    $index = strpos($url, "?");
    $sep = "?";
    if ($index !== false){
        $sep = "&";
    }
    if (is_array($params)){
        foreach($params as $x => $x_value) {
            $sub_param = $x."=";
            $index = strpos($url, $sub_param);
            if ($index !== false){
                //echo "Esta el parametro: ".$x."="."<br/>";
                $url = substr_replace($url, $x_value, $index + strlen($sub_param));
                //echo "New URL: " . $url ."<br/>";
            }else {
                //echo "No Esta el parametro: ".$x."="."<br/>";
                $url = $url . $sep . $x ."=" . $x_value;
                //echo "New URL: " . $url ."<br/>";
            }
            $sep = "&";
        }
    }
    return $url;
}

/**
 * Get CUR Host.
 * @return string
 */
function curHost() {
    
    $pageURL = 'http';
    
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://".$_SERVER["SERVER_NAME"];

    return $pageURL;
}

/**
 * Get images for id user.
 * @param $id_user
 * @return mixed
 */
function getImgUser($id_user){
    $stmt = $mysqli->prepare("SELECT image FROM user WHERE id = ?");
    $stmt->bind_param("i", $id_user);

    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($image);
    $stmt->fetch();

    header("Content-Type: image/jpeg");
    return $image;
}


/**
 * @param $id_project
 * @param $id_user
 * @return bool
 */
function isUserToJoin($mysqli, $id_project, $id_user){
    if ($stmt = $mysqli->prepare("SELECT id_user, id_project 
				      FROM assigned_project_user 
				      WHERE id_user = ? AND id_project = ?")) {
        // Bind "$user_id" to parameter.
        $stmt->bind_param('ii', $id_user, $id_project );
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows >= 1) {
            return "T";
        } else {
            return "F";
        }
    }

}

/**
 * Function get Parameter for URL set formatter.
 * @param $url
 * @param $vars
 * @return string
 */
function get_parameter_url($vars, $url="index.php?"){
    $querystring = http_build_query($vars);
    return $url . $querystring;
}




