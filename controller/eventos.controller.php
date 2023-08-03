<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = EventosController::singleton_eventos();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addEvento() {
    $controlador = EventosController::singleton_eventos();
    
    echo $controlador->addEvento  (    
                                        $_POST['descripcion']
            );
}

function updateEvento() {
    $controlador = EventosController::singleton_eventos();
    
    echo $controlador->updateEvento(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteEvento() {
    $controlador = EventosController::singleton_eventos();
    
    echo $controlador->deleteEvento($_POST['codigo']);
}

function getEvento() {
    $controlador = EventosController::singleton_eventos();
    
    echo $controlador->getEvento($_POST['codigo']);
}

class EventosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/eventos.model.php";
            $this->conn = EventosModel::singleton_eventos();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_eventos() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountEventos(){
        return intval($this->conn->getCountEventos()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/eventos.busqueda.template.php";
        
    }
    
    public function addEvento($descripcion) {
        $devuelve = $this->conn->addEvento($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateEvento($codigo, $descripcion) {
        $devuelve = $this->conn->updateEvento($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteEvento($codigo) {
        $devuelve = $this->conn->deleteEvento($codigo);
        
        return $devuelve;
        
    }
    
    public function getEvento($codigo) {
        $devuelve = $this->conn->getEvento($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
