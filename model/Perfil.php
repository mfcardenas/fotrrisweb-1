<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 15/06/16
 * Time: 14:11
 */

class Perfil extends EntityBase {

    private $id;
    private $name;
    private $type;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;

    /**
     * Constructor.
     */
    public function __construct() {
        $table="perfil";
        $class = "Perfil";
        parent::__construct($table, $class);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id_perfil
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSnActive(){
        return $this->sn_active;
    }

    /**
     * @param mixed $sn_active
     */
    public function setSnActive($sn_active){
        $this->sn_active = $sn_active;
    }

    /**
     * @return mixed
     */
    public function getUserCreate(){
        return $this->user_create;
    }

    /**
     * @param mixed $user_create
     */
    public function setUserCreate($user_create){
        $this->user_create = $user_create;
    }

    /**
     * @return mixed
     */
    public function getUserModif(){
        return $this->user_modif;
    }

    /**
     * @param mixed $user_modif
     */
    public function setUserModif($user_modif){
        $this->user_modif = $user_modif;
    }

    /**
     * @return mixed
     */
    public function getDateCreate(){
        return $this->date_create;
    }

    /**
     * @param mixed $date_create
     */
    public function setDateCreate($date_create){
        $this->date_create = $date_create;
    }

    /**
     * @return mixed
     */
    public function getDateModif(){
        return $this->date_modif;
    }

    /**
     * @param mixed $date_modif
     */
    public function setDateModif($date_modif){
        $this->date_modif = $date_modif;
    }


    /**
     * @return bool|mysqli_result
     */
    public function save(){
        $key = "";
        try {
            if ($insert_stmt = $this->db()->prepare("INSERT INTO perfil (name, type, sn_active, date_create, user_create) VALUES (?, ?, ?, sysdate(), ? )")) {
                $insert_stmt->bind_param('ssss', $this->name, $this->type, $this->sn_active, $this->user_create);
                if (!$insert_stmt->execute()) {
                    $key = "901";
                }else{
                    $key = "100";
                }
            }else{
                $key = "908";
            }
        } catch (Exception $e) {
            header('Location: /error.php?err=' . $e->getMessage() . "\n");
        }
        return $key;
    }


}