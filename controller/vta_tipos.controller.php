<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = VtaTiposController::singleton_vta_tipos();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addVtaTipo() {
    $controlador = VtaTiposController::singleton_vta_tipos();
    
    echo $controlador->addVtaTipo  (    
                                        $_POST['descripcion']
            );
}

function updateVtaTipo() {
    $controlador = VtaTiposController::singleton_vta_tipos();
    
    echo $controlador->updateVtaTipo(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteVtaTipo() {
    $controlador = VtaTiposController::singleton_vta_tipos();
    
    echo $controlador->deleteVtaTipo($_POST['codigo']);
}

function getVtaTipo() {
    $controlador = VtaTiposController::singleton_vta_tipos();
    
    echo $controlador->getVtaTipo($_POST['codigo']);
}

class VtaTiposController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/vta_tipos.model.php";
            $this->conn = VtaTiposModel::singleton_vta_tipos();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_vta_tipos() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountVtaTipos(){
        return intval($this->conn->getCountVtaTipos()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/vta_tipos.busqueda.template.php";
        
    }
    
    public function addVtaTipo($descripcion) {
        $devuelve = $this->conn->addVtaTipo($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateVtaTipo($codigo, $descripcion) {
        $devuelve = $this->conn->updateVtaTipo($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteVtaTipo($codigo) {
        $devuelve = $this->conn->deleteVtaTipo($codigo);
        
        return $devuelve;
        
    }
    
    public function getVtaTipo($codigo) {
        $devuelve = $this->conn->getVtaTipo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
