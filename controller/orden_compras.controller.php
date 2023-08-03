<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function getRegistrosFiltroSingle(){
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->getRegistrosFiltroSingle($_POST['codigo']);
}

function getRegistrosFiltroSingleRecepcion(){
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->getRegistrosFiltroSingleRecepcion(
        $_POST['codigo'],
        $_POST['ver']
    );
}

function getRegistrosFiltroAsociados(){
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->getRegistrosFiltroAsociados($_POST['codigo']);
}

function getRegistrosFiltroAsociadosRecepcion(){
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->getRegistrosFiltroAsociadosRecepcion($_POST['codigo']);
}

function editOrdenCompra() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->editOrdenCompra  (    
                                        $_POST['codigo'],
                                        $_POST['data']
            );
}

function editOrdenCompraRec() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->editOrdenCompraRec  (    
                                        $_POST['codigo'],
                                        $_POST['data']
            );
}

function cambiarEstadoOrdenCompra() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->cambiarEstadoOrdenCompra  (    
                                        $_POST['codigo'],
                                        $_POST['estado']
            );
}

function addOrdenCompra() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->addOrdenCompra  (    
                                        $_POST['fecha'],
                                        $_POST['proveedor'],
                                        $_POST['observaciones']
            );
}

function addOrdenCompraInsumo() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->addOrdenCompraInsumo  (    
                                        $_POST['orden_compra'],
                                        $_POST['insumo'],
                                        $_POST['cantidad'],
                                        $_POST['precio']
            );
}

function updateOrdenCompra() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->updateOrdenCompra(    $_POST['codigo'], 
                                        $_POST['descripcion'],
                                        $_POST['insumo'],
                                        $_POST['unidad']
            );
}

function updateOrdenCompraInsumo() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->updateOrdenCompraInsumo(    $_POST['codigo'], 
                                        $_POST['orden_compra'],
                                        $_POST['insumo'],
                                        $_POST['cantidad'],
                                        $_POST['precio']
            );
}

function updateOrdenCompraInsumoRec() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->updateOrdenCompraInsumoRec(    $_POST['codigo'], 
                                        $_POST['orden_compra'],
                                        $_POST['recibido']
            );
}

function deleteOrdenCompra() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->deleteOrdenCompra($_POST['codigo']);
}

function deleteOrdenCompraInsumo() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->deleteOrdenCompraInsumo($_POST['codigo']);
}

function getOrdenCompra() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->getOrdenCompra($_POST['codigo']);
}

function getOrdenCompraInsumo() {
    $controlador = OrdenComprasController::singleton_orden_compras();
    
    echo $controlador->getOrdenCompraInsumo($_POST['codigo']);
}

class OrdenComprasController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/orden_compras.model.php";
            $this->conn = OrdenComprasModel::singleton_orden_compras();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_orden_compras() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountOrdenCompras(){
        return intval($this->conn->getCountOrdenCompras()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_compras.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroSingle($codigo){
        
        $orden_compra = $this->conn->getOrdenCompra($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_compra.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroSingleRecepcion($codigo, $ver){
        
        $orden_compra = $this->conn->getOrdenCompra($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_compra.recepcion.template.php";
        
    }
    
    public function getRegistrosFiltroAsociados($codigo){
        
        $registros = $this->conn->getDetallesAsociados($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_compra.insumos.template.php";
        
    }
    
    public function getRegistrosFiltroAsociadosRecepcion($codigo){
        
        $registros = $this->conn->getDetallesAsociados($codigo);

        $oc = $this->conn->getOrdenCompra($codigo)[0];

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_compra.insumos.rec.template.php";
        
    }
    
    public function addOrdenCompra($fecha, $proveedor, $observaciones) {
        $devuelve = $this->conn->addOrdenCompra($fecha, $proveedor, $observaciones);
        
        return $devuelve;
        
    }
    
    public function addOrdenCompraInsumo($orden_compra, $insumo, $cantidad, $precio) {
        $devuelve = $this->conn->addOrdenCompraInsumo($orden_compra, $insumo, $cantidad, $precio);
        
        return $devuelve;
        
    }
    
    public function cambiarEstadoOrdenCompra($codigo, $estado) {
        $devuelve = $this->conn->cambiarEstadoOrdenCompra($codigo, $estado);
        
        return $devuelve;
        
    }
    
    public function editOrdenCompra($codigo, $data) {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editOrdenCompra($codigo, $datos);
        
        return $devuelve;
        
    }
    
    public function editOrdenCompraRec($codigo, $data) {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editOrdenCompraRec($codigo, $datos);
        
        return $devuelve;
        
    }
    
    public function updateOrdenCompra($codigo, $descripcion, $insumo, $unidad) {
        $devuelve = $this->conn->updateOrdenCompra($codigo, $descripcion, $insumo, $unidad);
        
        return $devuelve;
        
    }
    
    public function updateOrdenCompraInsumo($codigo, $orden_compra, $insumo, $cantidad, $precio) {
        $devuelve = $this->conn->updateOrdenCompraInsumo($codigo, $orden_compra, $insumo, $cantidad, $precio);
        
        return $devuelve;
        
    }
    
    public function updateOrdenCompraInsumoRec($codigo, $orden_compra, $recibido) {
        $devuelve = $this->conn->updateOrdenCompraInsumoRec($codigo, $orden_compra, $recibido);
        
        return $devuelve;
        
    }
    
    public function deleteOrdenCompra($codigo) {
        $devuelve = $this->conn->deleteOrdenCompra($codigo);
        
        return $devuelve;
        
    }
    
    public function deleteOrdenCompraInsumo($codigo) {
        $devuelve = $this->conn->deleteOrdenCompraInsumo($codigo);
        
        return $devuelve;
        
    }
    
    public function getOrdenCompra($codigo) {
        $devuelve = $this->conn->getOrdenCompra($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getOrdenCompraArray($codigo) {
        $devuelve = $this->conn->getOrdenCompra($codigo);
        
        return $devuelve;
        
    }
    
    public function getDetallesAsociados($codigo) {
        $devuelve = $this->conn->getDetallesAsociados($codigo);
        
        return $devuelve;
        
    }
    
    public function getOrdenCompraInsumo($codigo) {
        $devuelve = $this->conn->getOrdenCompraInsumo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getUnidades() {
        $devuelve = $this->conn->getUnidades();
        
        return $devuelve;
        
    }
    
    public function getProveedores() {
        $devuelve = $this->conn->getProveedores();
        
        return $devuelve;
        
    }
    
    public function getOrdenComprasCategorias() {
        $devuelve = $this->conn->getOrdenComprasCategorias();
        
        return $devuelve;
        
    }
    
    public function getInsumos() {
        $devuelve = $this->conn->getInsumos();
        
        return $devuelve;
        
    }
}
