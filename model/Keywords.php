<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 18/06/16
 * Time: 1:38
 */

class Keywords extends EntityBase
{

    private $id;
    private $keyword;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;

    private $id_keyword;
    private $id_project;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $table = "keywords";
        $class = "keywords";
        parent::__construct($table, $class);
    }

    /**
     * @return mixed
     */
    public function getIdKeyword()
    {
        return $this->id_keyword;
    }

    /**
     * @param mixed $id_keyword
     */
    public function setIdKeyword($id_keyword)
    {
        $this->id_keyword = $id_keyword;
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
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param mixed $keyword
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
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
     * @return bool|mysqli_result
     */
    public function save()
    {
        $key = "";
        try {
            if ($insert_stmt = $this->db()->prepare("INSERT INTO keywords (keyword, sn_active, date_create, user_create) VALUES (?, ?, sysdate(), ?)")) {
                $null = NULL;
                $insert_stmt->bind_param('sss', $this->keyword, $this->sn_active, $this->user_create);
                if (!$insert_stmt->execute()) {
                    $key = "901";
                } else {
                    $key = "100";
                }
            } else {
                $key = $this->db()->error;//"908";
            }
        } catch (Exception $e) {
            header('Location: /error.php?err=' . $e->getMessage() . "\n");
        }
        return $key;
    }
}
