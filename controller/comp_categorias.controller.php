<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = CompCategoriasController::singleton_comp_categorias();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addCompCategoria() {
    $controlador = CompCategoriasController::singleton_comp_categorias();
    
    echo $controlador->addCompCategoria  (    
                                        $_POST['descripcion']
            );
}

function updateCompCategoria() {
    $controlador = CompCategoriasController::singleton_comp_categorias();
    
    echo $controlador->updateCompCategoria(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteCompCategoria() {
    $controlador = CompCategoriasController::singleton_comp_categorias();
    
    echo $controlador->deleteCompCategoria($_POST['codigo']);
}

function getCompCategoria() {
    $controlador = CompCategoriasController::singleton_comp_categorias();
    
    echo $controlador->getCompCategoria($_POST['codigo']);
}

class CompCategoriasController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/comp_categorias.model.php";
            $this->conn = CompCategoriasModel::singleton_comp_categorias();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_comp_categorias() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountCompCategorias(){
        return intval($this->conn->getCountCompCategorias()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/comp_categorias.busqueda.template.php";
        
    }
    
    public function addCompCategoria($descripcion) {
        $devuelve = $this->conn->addCompCategoria($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateCompCategoria($codigo, $descripcion) {
        $devuelve = $this->conn->updateCompCategoria($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteCompCategoria($codigo) {
        $devuelve = $this->conn->deleteCompCategoria($codigo);
        
        return $devuelve;
        
    }
    
    public function getCompCategoria($codigo) {
        $devuelve = $this->conn->getCompCategoria($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
