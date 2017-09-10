<?php
class ModelBase extends EntityBase{
    private $table;
    private $fluent;

    /**
     * ModeloBase constructor.
     * @param $table
     */
    public function __construct($table) {
        parent::__construct($table);
        $this->table=(string) $table;
        $this->fluent = $this->getConectar()->startFluent();
        //$this->fluent = ConnectDB::startFluent();
    }

    /**
     * @return FluentPDO
     */
    public function fluent(){
        return $this->fluent;
    }

    /**
     * @param $query
     * @return array|bool|object|stdClass
     */
    public function ejecutarSql($query){
        $resultSet = '';
        $query=$this->db()->query($query);
        if($query==true){
            if($query->num_rows>1){
                while($row = $query->fetch_object()) {
                   $resultSet[]=$row;
                }
            }elseif($query->num_rows==1){
                if($row = $query->fetch_object()) {
                    $resultSet=$row;
                }
            }else{
                $resultSet=true;
            }
        }else{
            $resultSet=false;
        }
        $query->close();
        return $resultSet;
    }

    /**
     * @param $query
     * @return array|bool|stdClass
     */
    public function ejecutarSqlCl($query, $class){
        $resultSet = '';
        $query=$this->db()->query($query);
        if($query==true){
            if($query->num_rows>=1){
                while($row = $query->fetch_object($class)) {
                    $resultSet[]=$row;
                }
            }else{
                $resultSet=true;
            }
        }else{
            $resultSet=false;
        }
        $query->close();
        return $resultSet;
    }
    
    
}



