<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function getRegistrosFiltroSingle(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroSingle($_POST['codigo'], $_POST["ver"]);
}

function getRegistrosFiltroTareas(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroTareas($_POST['codigo'], $_POST["ver"]);
}

function getRegistrosFiltroPersonas(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroPersonas($_POST['codigo'], $_POST["ver"]);
}

function getRegistrosFiltroSingleRecepcion(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroSingleRecepcion(
        $_POST['codigo'],
        $_POST['ver']
    );
}

function getRegistrosFiltroAsociados(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroAsociados($_POST['codigo']);
}

function getRegistrosFiltroAsociados2(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroAsociados2($_POST['codigo']);
}

function getRegistrosFiltroAsociados3(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroAsociados3($_POST['codigo']);
}

function getRegistrosFiltroAsociados4(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroAsociados4($_POST['codigo']);
}


function getRegistrosFiltroAsociadosRecepcion(){
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getRegistrosFiltroAsociadosRecepcion($_POST['codigo']);
}

function editOrdenTrabajo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->editOrdenTrabajo  (    
                                        $_POST['codigo'],
                                        $_POST['data']
            );
}

function editOrdenTrabajoRec() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->editOrdenTrabajoRec  (    
                                        $_POST['codigo'],
                                        $_POST['data']
            );
}

function cambiarEstadoOrdenTrabajo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->cambiarEstadoOrdenTrabajo  (    
                                        $_POST['codigo'],
                                        $_POST['estado']
            );
}

function getOtPersona() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getOtPersona  (    
                                        $_POST['codigo'],
                                        $_POST['cod_ov']
            );
}

function getTarea() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getTarea  (    
                                        $_POST['codigo'],
                                        $_POST['cod_ov']
            );
}

function addOrdenTrabajo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->addOrdenTrabajo  (    
                                        $_POST['fecha'],
                                        $_POST['cliente'],
                                        $_POST['ordenventa'],
                                        $_POST['producto'],
                                        $_POST['observaciones'],
                                        $_POST['id_cajaquebrado'],
                                        $_POST['id_cajaquebrado2'],
                                        $_POST['id_sinfin'],
                                        $_POST['id_motor'],
                                        $_POST['personal_ot']
            );
}

function addOrdenTrabajo2() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->addOrdenTrabajo2  (    
                                        $_POST['option']
            );
}

function addOrdenTrabajoPersona() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->addOrdenTrabajoPersona  (    
                                        $_POST['cod_ot'],
                                        $_POST['categoria'],
                                        $_POST['empleado']
            );
}

function addOrdenTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->addOrdenTrabajoInsumo  (    
                                        $_POST['orden_trabajo'],
                                        $_POST['insumo'],
                                        $_POST['cantidad'],
                                        $_POST['precio']
            );
}

function addDetalleOt() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->addDetalleOt  (    
                                        $_POST['orden_trabajo'],
                                        $_POST['empleado'],
                                        $_POST['detalle']

            );
}

function addCorreasOt() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->addCorreasOt  (    
                                        $_POST['orden_trabajo'],
                                        $_POST['empleado'],
                                        $_POST['detalle']

            );
}

function addTransmisionOt() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->addTransmisionOt  (    
                                        $_POST['orden_trabajo'],
                                        $_POST['empleado'],
                                        $_POST['detalle']

            );
}

function updateOrdenTrabajo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateOrdenTrabajo(    $_POST['codigo'], 
                                                $_POST['fecha'],
                                                $_POST['cliente'],
                                                $_POST['producto'],
                                                $_POST['observaciones']
            );
}

function updateOrdenTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateOrdenTrabajoInsumo(    $_POST['codigo'], 
                                        $_POST['orden_trabajo'],
                                        $_POST['insumo'],
                                        $_POST['cantidad'],
                                        $_POST['precio']
            );
}

function updateDetalleTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateDetalleTrabajoInsumo(    $_POST['codigo'], 
                                        $_POST['id_empleado'],
                                        $_POST['detalle']
            );
}

function updateCorreasTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateCorreasTrabajoInsumo(    $_POST['codigo'], 
                                        $_POST['id_empleado'],
                                        $_POST['detalle']
            );
}

function updateTransmisionTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateTransmisionTrabajoInsumo(    $_POST['codigo'], 
                                        $_POST['id_empleado'],
                                        $_POST['detalle']
            );
}

