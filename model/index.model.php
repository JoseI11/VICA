<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class IndexModel {
    private static $instancia;
    private $conn;

    public function __construct() {
        try {                
            $this->conn = Conexion::singleton_conexion();
        } catch ( Exception $e ) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_index() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function logueo($user,$pass){
        try {
         
            $sql = "select * from usuarios where usuario = '" . $user . "' and password = '" . md5($pass) . "';";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                $_SESSION["usuario"] = $user;
                $_SESSION["password"] = $pass;
                $_SESSION["cargo"] = $result[0]["cargo"];
                $_SESSION["nombre"] = $result[0]["nombre"];
                $_SESSION["cod_rol"] = $result[0]["cod_rol"];
                return 0;
            } else {
                return 1;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
        
    }
}	
?>