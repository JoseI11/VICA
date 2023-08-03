<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = CpraEstadosController::singleton_cpra_estados();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addCpraEstado() {
    $controlador = CpraEstadosController::singleton_cpra_estados();
    
    echo $controlador->addCpraEstado  (    
                                        $_POST['descripcion']
            );
}

function updateCpraEstado() {
    $controlador = CpraEstadosController::singleton_cpra_estados();
    
    echo $controlador->updateCpraEstado(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteCpraEstado() {
    $controlador = CpraEstadosController::singleton_cpra_estados();
    
    echo $controlador->deleteCpraEstado($_POST['codigo']);
}

function getCpraEstado() {
    $controlador = CpraEstadosController::singleton_cpra_estados();
    
    echo $controlador->getCpraEstado($_POST['codigo']);
}

class CpraEstadosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/cpra_estados.model.php";
            $this->conn = CpraEstadosModel::singleton_cpra_estados();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_cpra_estados() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountCpraEstados(){
        return intval($this->conn->getCountCpraEstados()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/cpra_estados.busqueda.template.php";
        
    }
    
    public function addCpraEstado($descripcion) {
        $devuelve = $this->conn->addCpraEstado($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateCpraEstado($codigo, $descripcion) {
        $devuelve = $this->conn->updateCpraEstado($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteCpraEstado($codigo) {
        $devuelve = $this->conn->deleteCpraEstado($codigo);
        
        return $devuelve;
        
    }
    
    public function getCpraEstado($codigo) {
        $devuelve = $this->conn->getCpraEstado($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
