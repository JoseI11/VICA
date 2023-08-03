<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = PersonasController::singleton_personas();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addPersona() {
    $controlador = PersonasController::singleton_personas();
    
    echo $controlador->addPersona  (    
                                        $_POST['descripcion'],
                                        $_POST['telefono'],
                                        $_POST['localidad'],
                                        $_POST['cuit'],
                                        $_POST['mail'],
                                        $_POST['pais'],
                                        $_POST['provincia'],
                                        $_POST['cliente'],
                                        $_POST['proveedor'],
                                        $_POST['transportista'],
                                        $_POST['vendedor'],
                                        $_POST['empleado']
            );
}

function updatePersona() {
    $controlador = PersonasController::singleton_personas();
    
    echo $controlador->updatePersona(    $_POST['codigo'], 
                                            $_POST['descripcion'],
                                            $_POST['telefono'],
                                            $_POST['localidad'],
                                            $_POST['cuit'],
                                            $_POST['mail'],
                                            $_POST['pais'],
                                            $_POST['provincia'],
                                            $_POST['cliente'],
                                            $_POST['proveedor'],
                                            $_POST['transportista'],
                                            $_POST['vendedor'],
                                            $_POST['empleado']
            );
}

function deletePersona() {
    $controlador = PersonasController::singleton_personas();
    
    echo $controlador->deletePersona($_POST['codigo']);
}

function getPersona() {
    $controlador = PersonasController::singleton_personas();
    
    echo $controlador->getPersona($_POST['codigo']);
}

class PersonasController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/personas.model.php";
            $this->conn = PersonasModel::singleton_personas();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_personas() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountPersonas(){
        return intval($this->conn->getCountPersonas()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/personas.busqueda.template.php";
        
    }
    
    public function addPersona($descripcion, $telefono, $localidad, $cuit, $mail, $pais, $provincia, $cliente, $proveedor, $transportista, $vendedor, $empleado) {
        $devuelve = $this->conn->addPersona($descripcion, $telefono, $localidad, $cuit, $mail, $pais, $provincia, $cliente, $proveedor, $transportista, $vendedor, $empleado);
        
        return $devuelve;
        
    }
    
    public function updatePersona($codigo, $descripcion, $telefono, $localidad, $cuit, $mail, $pais, $provincia, $cliente, $proveedor, $transportista, $vendedor, $empleado) {
        $devuelve = $this->conn->updatePersona($codigo, $descripcion, $telefono, $localidad, $cuit, $mail, $pais, $provincia, $cliente, $proveedor, $transportista, $vendedor, $empleado);
        
        return $devuelve;
        
    }
    
    public function deletePersona($codigo) {
        $devuelve = $this->conn->deletePersona($codigo);
        
        return $devuelve;
        
    }
    
    public function getPersona($codigo) {
        $devuelve = $this->conn->getPersona($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getProvincias() {
        $devuelve = $this->conn->getProvincias();
        
        return $devuelve;
        
    }
    
    public function getPaises() {
        $devuelve = $this->conn->getPaises();
        
        return $devuelve;
        
    }
}
