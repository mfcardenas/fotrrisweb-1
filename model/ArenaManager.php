<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 18/06/16
 * Time: 1:38
 */

class ArenaManager extends EntityBase
{

    private $id_arena;
    private $id_user;
    private $sn_active;
    private $user_create;
    private $user_modif;
    private $date_create;
    private $date_modif;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $table = "arena_manager";
        $class = "ArenaManager";
        parent::__construct($table, $class);
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
     */
    public function setIdArena($id_arena)
    {
        $this->id_arena = $id_arena;
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
            if ($insert_stmt = $this->db()->prepare("INSERT INTO arena_manager (id_arena, id_user, sn_active, date_create, user_create) VALUES (?, ?, ?, sysdate(), ?)")) {
                $null = NULL;
                $insert_stmt->bind_param('iiss', $this->id_arena, $this->id_user, $this->sn_active, $this->user_create);
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
