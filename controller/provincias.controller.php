<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = ProvinciasController::singleton_provincias();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addProvincia() {
    $controlador = ProvinciasController::singleton_provincias();
    
    echo $controlador->addProvincia  (    
                                        $_POST['descripcion']
            );
}

function updateProvincia() {
    $controlador = ProvinciasController::singleton_provincias();
    
    echo $controlador->updateProvincia(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteProvincia() {
    $controlador = ProvinciasController::singleton_provincias();
    
    echo $controlador->deleteProvincia($_POST['codigo']);
}

function getProvincia() {
    $controlador = ProvinciasController::singleton_provincias();
    
    echo $controlador->getProvincia($_POST['codigo']);
}

class ProvinciasController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/provincias.model.php";
            $this->conn = ProvinciasModel::singleton_provincias();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_provincias() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountProvincias(){
        return intval($this->conn->getCountProvincias()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/provincias.busqueda.template.php";
        
    }
    
    public function addProvincia($descripcion) {
        $devuelve = $this->conn->addProvincia($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateProvincia($codigo, $descripcion) {
        $devuelve = $this->conn->updateProvincia($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteProvincia($codigo) {
        $devuelve = $this->conn->deleteProvincia($codigo);
        
        return $devuelve;
        
    }
    
    public function getProvincia($codigo) {
        $devuelve = $this->conn->getProvincia($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
