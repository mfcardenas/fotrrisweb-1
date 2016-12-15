<?php
// function for main controller
/**
 * @param $controller
 * @return mixed
 */
function cargarControlador($controller){
    $controlador=ucwords($controller).'Controller';
    $strFileController='controller/'.$controlador.'.php';
    
    if(!is_file($strFileController)){
        $strFileController='controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php';   
    }
    
    require_once $strFileController;
    $controllerObj=new $controlador();
    return $controllerObj;
}

/**
 * @param $controllerObj
 * @param $action
 */
function cargarAccion($controllerObj,$action){
    $accion=$action;
    $controllerObj->$accion(getParam());
}

/**
 * @return string
 */
function getParam(){
    $param = "";
    if(isset($_GET["param"])){
        $param = $_GET["param"];
    }
    return $param;
}

/**
 * @param $controllerObj
 */
function lanzarAccion($controllerObj){
    if(isset($_GET["action"]) && method_exists($controllerObj, $_GET["action"])){
        cargarAccion($controllerObj, $_GET["action"]);
    }else{
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
}

?>
