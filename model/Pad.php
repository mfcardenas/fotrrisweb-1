<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 18/06/16
 * Time: 1:30
 */

class Pad extends EntityBase
{

    private $id;
    private $pad_name;
    private $filename_config;
    private $id_project;
    private $pad_name_view;
    private $description;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;
    private $type;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $table = "group_pad";
        $class = "Pad";
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
    public function getPadName()
    {
        return $this->pad_name;
    }

    /**
     * @param mixed $pad_name
     */
    public function setPadName($pad_name)
    {
        $this->pad_name = $pad_name;
    }

    /**
     * @return mixed
     */
    public function getFilenameConfig()
    {
        return $this->filename_config;
    }

    /**
     * @param mixed $filename_config
     */
    public function setFilenameConfig($filename_config)
    {
        $this->filename_config = $filename_config;
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
    public function getPadNameView()
    {
        return $this->pad_name_view;
    }

    /**
     * @param mixed $pad_name_view
     */
    public function setPadNameView($pad_name_view)
    {
        $this->pad_name_view = $pad_name_view;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSnActive()
    {
        return $this->sn_active;
    }

    /**
     * @param mixed $sn_active
     */
    public function setSnActive($sn_active)
    {
        $this->sn_active = $sn_active;
    }

    /**
     * @return mixed
     */
    public function getUserCreate()
    {
        return $this->user_create;
    }

    /**
     * @param mixed $user_create
     */
    public function setUserCreate($user_create)
    {
        $this->user_create = $user_create;
    }

    /**
     * @return mixed
     */
    public function getUserModif()
    {
        return $this->user_modif;
    }

    /**
     * @param mixed $user_modif
     */
    public function setUserModif($user_modif)
    {
        $this->user_modif = $user_modif;
    }

    /**
     * @return mixed
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * @param mixed $date_create
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = $date_create;
    }

    /**
     * @return mixed
     */
    public function getDateModif()
    {
        return $this->date_modif;
    }

    /**
     * @param mixed $date_modif
     */
    public function setDateModif($date_modif)
    {
        $this->date_modif = $date_modif;
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
     * @return bool|mysqli_result
     */
    public function save(){
        $key = "";
        try {
            if ($insert_stmt = $this->db()->prepare("INSERT INTO group_pad (pad_name, filename_config, sn_active, type, date_create, user_create, id_project, pad_name_view, description) VALUES (?, ?, ?, ?, sysdate(), ?, ?, ?, ?)")) {
                $null = NULL;
                $insert_stmt->bind_param('sssssiss', $this->pad_name, $this->filename_config, $this->sn_active, $this->type, $this->user_create, $this->id_project, $this->pad_name_view, $this->description);
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