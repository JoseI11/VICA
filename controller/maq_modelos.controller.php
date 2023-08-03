<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = MaqModelosController::singleton_maq_modelos();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addMaqModelo() {
    $controlador = MaqModelosController::singleton_maq_modelos();
    
    echo $controlador->addMaqModelo  (    
                                        $_POST['descripcion']
            );
}

function updateMaqModelo() {
    $controlador = MaqModelosController::singleton_maq_modelos();
    
    echo $controlador->updateMaqModelo(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteMaqModelo() {
    $controlador = MaqModelosController::singleton_maq_modelos();
    
    echo $controlador->deleteMaqModelo($_POST['codigo']);
}

function getMaqModelo() {
    $controlador = MaqModelosController::singleton_maq_modelos();
    
    echo $controlador->getMaqModelo($_POST['codigo']);
}

class MaqModelosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/maq_modelos.model.php";
            $this->conn = MaqModelosModel::singleton_maq_modelos();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_maq_modelos() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountMaqModelos(){
        return intval($this->conn->getCountMaqModelos()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/maq_modelos.busqueda.template.php";
        
    }
    
    public function addMaqModelo($descripcion) {
        $devuelve = $this->conn->addMaqModelo($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateMaqModelo($codigo, $descripcion) {
        $devuelve = $this->conn->updateMaqModelo($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteMaqModelo($codigo) {
        $devuelve = $this->conn->deleteMaqModelo($codigo);
        
        return $devuelve;
        
    }
    
    public function getMaqModelo($codigo) {
        $devuelve = $this->conn->getMaqModelo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
