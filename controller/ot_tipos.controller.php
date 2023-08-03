<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = OtTiposController::singleton_ot_tipos();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addOtTipo() {
    $controlador = OtTiposController::singleton_ot_tipos();
    
    echo $controlador->addOtTipo  (    
                                        $_POST['descripcion']
            );
}

function updateOtTipo() {
    $controlador = OtTiposController::singleton_ot_tipos();
    
    echo $controlador->updateOtTipo(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteOtTipo() {
    $controlador = OtTiposController::singleton_ot_tipos();
    
    echo $controlador->deleteOtTipo($_POST['codigo']);
}

function getOtTipo() {
    $controlador = OtTiposController::singleton_ot_tipos();
    
    echo $controlador->getOtTipo($_POST['codigo']);
}

class OtTiposController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/ot_tipos.model.php";
            $this->conn = OtTiposModel::singleton_ot_tipos();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_ot_tipos() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountOtTipos(){
        return intval($this->conn->getCountOtTipos()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/ot_tipos.busqueda.template.php";
        
    }
    
    public function addOtTipo($descripcion) {
        $devuelve = $this->conn->addOtTipo($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateOtTipo($codigo, $descripcion) {
        $devuelve = $this->conn->updateOtTipo($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteOtTipo($codigo) {
        $devuelve = $this->conn->deleteOtTipo($codigo);
        
        return $devuelve;
        
    }
    
    public function getOtTipo($codigo) {
        $devuelve = $this->conn->getOtTipo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
