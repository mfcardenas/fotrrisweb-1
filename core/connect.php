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

    /**
     * @var null
     */
    private static $conn = NULL;

    /**
     *
     */
    private function __clone() {

    }

//    public static function __getConn() {
//        if (!isset(self::$conn)) {
//            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
//            self::$conn = new PDO(DRIVER.':host='.HOST.';dbname='.DATABASE, USER, PASSWORD, $pdo_options);
//        }
//        return self::$conn;
//    }
    
    public function conexion(){
        $conn = null;
        if($this->driver=="mysql" || $this->driver==null){
            $conn = new mysqli($this->host, $this->user, $this->pass, $this->database);
            $conn->query("SET NAMES '".$this->charset."'");
        }
        
        return $conn;
    }
    
    public function startFluent(){
        $fpdo = null;
        require_once "FluentPDO/FluentPDO.php";
        
        if($this->driver=="mysql" || $this->driver==null){
            $pdo = new PDO($this->driver.":dbname=".$this->database, $this->user, $this->pass);
            $fpdo = new FluentPDO($pdo);
        }
        
        return $fpdo;
    }

//    public static function __startFluent(){
//        $fpdo = null;
//        require_once "FluentPDO/FluentPDO.php";
//        $pdo = ConnectDB::getConn();
//        if($pdo !=null){
//            $fpdo = new FluentPDO($pdo);
//        }
//
//        return $fpdo;
//    }
}
?>
