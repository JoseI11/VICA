<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = UnidadesController::singleton_unidades();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addUnidad() {
    $controlador = UnidadesController::singleton_unidades();
    
    echo $controlador->addUnidad  (    
                                        $_POST['descripcion'],
                                        $_POST['abreviatura']
            );
}

function updateUnidad() {
    $controlador = UnidadesController::singleton_unidades();
    
    echo $controlador->updateUnidad(    $_POST['codigo'], 
                                        $_POST['descripcion'],
                                        $_POST['abreviatura']
            );
}

function deleteUnidad() {
    $controlador = UnidadesController::singleton_unidades();
    
    echo $controlador->deleteUnidad($_POST['codigo']);
}

function getUnidad() {
    $controlador = UnidadesController::singleton_unidades();
    
    echo $controlador->getUnidad($_POST['codigo']);
}

class UnidadesController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/unidades.model.php";
            $this->conn = UnidadesModel::singleton_unidades();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_unidades() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountUnidades(){
        return intval($this->conn->getCountUnidades()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/unidades.busqueda.template.php";
        
    }
    
    public function addUnidad($descripcion, $abreviatura) {
        $devuelve = $this->conn->addUnidad($descripcion, $abreviatura);
        
        return $devuelve;
        
    }
    
    public function updateUnidad($codigo, $descripcion, $abreviatura) {
        $devuelve = $this->conn->updateUnidad($codigo, $descripcion, $abreviatura);
        
        return $devuelve;
        
    }
    
    public function deleteUnidad($codigo) {
        $devuelve = $this->conn->deleteUnidad($codigo);
        
        return $devuelve;
        
    }
    
    public function getUnidad($codigo) {
        $devuelve = $this->conn->getUnidad($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
