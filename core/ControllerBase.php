<?php

class ControllerBase{

    private $combo;
    private $gm;

    public function __construct() {
        require_once 'EntityBase.php';
        require_once 'ModelBase.php';
        require_once 'Combo.php';
        require_once 'model/globalModel.php';
        
        require_once 'includes/gerror.php';

        $this->combo = new Combo();
        $this->gm = new GlobalModel();

        //Incluir todos los modelos
        foreach(glob(dirname(__DIR__)."/model/*.php") as $file){
            require_once $file;
        }
    }

    //Plugins y funcionalidades

    public function view($vista, $entity, $datos){
        foreach ($datos as $id_assoc => $valor) {
            ${$id_assoc}=$valor;
        }

        require_once dirname(__DIR__).'/core/HelpView.php';

        $helper = new HelpView();

        require_once $vista. $entity .'.php';
    }

    public function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO, $param=""){
        $arg_param = "";
        if ($param != '') {
            $arg_param = "&param=".$param;
        }
        header("Location:index.php?controller=".$controlador."&action=".$accion.$arg_param);

    }

    /**
     * @return Combo
     */
    public function getCombo()
    {
        return $this->combo;
    }

    /**
     * @param Combo $combo
     */
    public function setCombo($combo) {
        $this->combo = $combo;
    }

    /**
     * @param $param
     * @return array
     */
    function getParameter($param){
        if ($param != ''){
            return $parameter = explode("_", $param);
        }
    }

    /**
     * Function Generate Password Random.
     * @return string
     */
    function randomPass() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    /**
     * @return GlobalModel
     */
    public function getGm() {
        return $this->gm;
    }

    /**
     * @param GlobalModel $gm
     */
    public function setGm(GlobalModel $gm)
    {
        $this->gm = $gm;
    }

}