function updateOrdenTrabajoPersona() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateOrdenTrabajoPersona(    $_POST['codigo'], 
                                        $_POST['categoria'],
                                        $_POST['empleado']
            );
}

function updateOrdenTrabajoTarea() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateOrdenTrabajoTarea(    $_POST['codigo'], 
                                        $_POST['cod_ov'],
                                        $_POST['cantidad'],
                                        $_POST['observaciones']
            );
}

function updateOrdenTrabajoInsumoRec() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->updateOrdenTrabajoInsumoRec(    $_POST['codigo'], 
                                        $_POST['orden_trabajo'],
                                        $_POST['recibido']
            );
}

function deleteOrdenTrabajo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->deleteOrdenTrabajo($_POST['codigo']);
}

function deleteOrdenTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->deleteOrdenTrabajoInsumo($_POST['codigo']);
}

function deleteDetalleTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->deleteDetalleTrabajoInsumo($_POST['codigo']);
}

function deleteCorreasTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->deleteCorreasTrabajoInsumo($_POST['codigo']);
}

function deleteTransmisionTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->deleteTransmisionTrabajoInsumo($_POST['codigo']);
}

function deleteOtPersona() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->deleteOtPersona($_POST['codigo']);
}

function getOrdenTrabajo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getOrdenTrabajo($_POST['codigo']);
}

function getOrdenTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getOrdenTrabajoInsumo($_POST['codigo']);
}

function getDetalleTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getDetalleTrabajoInsumo($_POST['codigo']);
}

function getDetalleTrabajoPdf() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getDetalleTrabajoPdf($_POST['codigo']);
}

function getTransmisionTrabajoPdf() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getTransmisionTrabajoPdf($_POST['codigo']);
}

function getPoleaTrabajoPdf() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getPoleaTrabajoPdf($_POST['codigo']);
}

function getCorreasTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getCorreasTrabajoInsumo($_POST['codigo']);
}

function getTransmisionTrabajoInsumo() {
    $controlador = OrdenTrabajosController::singleton_orden_trabajos();
    
    echo $controlador->getTransmisionTrabajoInsumo($_POST['codigo']);
}

