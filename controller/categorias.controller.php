<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = CategoriasController::singleton_categorias();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addCategoria() {
    $controlador = CategoriasController::singleton_categorias();
    
    echo $controlador->addCategoria  (    
                                        $_POST['descripcion']
            );
}

function updateCategoria() {
    $controlador = CategoriasController::singleton_categorias();
    
    echo $controlador->updateCategoria(    $_POST['codigo'], 
                                        $_POST['descripcion']
            );
}

function deleteCategoria() {
    $controlador = CategoriasController::singleton_categorias();
    
    echo $controlador->deleteCategoria($_POST['codigo']);
}

function getCategoria() {
    $controlador = CategoriasController::singleton_categorias();
    
    echo $controlador->getCategoria($_POST['codigo']);
}

class CategoriasController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/categorias.model.php";
            $this->conn = CategoriasModel::singleton_categorias();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_categorias() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountCategorias(){
        return intval($this->conn->getCountCategorias()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/categorias.busqueda.template.php";
        
    }
    
    public function addCategoria($descripcion) {
        $devuelve = $this->conn->addCategoria($descripcion);
        
        return $devuelve;
        
    }
    
    public function updateCategoria($codigo, $descripcion) {
        $devuelve = $this->conn->updateCategoria($codigo, $descripcion);
        
        return $devuelve;
        
    }
    
    public function deleteCategoria($codigo) {
        $devuelve = $this->conn->deleteCategoria($codigo);
        
        return $devuelve;
        
    }
    
    public function getCategoria($codigo) {
        $devuelve = $this->conn->getCategoria($codigo);
        
        return json_encode($devuelve[0]);
        
    }
}
