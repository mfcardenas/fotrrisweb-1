<?php

/**
 * Class User.
 */
class User extends EntityBase{
    private $id;
    private $name;
    private $username;
    private $email;
    private $password;
    private $id_perfil;
    private $image;
    private $image_type;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;
    private $picture;
    private $salt;

    private $institution;
    private $location;

    /**
     * @return mixed
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * @param mixed $institution
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Usuario constructor.
     */
    public function __construct() {
        $table="user";
        $class="User";
        parent::__construct($table, $class);
    }

    /**
     * @return mixed
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture) {
        //$this->picture = mysqli_real_escape_string($this->db(), $picture);
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name) {
        $this->name= $name;
    }

    /**
     * @return mixed
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username){
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getIdPerfil() {
        return $this->id_perfil;
    }

    /**
     * @param $idPerfil
     */
    public function setIdPerfil($id_perfil) {
        $this->id_perfil  = $id_perfil;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param $password
     */
    public function setPassword($password) {
        $this->password = $password;
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
    public function getImageType()
    {
        return $this->image_type;
    }

    /**
     * @param mixed $image_type
     */
    public function setImageType($image_type)
    {
        $this->image_type = $image_type;
    }

        /**
     * @return bool|mysqli_result
     */
    public function save(){
        $key = "";
        try {
            // Create a random salt
            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

            // Create salted password
            $password = hash('sha512', $this->password . $random_salt);
            $userapp = ($this->user_create!='')?$this->user_create:"userweb";

            if ($insert_stmt = $this->db()->prepare("INSERT INTO user (name, username, email, password, salt, id_perfil, sn_active, date_create, user_create, image_type,image) VALUES (?, ?, ?, ?, ?, ?, ?, sysdate(), ?, ?, ? )")) {
                $null = NULL;
                $insert_stmt->bind_param('sssssisssb', $this->name, $this->username, $this->email, $password, $random_salt, $this->id_perfil, $this->sn_active, $userapp , $this->image_type, $null);
                if ($this->picture != null && $this->picture != ''){
                    $insert_stmt->send_long_data(9, $this->picture);
                }

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
