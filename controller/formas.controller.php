<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = FormasController::singleton_formas();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addForma() {
    $controlador = FormasController::singleton_formas();
    
    echo $controlador->addForma  (    
                                        $_POST['descripcion']
            );
}

function updateForma() {
    $controlador = FormasController::singleton_formas();
    
    echo $controlador->updateForma(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteForma() {
    $controlador = FormasController::singleton_formas();
    
    echo $controlador->deleteForma($_POST['codigo']);
}

function getForma() {
    $controlador = FormasController::singleton_formas();
    
    echo $controlador->getForma($_POST['codigo']);
}

class FormasController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/formas.model.php";
            $this->conn = FormasModel::singleton_formas();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_formas() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountFormas(){
        return intval($this->conn->getCountFormas()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/formas.busqueda.template.php";
        
    }
    
    public function addForma($descripcion) {
        $devuelve = $this->conn->addForma($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateForma($codigo, $descripcion) {
        $devuelve = $this->conn->updateForma($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteForma($codigo) {
        $devuelve = $this->conn->deleteForma($codigo);
        
        return $devuelve;
        
    }
    
    public function getForma($codigo) {
        $devuelve = $this->conn->getForma($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
