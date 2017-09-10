<?php
class EntityBase{
    private $table;
    private $class;
    private $db;
    private $conn;

    /**
     * EntidadBase constructor.
     * @param $table
     */
    public function __construct($table, $class = null){
        $this->table=(string) $table;
        $this->class=(string) $class;
        require_once 'connect.php';
        $this->conn = new ConnectDB();
        $this->db=$this->conn->conexion();
        //$this->db = ConnectDB::getConn();
    }

    /**
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getConectar(){
        return $this->conn;
    }
    
    public function db(){
        return $this->db;
    }
    
    public function getAll(){
        $resultSet = null;
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY id DESC");
        while ($row = $query->fetch_object($this->class)) {
           $resultSet[]=$row;
        }
        return $resultSet;
    }

    public function getById($id){
        $resultSet = null;
        $query=$this->db->query("SELECT * FROM $this->table WHERE id = $id");

        if($row = $query->fetch_object($this->class)) {
           $resultSet=$row;
        }
        
        return $resultSet;
    }
    
    public function getBy($column,$value){
        $resultSet = null;
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column = '$value'");
        while($row = $query->fetch_object($this->class)) {
           $resultSet[] = $row;
        }
        return $resultSet;
    }
    
    public function deleteById($id){
        $query=$this->db->query("DELETE FROM $this->table WHERE id = $id");
        return $query;
    }

    public function inactiveById($id){
        $query=$this->db->query("UPDATE $this->table SET sn_active = 'N' WHERE id = $id");
        return $query;
    }

    public function changeStatusById($id, $status){
        $query=$this->db->query("UPDATE $this->table SET sn_active = '".$status."' WHERE id = $id");
        return $query;
    }

    public function inactiveBy($column,$value){
        $query=$this->db->query("UPDATE $this->table  SET sn_active = 'N' WHERE $column = '$value'");
        return $query;
    }
    
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column = '$value'");
        return $query;
    }

    /*
     * Aqui podemos montarnos un monton de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
    
}
?>
