<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function getRegistrosFiltroSingle(){
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->getRegistrosFiltroSingle($_POST['codigo']);
}

function getRegistrosFiltroAsociados(){
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->getRegistrosFiltroAsociados($_POST['codigo']);
}

function editMaquina() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->editMaquina  (    
                                        $_POST['codigo'],
                                        $_POST['data']
            );
}

function addMaquina() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->addMaquina  (    
                                        $_POST['descrip'],
                                        $_POST['descripcion'],
                                        $_POST['observaciones'],
                                        $_POST['modelo'],
                                        $_POST["preciounitario"],
                                        $_POST["costounitario"],
                                        $_POST["tipodeuso"]
            );
}

function addMaquinaComponente() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->addMaquinaComponente  (    
                                        $_POST['maquina'],
                                        $_POST['componente'],
                                        $_POST['cantidad']
            );
}

function updateMaquina() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->updateMaquina(   $_POST['codigo'], 
                                        $_POST['descrip'],
                                        $_POST['descripcion'],
                                        $_POST['observaciones'],
                                        $_POST['modelo'],
                                        $_POST["preciounitario"],
                                        $_POST["costounitario"],
                                        $_POST["tipodeuso"]
            );
}

function updateMaquinaComponente() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->updateMaquinaComponente(    $_POST['codigo'], 
                                        $_POST['maquina'],
                                        $_POST['componente'],
                                        $_POST['cantidad']
            );
}

function deleteMaquina() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->deleteMaquina($_POST['codigo']);
}

function deleteMaquinaComponente() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->deleteMaquinaComponente($_POST['codigo']);
}

function getMaquina() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->getMaquina($_POST['codigo']);
}

function getMaquinaComponente() {
    $controlador = MaquinasController::singleton_maquinas();
    
    echo $controlador->getMaquinaComponente($_POST['codigo']);
}

class MaquinasController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/maquinas.model.php";
            $this->conn = MaquinasModel::singleton_maquinas();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_maquinas() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountMaquinas(){
        return intval($this->conn->getCountMaquinas()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/maquinas.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroSingle($codigo){
        
        $maquina = $this->conn->getMaquina($codigo)[0];

        $unidades = $this->getUnidades();

        $categorias = $this->getMaquinasCategorias();

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/maquina.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroAsociados($codigo){
        
        $registros = $this->conn->getComponentesAsociados($codigo); 

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/maquina.componentes.template.php";
        
    }
    
    public function addMaquina($descrip_abrev, $descripcion, $observaciones, $modelo,$preciounitario,$costounitario,$tipodeuso) {
        $devuelve = $this->conn->addMaquina($descrip_abrev, $descripcion, $observaciones, $modelo,$preciounitario,$costounitario,$tipodeuso);
        
        return $devuelve;
        
    }
    
    public function addMaquinaComponente($maquina, $componente, $cantidad) {
        $devuelve = $this->conn->addMaquinaComponente($maquina, $componente, $cantidad);
        
        return $devuelve;
        
    }
    
    public function editMaquina($codigo, $data) {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editMaquina($codigo, $datos);
        
        return $devuelve;
        
    }
    
    public function updateMaquina($codigo, $descrip_abrev, $descripcion, $observaciones, $modelo,$preciounitario,$costounitario,$tipodeuso) {
        $devuelve = $this->conn->updateMaquina($codigo, $descrip_abrev, $descripcion, $observaciones, $modelo,$preciounitario,$costounitario,$tipodeuso);
        
        return $devuelve;
        
    }
    
    public function updateMaquinaComponente($codigo, $maquina, $componente, $cantidad) {
        $devuelve = $this->conn->updateMaquinaComponente($codigo, $maquina, $componente, $cantidad);
        
        return $devuelve;
        
    }
    
    public function deleteMaquina($codigo) {
        $devuelve = $this->conn->deleteMaquina($codigo);
        
        return $devuelve;
        
    }
    
    public function deleteMaquinaComponente($codigo) {
        $devuelve = $this->conn->deleteMaquinaComponente($codigo);
        
        return $devuelve;
        
    }
    
    public function getMaquina($codigo) {
        $devuelve = $this->conn->getMaquina($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getMaquinaComponente($codigo) {
        $devuelve = $this->conn->getMaquinaComponente($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getUnidades() {
        $devuelve = $this->conn->getUnidades();
        
        return $devuelve;
        
    }
    
    public function getMaquinasCategorias() {
        $devuelve = $this->conn->getMaquinasCategorias();
        
        return $devuelve;
        
    }
    
    public function getComponentes() {
        $devuelve = $this->conn->getComponentes();
        
        return $devuelve;
        
    }
}
