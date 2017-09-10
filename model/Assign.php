<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 15/06/16
 * Time: 14:11
 */

class Assign extends EntityBase {

    private $id;
    private $id_project;
    private $id_user;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;
    private $date_to;
    private $date_from;
    private $name_project;
    private $name_hub;
    private $name_user;
    private $email;

    /**
     * Constructor.
     */
    public function __construct() {
        $table="assigned_project_user";
        $class = "Assign";
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
    public function getIdProject()
    {
        return $this->id_project;
    }

    /**
     * @param mixed $id_project
     */
    public function setIdProject($id_project)
    {
        $this->id_project = $id_project;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getDateTo()
    {
        return $this->date_to;
    }

    /**
     * @param mixed $date_to
     */
    public function setDateTo($date_to)
    {
        $this->date_to = $date_to;
    }

    /**
     * @return mixed
     */
    public function getDateFrom()
    {
        return $this->date_from;
    }

    /**
     * @param mixed $date_from
     */
    public function setDateFrom($date_from)
    {
        $this->date_from = $date_from;
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
     * @return mixed
     */
    public function getNameProject()
    {
        return $this->name_project;
    }

    /**
     * @param mixed $name_project
     */
    public function setNameProject($name_project)
    {
        $this->name_project = $name_project;
    }

    /**
     * @return mixed
     */
    public function getNameHub()
    {
        return $this->name_hub;
    }

    /**
     * @param mixed $name_hub
     */
    public function setNameHub($name_hub)
    {
        $this->name_hub = $name_hub;
    }

    /**
     * @return mixed
     */
    public function getNameUser()
    {
        return $this->name_user;
    }

    /**
     * @param mixed $name_user
     */
    public function setNameUser($name_user)
    {
        $this->name_user = $name_user;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

     /**
     * @return bool|mysqli_result
     */
    public function save(){
        $key = "";
        try {
            if ($insert_stmt = $this->db()->prepare("INSERT INTO assigned_project_user (id_project, id_user, date_from, date_to, sn_active, date_create, user_create) VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'), ?, sysdate(), ? )")) {
                $insert_stmt->bind_param('iissss', $this->id_project, $this->id_user, $this->date_from, $this->date_to, $this->sn_active, $this->user_create);
                if (!$insert_stmt->execute()) {
                    $key = "901";
                }else{
                    $key = "100";
                }
            }else{
                $key = $this->db()->error;//"908";
            }
        } catch (Exception $e) {
            header('Location: /error.php?err=' . $e->getMessage() . "\n");
        }
        return $key;
    }


}