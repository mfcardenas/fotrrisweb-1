<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 15/06/16
 * Time: 14:01
 */

/**
 * Class Arena.
 */
class Arena extends EntityBase{

    private $id;
    private $name;
    private $place;
    private $address;
    private $responsable;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;
    private $id_user_list;
    private $managers;

    /**
     * Constructor.
     */
    public function __construct() {
        $table="arena";
        $class = "Arena";
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
     * @param mixed $id
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
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param mixed $responsable
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
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
    public function getIdUserList()
    {
        return $this->id_user_list;
    }

    /**
     * @param mixed $id_user_list
     */
    public function setIdUserList($id_user_list)
    {
        $this->id_user_list = $id_user_list;
    }

    /**
     * @return mixed
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * @param mixed $managers
     */
    public function setManagers($managers)
    {
        $this->managers = $managers;
    }

     /**
     * @return bool|mysqli_result
     */
    public function save(){
        $key = "";
        try {
            if ($insert_stmt = $this->db()->prepare("INSERT INTO arena (name, place, address, responsable, sn_active, date_create, user_create) VALUES (?, ?, ?, ?, ?, sysdate(), ?)")) {
                $null = NULL;
                $insert_stmt->bind_param('ssssss', $this->name, $this->place, $this->address, $this->responsable, $this->sn_active, $this->user_create);
                if (!$insert_stmt->execute()) {
                    $key = "901";
                }else{
                    $_id = $insert_stmt->insert_id;
                    $this->setId($_id);
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