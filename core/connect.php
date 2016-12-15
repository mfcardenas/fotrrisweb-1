<?php
class ConnectDB{
    private $driver;
    private $host, $user, $pass, $database, $charset;

    public function __construct() {
        require_once dirname(__DIR__).'/config/global.php';
        $this->driver=DRIVER;
        $this->host=HOST;
        $this->user=USER;
        $this->pass=PASSWORD;
        $this->database=DATABASE;
        $this->charset=CHARSET;
    }
    
    public function conexion(){

        if($this->driver=="mysql" || $this->driver==null){
            $conn=new mysqli($this->host, $this->user, $this->pass, $this->database);
            $conn->query("SET NAMES '".$this->charset."'");
        }
        
        return $conn;
    }
    
    public function startFluent(){
        require_once "FluentPDO/FluentPDO.php";
        
        if($this->driver=="mysql" || $this->driver==null){
            $pdo = new PDO($this->driver.":dbname=".$this->database, $this->user, $this->pass);
            $fpdo = new FluentPDO($pdo);
        }
        
        return $fpdo;
    }
}
?>
