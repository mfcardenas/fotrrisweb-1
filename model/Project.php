<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 14/06/16
 * Time: 15:55
 */


/**
 * Class Project.
 */
class Project extends EntityBase{
    private $id;
    private $name;
    private $id_arena;
    private $name_arena;
    private $ubication;
    private $date_from;
    private $date_to;
    private $desc_project;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;
    private $keywords;

    private $sn_abstract;
    private $sn_repository;

    private $images;
    private $webSite;

    private $num_pad;
    private $num_keywords;
    private $num_user;

    private $name_pad_0;
    private $desc_pad_0;

    private $name_pad_1;
    private $desc_pad_1;

    private $name_pad_2;
    private $desc_pad_2;

    private $name_pad_3;
    private $desc_pad_3;

    private $name_pad_4;
    private $desc_pad_4;

    private $name_pad_5;
    private $desc_pad_5;

    private $name_pad_6;
    private $desc_pad_6;

    private $name_pad_7;
    private $desc_pad_7;

    private $name_pad_8;
    private $desc_pad_8;

    private $name_pad_9;
    private $desc_pad_9;

    private $name_pad_10;
    private $desc_pad_10;

    private $name_pad_11;
    private $desc_pad_11;

    private $name_pad_12;
    private $desc_pad_12;

    private $name_pad_13;
    private $desc_pad_13;

    private $name_pad_14;
    private $desc_pad_14;

    private $name_pad_15;
    private $desc_pad_15;

