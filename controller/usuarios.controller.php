<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = UsuariosController::singleton_usuarios();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function addUsuario() {
    $controlador = UsuariosController::singleton_usuarios();
    
    echo $controlador->addUsuario  (    $_POST['usuario'], 
                                        $_POST['password'],
                                        $_POST['nombre'],
                                        $_POST['mail'],
                                        $_POST['rol']

            );
}

function updateUsuario() {
    $controlador = UsuariosController::singleton_usuarios();
    
    echo $controlador->updateUsuario(   $_POST['codigo'], 
                                        $_POST['usuario'],
                                        $_POST['password'],
                                        $_POST['nombre'],
                                        $_POST['mail'],
                                        $_POST['rol']
            );
}

function deleteUsuario() {
    $controlador = UsuariosController::singleton_usuarios();
    
    echo $controlador->deleteUsuario($_POST['codigo']);
}

function getUsuario() {
    $controlador = UsuariosController::singleton_usuarios();
    
    echo $controlador->getUsuario($_POST['codigo']);
}

class UsuariosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/usuarios.model.php";
            $this->conn = UsuariosModel::singleton_usuarios();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_usuarios() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountUsuarios(){
        return intval($this->conn->getCountUsuarios()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/usuarios.busqueda.template.php";
        
    }
    
    public function addUsuario($usuario, $password, $nombre, $mail, $rol) {
        $devuelve = $this->conn->addUsuario($usuario, md5($password), $nombre, $mail, $rol);
        
        return $devuelve;
        
    }
    
    public function updateUsuario($codigo, $usuario, $password, $nombre, $mail, $rol) {
        $devuelve = $this->conn->updateUsuario($codigo, $usuario, md5($password), $nombre, $mail, $rol);
        
        return $devuelve;
        
    }
    
    public function deleteUsuario($codigo) {
        $devuelve = $this->conn->deleteUsuario($codigo);
        
        return $devuelve;
        
    }
    
    public function getUsuario($codigo) {
        $devuelve = $this->conn->getUsuario($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getRoles() {
        $devuelve = $this->conn->getRoles();
        
        return $devuelve;
        
    }
    
}