class OrdenTrabajosController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/orden_trabajos.model.php";
            $this->conn = OrdenTrabajosModel::singleton_orden_trabajos();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_orden_trabajos() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountOrdenTrabajos(){
        return intval($this->conn->getCountOrdenTrabajos()[0]);
        
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

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajos.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroSingle($codigo, $ver){

        unset($_SESSION["ver"]);

        $_SESSION["ver"] = intval($ver);
        
        $orden_trabajo = $this->conn->getOrdenTrabajo($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();

        $personas = $this->getPersonas();
        
        $orden_venta = $this->getVenta($orden_trabajo["cod_orden_venta"])[0];

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.busqueda.template.php";
        
    }
    
    public function getRegistrosFiltroTareas($codigo, $ver){

        unset($_SESSION["ver"]);

        $_SESSION["ver"] = intval($ver);
        
        //$orden_trabajo = $this->conn->getOrdenTrabajo($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();
        
        $orden_venta = $this->getVenta($codigo)[0];

        $tareas = $this->getTareas();

        $tareas_realizadas = $this->getTareasRealizadas($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.tareas.template.php";
        
    }
    
    public function getRegistrosFiltroPersonas($codigo, $ver){

        unset($_SESSION["ver"]);

        $_SESSION["ver"] = intval($ver);
        
        //$orden_trabajo = $this->conn->getOrdenTrabajo($codigo)[0];

        $categorias = $this->getCategoriasComponentes();

        $personas = $this->getPersonas();

        $personas_inv = $this->conn->getPersonasOt($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.personas.template.php";
        
    }
    
    public function getRegistrosFiltroSingleRecepcion($codigo, $ver){
        
        $orden_trabajo = $this->conn->getOrdenTrabajo($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.recepcion.template.php";
        
    }
    
    public function getDetallesAsociados($codigo){
        
        $registros = $this->conn->getDetallesAsociados($codigo);

        return $registros;
        
    }

    public function getDetallesAsociados2($codigo, $tabla){
        
        $registros = $this->conn->getDetallesAsociados2($codigo, $tabla);

        return $registros;
        
    }
    
    public function getRegistrosFiltroAsociados($codigo){
        
        $registros = $this->conn->getDetallesAsociados($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.insumos.template.php";
        
    }

    public function getRegistrosFiltroAsociados2($codigo){
        
        $registros = $this->conn->getDetallesAsociados2($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.detalles.template.php";
        
    }

    public function getRegistrosFiltroAsociados3($codigo){
        
        $registros = $this->conn->getDetallesAsociados3($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.poleas_correas.template.php";
        
    }

    public function getRegistrosFiltroAsociados4($codigo){
        
        $registros = $this->conn->getDetallesAsociados4($codigo);

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.transmision.template.php";
        
    }
    
    public function getRegistrosFiltroAsociadosRecepcion($codigo){
        
        $registros = $this->conn->getDetallesAsociados($codigo);

        $oc = $this->conn->getOrdenTrabajo($codigo)[0];

        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/orden_trabajo.insumos.rec.template.php";
        
    }

    public function addOrdenTrabajo2($option) {
        $devuelve = $this->conn->addOrdenTrabajo2($option);
      
        return json_encode($devuelve[0]);
        
    }

    public function addOrdenTrabajo($fecha, $cliente,$ordenventa, $producto, $observaciones, $id_cajaquebrado,$id_cajaquebrado2, $id_sinfin,$id_motor,$personal_ot) {
        $devuelve = $this->conn->addOrdenTrabajo($fecha, $cliente,$ordenventa, $producto, $observaciones, $id_cajaquebrado,$id_cajaquebrado2, $id_sinfin,$id_motor, $personal_ot);
        $ov = $this->getVenta($producto)[0];
        if ($devuelve > 0 and $ov["cod_orden_venta_tipo"] == 1){
            $cod_ot = $devuelve;
            if ($ov["componente"]){
                $insumos = $this->conn->getInsumosAsociados($ov["cod_componente"]);
                foreach($insumos as $ins){
                    $precio = floatval($this->conn->getComponente($ins["cod_insumo"])[0]["costo_unitario"]);
                    $precio_usd = floatval($this->conn->getComponente($ins["cod_insumo"])[0]["costo_unitario_usd"]);
                    $dev = $this->conn->addOrdenTrabajoInsumo($cod_ot, $ins["cod_insumo"], $ins["cantidad"], $precio, $precio_usd);
                }
            }
            if ($ov["maquina"]){
                $insumos = $this->conn->getInsumosAsociadosMaq($ov["cod_maquina"]);
                foreach($insumos as $ins){
                    $precio = floatval($this->conn->getComponente($ins["cod_componente"])[0]["costo_unitario"]);
                    $precio_usd = floatval($this->conn->getComponente($ins["cod_componente"])[0]["costo_unitario_usd"]);
                    $dev = $this->conn->addOrdenTrabajoInsumo($cod_ot, $ins["cod_componente"], $ins["cantidad"], $precio, $precio_usd);
                }
            }
        }
        return $devuelve;
        
    }
    
    public function addOrdenTrabajoPersona($orden_trabajo, $categoria, $persona) {

        $devuelve = $this->conn->addOrdenTrabajoPersona($orden_trabajo, $categoria, $persona);
        
        return $devuelve;
        
    }
    
    public function addOrdenTrabajoInsumo($orden_trabajo, $insumo, $cantidad, $precio) {
        
        $precio = floatval($this->conn->getComponente($insumo)[0]["costo_unitario"]);
        $precio_usd = floatval($this->conn->getComponente($insumo)[0]["costo_unitario_usd"]);

        $devuelve = $this->conn->addOrdenTrabajoInsumo($orden_trabajo, $insumo, $cantidad, $precio, $precio_usd);
        
        return $devuelve;
        
    }

    public function addDetalleOt($orden_trabajo, $empleado, $detalle) {
        
        $devuelve = $this->conn->addDetalleOt($orden_trabajo, $empleado, $detalle);
        
        return $devuelve;
        
    }

    public function addCorreasOt($orden_trabajo, $empleado, $detalle) {
        
        $devuelve = $this->conn->addCorreasOt($orden_trabajo, $empleado, $detalle);
        
        return $devuelve;
        
    }

    public function addTransmisionOt($orden_trabajo, $empleado, $detalle) {
        
        $devuelve = $this->conn->addTransmisionOt($orden_trabajo, $empleado, $detalle);
        
        return $devuelve;
        
    }
    
    public function cambiarEstadoOrdenTrabajo($codigo, $estado) {
        $devuelve = $this->conn->cambiarEstadoOrdenTrabajo($codigo, $estado);
        
        return $devuelve;
        
    }
    
    public function getOtPersona($codigo, $cod_ov) {
        $devuelve = $this->conn->getOtPersona($codigo, $cod_ov);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getTarea($codigo, $cod_ov) {
        $devuelve = $this->conn->getTarea($codigo, $cod_ov);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function editOrdenTrabajo($codigo, $data) {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editOrdenTrabajo($codigo, $datos);
        
        return $devuelve;
        
    }
    
    public function editOrdenTrabajoRec($codigo, $data) {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editOrdenTrabajoRec($codigo, $datos);
        
        return $devuelve;
        
    }
    
    public function updateOrdenTrabajo($codigo, $fecha, $cliente, $producto, $observaciones) {
        $devuelve = $this->conn->updateOrdenTrabajo($codigo, $fecha, $cliente, $producto, $observaciones);
        
        return $devuelve;
        
    }
    
    public function updateOrdenTrabajoInsumo($codigo, $orden_trabajo, $insumo, $cantidad, $precio) {
        
        $precio = floatval($this->conn->getComponente($insumo)[0]["costo_unitario"]);
        $precio_usd = floatval($this->conn->getComponente($insumo)[0]["costo_unitario_usd"]);

        $devuelve = $this->conn->updateOrdenTrabajoInsumo($codigo, $orden_trabajo, $insumo, $cantidad, $precio, $precio_usd);
        
        return $devuelve;
        
    }

    public function updateDetalleTrabajoInsumo($codigo, $id_empleado, $detalle) {
        
        $devuelve = $this->conn->updateDetalleTrabajoInsumo($codigo, $id_empleado, $detalle);
        
        return $devuelve;
        
    }

    public function updateCorreasTrabajoInsumo($codigo, $id_empleado, $detalle) {
        
        $devuelve = $this->conn->updateCorreasTrabajoInsumo($codigo, $id_empleado, $detalle);
        
        return $devuelve;
        
    }

    public function updateTransmisionTrabajoInsumo($codigo, $id_empleado, $detalle) {
        
        $devuelve = $this->conn->updateTransmisionTrabajoInsumo($codigo, $id_empleado, $detalle);
        
        return $devuelve;
        
    }
    
    public function updateOrdenTrabajoPersona($codigo, $categoria, $persona) {
        
        $devuelve = $this->conn->updateOrdenTrabajoPersona($codigo, $categoria, $persona);
        
        return $devuelve;
        
    }
    
    public function updateOrdenTrabajoTarea($codigo, $orden_venta, $cantidad, $observaciones) {
        
        $devuelve = $this->conn->updateOrdenTrabajoTarea($codigo, $orden_venta, $cantidad, $observaciones);
        
        return $devuelve;
        
    }
    
    public function updateOrdenTrabajoInsumoRec($codigo, $orden_trabajo, $recibido) {
        $devuelve = $this->conn->updateOrdenTrabajoInsumoRec($codigo, $orden_trabajo, $recibido);
        
        return $devuelve;
        
    }
    
    public function deleteOrdenTrabajo($codigo) {
        $devuelve = $this->conn->deleteOrdenTrabajo($codigo);
        
        return $devuelve;
        
    }
    
    public function deleteOrdenTrabajoInsumo($codigo) {
        $devuelve = $this->conn->deleteOrdenTrabajoInsumo($codigo);
        
        return $devuelve;
        
    }

    public function deleteDetalleTrabajoInsumo($codigo) {
        $devuelve = $this->conn->deleteDetalleTrabajoInsumo($codigo);
        
        return $devuelve;
        
    }

    public function deleteCorreasTrabajoInsumo($codigo) {
        $devuelve = $this->conn->deleteCorreasTrabajoInsumo($codigo);
        
        return $devuelve;
        
    }

    public function deleteTransmisionTrabajoInsumo($codigo) {
        $devuelve = $this->conn->deleteTransmisionTrabajoInsumo($codigo);
        
        return $devuelve;
        
    }
    
    public function deleteOtPersona($codigo) {
        $devuelve = $this->conn->deleteOtPersona($codigo);
        
        return $devuelve;
        
    }
    
    public function getOrdenVentaArray($codigo) {
        $devuelve = $this->conn->getOrdenVenta($codigo);
        
        return $devuelve;
        
    }
    
    public function getOrdenTrabajoArray($codigo) {
        $devuelve = $this->conn->getOrdenTrabajo($codigo);
        
        return $devuelve;
        
    }
    
    public function getOrdenTrabajo($codigo) {
        $devuelve = $this->conn->getOrdenTrabajo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getOrdenTrabajoInsumo($codigo) {
        $devuelve = $this->conn->getOrdenTrabajoInsumo($codigo);
        
        return json_encode($devuelve[0]);
        
    }

    public function getDetalleTrabajoInsumo($codigo) {
        $devuelve = $this->conn->getDetalleTrabajoInsumo($codigo);
        
        return json_encode($devuelve[0]);
        
    }

    public function getDetalleTrabajoPdf($codigo) {
        $devuelve = $this->conn->getDetalleTrabajoPdf($codigo);
        
        return $devuelve;
        
    }

    public function getTransmisionTrabajoPdf($codigo) {
        $devuelve = $this->conn->getTransmisionTrabajoPdf($codigo);
        
        return $devuelve;
        
    }

    public function getPoleaTrabajoPdf($codigo) {
        $devuelve = $this->conn->getPoleaTrabajoPdf($codigo);
        
        return $devuelve;
        
    }

    public function getCorreasTrabajoInsumo($codigo) {
        $devuelve = $this->conn->getCorreasTrabajoInsumo($codigo);
        
        return json_encode($devuelve[0]);
        
    }

    public function getTRansmisionTrabajoInsumo($codigo) {
        $devuelve = $this->conn->getTransmisionTrabajoInsumo($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getUnidades() {
        $devuelve = $this->conn->getUnidades();
        
        return $devuelve;
        
    }
    
    public function getTareas() {
        $devuelve = $this->conn->getTareas();
        
        return $devuelve;
        
    }
    
    public function getTareasRealizadas($cod_ov) {
        $devuelve = $this->conn->getTareasRealizadas($cod_ov);
        
        return $devuelve;
        
    }
    
    public function getProveedores() {
        $devuelve = $this->conn->getProveedores();
        
        return $devuelve;
        
    }
    
    public function getClientes() {
        $devuelve = $this->conn->getClientes();
        
        return $devuelve;
        
    }
    
    public function getOrdenTrabajosCategorias() {
        $devuelve = $this->conn->getOrdenTrabajosCategorias();
        
        return $devuelve;
        
    }
    
    public function getCategoriasComponentes() {
        $devuelve = $this->conn->getCategoriasComponentes();
        
        return $devuelve;
        
    }
    
    public function getPersonasOt($cod_ot) {
        $devuelve = $this->conn->getPersonasOt($cod_ot);
        
        return $devuelve;
        
    }
    
    public function getPersonas() {
        $devuelve = $this->conn->getPersonas();
        
        return $devuelve;
        
    }
    
    public function getMaquinas() {
        $devuelve = $this->conn->getMaquinas();
        
        return $devuelve;
        
    }
    
    public function getInsumos() {
        $devuelve = $this->conn->getInsumos();
        
        return $devuelve;
        
    }
    
    public function getProductos() {
        $devuelve = $this->conn->getProductos();
        
        return $devuelve;
        
    }
    
    public function getVenta($codigo) {
        $devuelve = $this->conn->getVenta($codigo);
        
        return $devuelve;
        
    }
    
    public function getVentas() {
        $devuelve = $this->conn->getVentas();
        
        return $devuelve;
        
    }
    
    public function getVentasPendientes() {
        $devuelve = $this->conn->getVentasPendientes();
        
        return $devuelve;
        
    }
    
    public function getVentasPendientesInicio() {
        $devuelve = $this->conn->getVentasPendientesInicio();
        
        return $devuelve;
        
    }

    public function getCajaDeQuebrados() {
        $devuelve = $this->conn->getCajaDeQuebrados();
        
        return $devuelve;
        
    }

    public function getSinFin() {
        $devuelve = $this->conn->getSinFin();
        
        return $devuelve;
        
    }

    public function getMotor() {
        $devuelve = $this->conn->getMotor();
        
        return $devuelve;
        
    }
    
}