    /**
     * Usuario constructor.
     */
    public function __construct() {
        $table="project";
        $class = "Project";
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
     * @return Project
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @param mixed $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdArena()
    {
        return $this->id_arena;
    }

    /**
     * @param mixed $id_arena
     * @return Project
     */
    public function setIdArena($id_arena)
    {
        $this->id_arena = $id_arena;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNameArena()
    {
        return $this->name_arena;
    }

    /**
     * @param mixed $name_arena
     */
    public function setNameArena($name_arena)
    {
        $this->name_arena = $name_arena;
    }

    /**
     * @return mixed
     */
    public function getUbication()
    {
        return $this->ubication;
    }

    /**
     * @param mixed $ubication
     * @return Project
     */
    public function setUbication($ubication)
    {
        $this->ubication = $ubication;
        return $this;
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
     * @return Project
     */
    public function setDateFrom($date_from)
    {
        $this->date_from = $date_from;
        return $this;
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
     * @return Project
     */
    public function setDateTo($date_to)
    {
        $this->date_to = $date_to;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescProject()
    {
        return $this->desc_project;
    }

    /**
     * @param mixed $desc_project
     * @return Project
     */
    public function setDescProject($desc_project)
    {
        $this->desc_project = $desc_project;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * @param mixed $webSite
     */
    public function setWebSite($webSite)
    {
        $this->webSite = $webSite;
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
    public function getNumPad()
    {
        return $this->num_pad;
    }

    /**
     * @param mixed $num_pad
     */
    public function setNumPad($num_pad)
    {
        $this->num_pad = $num_pad;
    }

    /**
     * @return mixed
     */
    public function getNumKeywords()
    {
        return $this->num_keywords;
    }

    /**
     * @param mixed $num_keywords
     */
    public function setNumKeywords($num_keywords)
    {
        $this->num_keywords = $num_keywords;
    }

    /**
     * @return mixed
     */
    public function getNumUser()
    {
        return $this->num_user;
    }

    /**
     * @param mixed $num_user
     */
    public function setNumUser($num_user)
    {
        $this->num_user = $num_user;
    }

    /**
     * @return mixed
     */
    public function getNamePad1()
    {
        return $this->name_pad_1;
    }

    /**
     * @param mixed $name_pad_1
     */
    public function setNamePad1($name_pad_1)
    {
        $this->name_pad_1 = $name_pad_1;
    }

    /**
     * @return mixed
     */
    public function getDescPad1()
    {
        return $this->desc_pad_1;
    }

    /**
     * @param mixed $desc_pad_1
     */
    public function setDescPad1($desc_pad_1)
    {
        $this->desc_pad_1 = $desc_pad_1;
    }

    /**
     * @return mixed
     */
    public function getNamePad2()
    {
        return $this->name_pad_2;
    }

    /**
     * @param mixed $name_pad_2
     */
    public function setNamePad2($name_pad_2)
    {
        $this->name_pad_2 = $name_pad_2;
    }

    /**
     * @return mixed
     */
    public function getDescPad2()
    {
        return $this->desc_pad_2;
    }

    /**
     * @param mixed $desc_pad_2
     */
    public function setDescPad2($desc_pad_2)
    {
        $this->desc_pad_2 = $desc_pad_2;
    }

    /**
     * @return mixed
     */
    public function getNamePad3()
    {
        return $this->name_pad_3;
    }

    /**
     * @param mixed $name_pad_3
     */
    public function setNamePad3($name_pad_3)
    {
        $this->name_pad_3 = $name_pad_3;
    }

    /**
     * @return mixed
     */
    public function getDescPad3()
    {
        return $this->desc_pad_3;
    }

    /**
     * @param mixed $desc_pad_3
     */
    public function setDescPad3($desc_pad_3)
    {
        $this->desc_pad_3 = $desc_pad_3;
    }

    /**
     * @return mixed
     */
    public function getNamePad4()
    {
        return $this->name_pad_4;
    }

    /**
     * @param mixed $name_pad_4
     */
    public function setNamePad4($name_pad_4)
    {
        $this->name_pad_4 = $name_pad_4;
    }

    /**
     * @return mixed
     */
    public function getDescPad4()
    {
        return $this->desc_pad_4;
    }

    /**
     * @param mixed $desc_pad_4
     */
    public function setDescPad4($desc_pad_4)
    {
        $this->desc_pad_4 = $desc_pad_4;
    }

    /**
     * @return mixed
     */
    public function getNamePad5()
    {
        return $this->name_pad_5;
    }

    /**
     * @param mixed $name_pad_5
     */
    public function setNamePad5($name_pad_5)
    {
        $this->name_pad_5 = $name_pad_5;
    }

    /**
     * @return mixed
     */
    public function getDescPad5()
    {
        return $this->desc_pad_5;
    }

    /**
     * @param mixed $desc_pad_5
     */
    public function setDescPad5($desc_pad_5)
    {
        $this->desc_pad_5 = $desc_pad_5;
    }

    /**
     * @return mixed
     */
    public function getNamePad6()
    {
        return $this->name_pad_6;
    }

    /**
     * @param mixed $name_pad_6
     */
    public function setNamePad6($name_pad_6)
    {
        $this->name_pad_6 = $name_pad_6;
    }

    /**
     * @return mixed
     */
    public function getDescPad6()
    {
        return $this->desc_pad_6;
    }

    /**
     * @param mixed $desc_pad_6
     */
    public function setDescPad6($desc_pad_6)
    {
        $this->desc_pad_6 = $desc_pad_6;
    }

    /**
     * @return mixed
     */
    public function getNamePad7()
    {
        return $this->name_pad_7;
    }

    /**
     * @param mixed $name_pad_7
     */
    public function setNamePad7($name_pad_7)
    {
        $this->name_pad_7 = $name_pad_7;
    }

    /**
     * @return mixed
     */
    public function getDescPad7()
    {
        return $this->desc_pad_7;
    }

    /**
     * @param mixed $desc_pad_7
     */
    public function setDescPad7($desc_pad_7)
    {
        $this->desc_pad_7 = $desc_pad_7;
    }

    /**
     * @return mixed
     */
    public function getNamePad8()
    {
        return $this->name_pad_8;
    }

    /**
     * @param mixed $name_pad_8
     */
    public function setNamePad8($name_pad_8)
    {
        $this->name_pad_8 = $name_pad_8;
    }

    /**
     * @return mixed
     */
    public function getDescPad8()
    {
        return $this->desc_pad_8;
    }

    /**
     * @param mixed $desc_pad_8
     */
    public function setDescPad8($desc_pad_8)
    {
        $this->desc_pad_8 = $desc_pad_8;
    }

    /**
     * @return mixed
     */
    public function getNamePad9()
    {
        return $this->name_pad_9;
    }

    /**
     * @param mixed $name_pad_9
     */
    public function setNamePad9($name_pad_9)
    {
        $this->name_pad_9 = $name_pad_9;
    }

    /**
     * @return mixed
     */
    public function getDescPad9()
    {
        return $this->desc_pad_9;
    }

    /**
     * @param mixed $desc_pad_9
     */
    public function setDescPad9($desc_pad_9)
    {
        $this->desc_pad_9 = $desc_pad_9;
    }

    /**
     * @return mixed
     */
    public function getNamePad10()
    {
        return $this->name_pad_10;
    }

    /**
     * @param mixed $name_pad_10
     */
    public function setNamePad10($name_pad_10)
    {
        $this->name_pad_10 = $name_pad_10;
    }

    /**
     * @return mixed
     */
    public function getDescPad10()
    {
        return $this->desc_pad_10;
    }

    /**
     * @param mixed $desc_pad_10
     */
    public function setDescPad10($desc_pad_10)
    {
        $this->desc_pad_10 = $desc_pad_10;
    }

    /**
     * @return mixed
     */
    public function getNamePad0()
    {
        return $this->name_pad_0;
    }

    /**
     * @param mixed $name_pad_0
     */
    public function setNamePad0($name_pad_0)
    {
        $this->name_pad_0 = $name_pad_0;
    }

    /**
     * @return mixed
     */
    public function getDescPad0()
    {
        return $this->desc_pad_0;
    }

    /**
     * @param mixed $desc_pad_0
     */
    public function setDescPad0($desc_pad_0)
    {
        $this->desc_pad_0 = $desc_pad_0;
    }

    /**
     * @return mixed
     */
    public function getNamePad11()
    {
        return $this->name_pad_11;
    }

    /**
     * @param mixed $name_pad_11
     */
    public function setNamePad11($name_pad_11)
    {
        $this->name_pad_11 = $name_pad_11;
    }

    /**
     * @return mixed
     */
    public function getDescPad11()
    {
        return $this->desc_pad_11;
    }

    /**
     * @param mixed $desc_pad_11
     */
    public function setDescPad11($desc_pad_11)
    {
        $this->desc_pad_11 = $desc_pad_11;
    }

    /**
     * @return mixed
     */
    public function getNamePad12()
    {
        return $this->name_pad_12;
    }

    /**
     * @param mixed $name_pad_12
     */
    public function setNamePad12($name_pad_12)
    {
        $this->name_pad_12 = $name_pad_12;
    }

    /**
     * @return mixed
     */
    public function getDescPad12()
    {
        return $this->desc_pad_12;
    }

    /**
     * @param mixed $desc_pad_12
     */
    public function setDescPad12($desc_pad_12)
    {
        $this->desc_pad_12 = $desc_pad_12;
    }

    /**
     * @return mixed
     */
    public function getNamePad13()
    {
        return $this->name_pad_13;
    }

    /**
     * @param mixed $name_pad_13
     */
    public function setNamePad13($name_pad_13)
    {
        $this->name_pad_13 = $name_pad_13;
    }

    /**
     * @return mixed
     */
    public function getDescPad13()
    {
        return $this->desc_pad_13;
    }

    /**
     * @param mixed $desc_pad_13
     */
    public function setDescPad13($desc_pad_13)
    {
        $this->desc_pad_13 = $desc_pad_13;
    }

    /**
     * @return mixed
     */
    public function getNamePad14()
    {
        return $this->name_pad_14;
    }

    /**
     * @param mixed $name_pad_14
     */
    public function setNamePad14($name_pad_14)
    {
        $this->name_pad_14 = $name_pad_14;
    }

    /**
     * @return mixed
     */
    public function getDescPad14()
    {
        return $this->desc_pad_14;
    }

    /**
     * @param mixed $desc_pad_14
     */
    public function setDescPad14($desc_pad_14)
    {
        $this->desc_pad_14 = $desc_pad_14;
    }

    /**
     * @return mixed
     */
    public function getNamePad15()
    {
        return $this->name_pad_15;
    }

    /**
     * @param mixed $name_pad_15
     */
    public function setNamePad15($name_pad_15)
    {
        $this->name_pad_15 = $name_pad_15;
    }

    /**
     * @return mixed
     */
    public function getDescPad15()
    {
        return $this->desc_pad_15;
    }

    /**
     * @param mixed $desc_pad_15
     */
    public function setDescPad15($desc_pad_15)
    {
        $this->desc_pad_15 = $desc_pad_15;
    }

    /**
     * @return mixed
     */
    public function getSnAbstract()
    {
        return $this->sn_abstract;
    }

    /**
     * @param mixed $snAbstract
     */
    public function setSnAbstract($sn_abstract)
    {
        $this->sn_abstract = $sn_abstract;
    }

    /**
     * @return mixed
     */
    public function getSnRepository()
    {
        return $this->sn_repository;
    }

    /**
     * @param mixed $snRepository
     */
    public function setSnRepository($sn_repository)
    {
        $this->sn_repository = $sn_repository;
    }

    /**
     * @return bool|mysqli_result
     */
    public function saveProject() {
        $create_pad = false;
        try {
            $query = "INSERT INTO project (name, id_arena, ubication, desc_project, date_from, date_to, sn_active, sn_abstract, sn_repository, date_create, user_create, num_pad) VALUES (?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y'),STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, sysdate(), ?, ?)";

            // Insert the new project into the database
            if ($insert_stmt_p = $this->db()->prepare($query)) {
                $insert_stmt_p->bind_param('sissssssssi', $this->name, $this->id_arena, $this->ubication, $this->desc_project, $this->date_from, $this->date_to, $this->sn_active, $this->sn_abstract, $this->sn_repository, $this->user_create, $this->num_pad);
                // Execute the prepared query.
                if (!$insert_stmt_p->execute()) {
                    $create_pad = false;
                    $this->db()->rollback();
                    trigger_error($insert_stmt_p->error, E_USER_ERROR);
                    exit();
                } else {
                    $id_project = $insert_stmt_p->insert_id;
                }
            }
        } catch (Exception $e) {
            $this->db()->rollback();
            //header('Location: ../error.php?err=' . $e->getMessage() . "\n");
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
        return $create_pad;
    }

}