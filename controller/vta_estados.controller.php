<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = VtaEstadosController::singleton_vta_estados();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addVtaEstado() {
    $controlador = VtaEstadosController::singleton_vta_estados();
    
    echo $controlador->addVtaEstado  (    
                                        $_POST['descripcion'],
                                        $_POST['general'],
                                        $_POST['entrega'],
                                        $_POST['cobranza']
            );
}

function updateVtaEstado() {
    $controlador = VtaEstadosController::singleton_vta_estados();
    
    echo $controlador->updateVtaEstado(    $_POST['codigo'], 
                                        $_POST['descripcion'],
                                        $_POST['general'],
                                        $_POST['entrega'],
                                        $_POST['cobranza']
            );
}

function deleteVtaEstado() {
    $controlador = VtaEstadosController::singleton_vta_estados();
    
    echo $controlador->deleteVtaEstado($_POST['codigo']);
}

function getVtaEstado() {
    $controlador = VtaEstadosController::singleton_vta_estados();
    
    echo $controlador->getVtaEstado($_POST['codigo']);
}

class VtaEstadosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/vta_estados.model.php";
            $this->conn = VtaEstadosModel::singleton_vta_estados();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_vta_estados() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountVtaEstados(){
        return intval($this->conn->getCountVtaEstados()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/vta_estados.busqueda.template.php";
        
    }
    
    public function addVtaEstado($descripcion, $general, $entrega, $cobranza) {
        $devuelve = $this->conn->addVtaEstado($descripcion, $general, $entrega, $cobranza);
        
        return $devuelve;
        
    }
    
    public function updateVtaEstado($codigo, $descripcion, $general, $entrega, $cobranza) {
        $devuelve = $this->conn->updateVtaEstado($codigo, $descripcion, $general, $entrega, $cobranza);
        
        return $devuelve;
        
    }
    
    public function deleteVtaEstado($codigo) {
        $devuelve = $this->conn->deleteVtaEstado($codigo);
        
        return $devuelve;
        
    }
    
    public function getVtaEstado($codigo) {
        $devuelve = $this->conn->getVtaEstado($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
