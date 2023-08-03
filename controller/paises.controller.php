<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = PaisesController::singleton_paises();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addPaise() {
    $controlador = PaisesController::singleton_paises();
    
    echo $controlador->addPaise  (    
                                        $_POST['descripcion']
            );
}

function updatePaise() {
    $controlador = PaisesController::singleton_paises();
    
    echo $controlador->updatePaise(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deletePaise() {
    $controlador = PaisesController::singleton_paises();
    
    echo $controlador->deletePaise($_POST['codigo']);
}

function getPaise() {
    $controlador = PaisesController::singleton_paises();
    
    echo $controlador->getPaise($_POST['codigo']);
}

class PaisesController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/paises.model.php";
            $this->conn = PaisesModel::singleton_paises();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_paises() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountPaises(){
        return intval($this->conn->getCountPaises()[0]);
        
    }

    
    public function getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda){
        
        $_SESSION["pagina"] = $pagina;
        
        $_SESSION["cant_reg"] = $registros;
        
        $_SESSION["busqueda"] = $busqueda;
                
        $_SESSION['orderby'] = $orderby;
        
        $_SESSION['sentido'] = $sentido;
        
        $devuelve = $this->conn->getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda);
                                
        $registros = $devuelve;
        
        $_SESSION['registros'] = $registros;

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/paises.busqueda.template.php";
        
    }
    
    public function addPaise($descripcion) {
        $devuelve = $this->conn->addPaise($descripcion);
        
        return $devuelve;
        
    }
    
    public function updatePaise($codigo, $descripcion) {
        $devuelve = $this->conn->updatePaise($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deletePaise($codigo) {
        $devuelve = $this->conn->deletePaise($codigo);
        
        return $devuelve;
        
    }
    
    public function getPaise($codigo) {
        $devuelve = $this->conn->getPaise($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
