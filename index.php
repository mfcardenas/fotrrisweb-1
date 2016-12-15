<?php
//Configuración global
//define global variables for all application 
require_once 'config/global.php';
require_once 'includes/translate.php';

//Base para los controladores
require_once 'core/ControllerBase.php';

//Funciones para el controlador frontal
require_once 'core/ControllerFront.php';

//Cargamos controladores y acciones
if(isset($_GET["controller"])){
    $controllerObj=cargarControlador($_GET["controller"]);
    lanzarAccion($controllerObj);
}else{
    header('Location: home.php');
}

