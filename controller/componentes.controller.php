<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function getRegistrosFiltroSingle(){
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->getRegistrosFiltroSingle($_POST['codigo']);
}

function getRegistrosFiltroAsociados(){
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->getRegistrosFiltroAsociados($_POST['codigo']);
}

function editComponente() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->editComponente  (    
                                        $_POST['codigo'],
                                        $_POST['data']
            );
}

function addComponente() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->addComponente  (    
                                        $_POST['descripcion'],
                                        $_POST['insumo'],
                                        $_POST['usado'],
                                        $_POST['codigo_mp'],
                                        $_POST['unidad'],
                                        $_POST['dimension'],
                                        $_POST['categoria'],
                                        $_POST['costo'],
                                        $_POST['precio'],
                                        $_POST['stock_min'],
                                        $_POST['stock_max'],
                                        $_POST['iva'],
                                        $_POST['espesor'],
                                        $_POST['largo'],
                                        $_POST['largo_total'],
                                        $_POST['peso'],
                                        $_POST['peso_total']
            );
}

function addComponenteInsumo() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->addComponenteInsumo  (    
                                        $_POST['componente'],
                                        $_POST['insumo'],
                                        $_POST['cantidad']
            );
}

function updateComponente() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->updateComponente(    $_POST['codigo'], 
                                        $_POST['descripcion'],
                                        $_POST['insumo'],
                                        $_POST['usado'],
                                        $_POST['unidad']
            );
}

function updateComponenteInsumo() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->updateComponenteInsumo(    $_POST['codigo'], 
                                        $_POST['componente'],
                                        $_POST['insumo'],
                                        $_POST['cantidad']
            );
}

function deleteComponente() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->deleteComponente($_POST['codigo']);
}

function deleteComponenteInsumo() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->deleteComponenteInsumo($_POST['codigo']);
}

function getComponente() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->getComponente($_POST['codigo']);
}

function getComponenteInsumo() {
    $controlador = ComponentesController::singleton_componentes();
    
    echo $controlador->getComponenteInsumo($_POST['codigo']);
}

class ComponentesController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/componentes.model.php";
            $this->conn = ComponentesModel::singleton_componentes();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_componentes() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountComponentes(){
        return intval($this->conn->getCountComponentes()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/componentes.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroSingle($codigo){
        
        $componente = $this->conn->getComponente($codigo)[0];

        $unidades = $this->getUnidades();

        $categorias = $this->getComponentesCategorias();

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/componente.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroAsociados($codigo){
        
        $registros = $this->conn->getInsumosAsociados($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/componente.insumos.template.php";
        
    }
    
    public function addComponente($descripcion, $insumo, $usado, $codigo_mp, $unidad, $dimension, $categoria, $costo, $precio, $stock_min, $stock_max, $iva, $espesor, $largo, $largo_total, $peso, $peso_total) {
        $devuelve = $this->conn->addComponente($descripcion, $insumo, $usado, $codigo_mp, $unidad, $dimension, $categoria, $costo, $precio, $stock_min, $stock_max, $iva, $espesor, $largo, $largo_total, $peso, $peso_total);
        
        return $devuelve;
        
    }
    
    public function addComponenteInsumo($componente, $insumo, $cantidad) {
        $devuelve = $this->conn->addComponenteInsumo($componente, $insumo, $cantidad);
        
        return $devuelve;
        
    }
    
    public function editComponente($codigo, $data) {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editComponente($codigo, $datos);
        
        return $devuelve;
        
    }
    
    public function updateComponente($codigo, $descripcion, $insumo, $usado, $unidad) {
        $devuelve = $this->conn->updateComponente($codigo, $descripcion, $insumo, $usado, $unidad);
        
        return $devuelve;
        
    }
    
    public function updateComponenteInsumo($codigo, $componente, $insumo, $cantidad) {
        $devuelve = $this->conn->updateComponenteInsumo($codigo, $componente, $insumo, $cantidad);
        
        return $devuelve;
        
    }
    
    public function deleteComponente($codigo) {
        $devuelve = $this->conn->deleteComponente($codigo);
        
        return $devuelve;
        
    }
    
    public function deleteComponenteInsumo($codigo) {
        $devuelve = $this->conn->deleteComponenteInsumo($codigo);
        
        return $devuelve;
        
    }
    
    public function getComponente($codigo) {
        $devuelve = $this->conn->getComponente($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getComponenteArray($codigo) {
        $devuelve = $this->conn->getComponente($codigo);
        
        return $devuelve[0];
        
    }
    
    public function getComponenteInsumo($codigo) {
        $devuelve = $this->conn->getComponenteInsumo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getUnidades() {
        $devuelve = $this->conn->getUnidades();
        
        return $devuelve;
        
    }
    
    public function getComponentesCategorias() {
        $devuelve = $this->conn->getComponentesCategorias();
        
        return $devuelve;
        
    }
    
    public function getInsumos() {
        $devuelve = $this->conn->getInsumos();
        
        return $devuelve;
        
    }
}
