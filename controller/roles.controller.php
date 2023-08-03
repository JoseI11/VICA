<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = RolesController::singleton_roles();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addRol() {
    $controlador = RolesController::singleton_roles();
    
    echo $controlador->addRol  (    
                                        $_POST['descripcion']
            );
}

function updateRol() {
    $controlador = RolesController::singleton_roles();
    
    echo $controlador->updateRol(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteRol() {
    $controlador = RolesController::singleton_roles();
    
    echo $controlador->deleteRol($_POST['codigo']);
}

function getRol() {
    $controlador = RolesController::singleton_roles();
    
    echo $controlador->getRol($_POST['codigo']);
}

class RolesController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/roles.model.php";
            $this->conn = RolesModel::singleton_roles();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_roles() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountRoles(){
        return intval($this->conn->getCountRoles()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/roles.busqueda.template.php";
        
    }
    
    public function addRol($descripcion) {
        $devuelve = $this->conn->addRol($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateRol($codigo, $descripcion) {
        $devuelve = $this->conn->updateRol($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteRol($codigo) {
        $devuelve = $this->conn->deleteRol($codigo);
        
        return $devuelve;
        
    }
    
    public function getRol($codigo) {
        $devuelve = $this->conn->getRol($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
