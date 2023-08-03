<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = AjustesMotivosController::singleton_ajustes_motivos();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addAjustesMotivo() {
    $controlador = AjustesMotivosController::singleton_ajustes_motivos();
    
    echo $controlador->addAjustesMotivo  (    
                                        $_POST['descripcion'],
                                        $_POST['impacto']
            );
}

function updateAjustesMotivo() {
    $controlador = AjustesMotivosController::singleton_ajustes_motivos();
    
    echo $controlador->updateAjustesMotivo(    $_POST['codigo'], 
                                        $_POST['descripcion'],
                                        $_POST['impacto']
            );
}

function deleteAjustesMotivo() {
    $controlador = AjustesMotivosController::singleton_ajustes_motivos();
    
    echo $controlador->deleteAjustesMotivo($_POST['codigo']);
}

function getAjustesMotivo() {
    $controlador = AjustesMotivosController::singleton_ajustes_motivos();
    
    echo $controlador->getAjustesMotivo($_POST['codigo']);
}

class AjustesMotivosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/ajustes_motivos.model.php";
            $this->conn = AjustesMotivosModel::singleton_ajustes_motivos();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_ajustes_motivos() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountAjustesMotivos(){
        return intval($this->conn->getCountAjustesMotivos()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/ajustes_motivos.busqueda.template.php";
        
    }
    
    public function addAjustesMotivo($descripcion, $impacto) {
        $devuelve = $this->conn->addAjustesMotivo($descripcion, $impacto);
        
        return $devuelve;
        
    }
    
    public function updateAjustesMotivo($codigo, $descripcion, $impacto) {
        $devuelve = $this->conn->updateAjustesMotivo($codigo, $descripcion, $impacto);
        
        return $devuelve;
        
    }
    
    public function deleteAjustesMotivo($codigo) {
        $devuelve = $this->conn->deleteAjustesMotivo($codigo);
        
        return $devuelve;
        
    }
    
    public function getAjustesMotivo($codigo) {
        $devuelve = $this->conn->getAjustesMotivo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
