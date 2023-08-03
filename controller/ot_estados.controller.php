<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = OtEstadosController::singleton_ot_estados();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addOtEstado() {
    $controlador = OtEstadosController::singleton_ot_estados();
    
    echo $controlador->addOtEstado  (    
                                        $_POST['descripcion']
            );
}

function updateOtEstado() {
    $controlador = OtEstadosController::singleton_ot_estados();
    
    echo $controlador->updateOtEstado(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteOtEstado() {
    $controlador = OtEstadosController::singleton_ot_estados();
    
    echo $controlador->deleteOtEstado($_POST['codigo']);
}

function getOtEstado() {
    $controlador = OtEstadosController::singleton_ot_estados();
    
    echo $controlador->getOtEstado($_POST['codigo']);
}

class OtEstadosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/ot_estados.model.php";
            $this->conn = OtEstadosModel::singleton_ot_estados();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_ot_estados() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountOtEstados(){
        return intval($this->conn->getCountOtEstados()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/ot_estados.busqueda.template.php";
        
    }
    
    public function addOtEstado($descripcion) {
        $devuelve = $this->conn->addOtEstado($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateOtEstado($codigo, $descripcion) {
        $devuelve = $this->conn->updateOtEstado($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteOtEstado($codigo) {
        $devuelve = $this->conn->deleteOtEstado($codigo);
        
        return $devuelve;
        
    }
    
    public function getOtEstado($codigo) {
        $devuelve = $this->conn->getOtEstado($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
