<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = AjustesController::singleton_ajustes();    
    echo $controlador->getRegistrosFiltro($_POST['empresa'], $_POST['desde'], $_POST['hasta'], $_POST['valor'],$_POST['tipo']);
}

function afectarPrecios(){
    $controlador = AjustesController::singleton_ajustes();    
    echo $controlador->afectarPrecios($_POST['selected'], $_POST['factor'], $_POST['valor'], $_POST['tipo']);
}
function filtrar_tipos_de_stock(){
    $controlador= AjustesController::singleton_ajustes();
    echo $controlador->filtrar_tipos_de_stock($_POST['tipo']);
}
class AjustesController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/ajustes.model.php";
            $this->conn = AjustesModel::singleton_ajustes();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_ajustes() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function afectarPrecios($seleccionados, $factor, $valor, $tipo){   
        return $this->conn->afectarPrecios($seleccionados, $factor, $valor, $tipo);
    } 
    public function filtrar_tipos_de_stock($tipo)
    {
        return $this->conn->filtrar_tipos_de_stock($tipo);
    }
    public function getRegistrosFiltro($empresa, $desde, $hasta, $valor,$tipo=1){        
        $_SESSION["select_empresa"] = $empresa;        
        $_SESSION["desde"]          = $desde;        
        $_SESSION["hasta"]          = $hasta;          
        $insumos                    = $this->getInsumos($tipo);
        $devuelve                   = $insumos;        
        $registros                  = $devuelve;        
        $_SESSION['registros']      = $registros;
        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/ajustes.busqueda.template.php";        
    }
    
    public function getEmpresas() {
        return $this->conn->getEmpresas();
    }
    
    public function getInsumos($tipo){
        return $this->conn->getInsumos($tipo);
    }
}
