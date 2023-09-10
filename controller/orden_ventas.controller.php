<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda']);
}

function getRegistrosFiltroSingle()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getRegistrosFiltroSingle($_POST['codigo']);
}

function getRegistrosFiltroSinglePagos()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getRegistrosFiltroSinglePagos($_POST['codigo']);
}

function getRegistrosFiltroSingleRecepcion()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getRegistrosFiltroSingleRecepcion(
        $_POST['codigo'],
        $_POST['ver']
    );
}

function getRegistrosFiltroAsociados()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getRegistrosFiltroAsociados($_POST['codigo']);
}

function getRegistrosFiltroAsociadosPagos()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getRegistrosFiltroAsociadosPagos($_POST['codigo']);
}

function getRegistrosFiltroAsociadosRecepcion()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getRegistrosFiltroAsociadosRecepcion($_POST['codigo']);
}

function editOrdenVenta()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->editOrdenVenta(
        $_POST['codigo'],
        $_POST['data']
    );
}

function editOrdenVentaRec()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->editOrdenVentaRec(
        $_POST['codigo'],
        $_POST['data']
    );
}

function cambiarEstadoOrdenVenta()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->cambiarEstadoOrdenVenta(
        $_POST['codigo'],
        $_POST['estado']
    );
}

function addOrdenVenta()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->addOrdenVenta(
        $_POST['fecha'],
        $_POST['cliente'],
        $_POST['pais'],
        $_POST['provincia'],
        $_POST['producto'],
        $_POST['cuit'],
        $_POST['tipoprod'],
        $_POST['tipouso'],
        $_POST['observaciones'],
        $_POST['general'],
        $_POST['entrega'],
        $_POST['cobranza'],
        $_POST['precio'],
        $_POST['tipo'],
        $_POST['cantidad']
    );
}

function addOrdenVentaInsumo()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->addOrdenVentaInsumo(
        $_POST['orden_venta'],
        $_POST['insumo'],
        $_POST['cantidad'],
        $_POST['precio']
    );
}

function addOrdenVentaPago()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->addOrdenVentaPago(
        $_POST['orden_venta'],
        $_POST['fecha'],
        $_POST['forma'],
        $_POST['importe'],
        $_POST['observaciones']
    );
}

function updateOrdenVenta()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->updateOrdenVenta(
        $_POST['codigo'],
        $_POST['fecha'],
        $_POST['fechaentrega'],
        $_POST['cliente'],
        $_POST['pais'],
        $_POST['provincia'],
        $_POST['producto'],
        $_POST['cuit'],
        $_POST['tipoprod'],
        $_POST['observaciones'],
        $_POST['general'],
        $_POST['entrega'],
        $_POST['cobranza'],
        $_POST['precio']
    );
}

function updateOrdenVentaInsumo()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->updateOrdenVentaInsumo(
        $_POST['codigo'],
        $_POST['orden_venta'],
        $_POST['insumo'],
        $_POST['cantidad'],
        $_POST['precio']
    );
}

function updateOrdenVentaPago()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->updateOrdenVentaPago(
        $_POST['codigo'],
        $_POST['orden_venta'],
        $_POST['fecha'],
        $_POST['forma'],
        $_POST['importe'],
        $_POST['observaciones']
    );
}

function updateOrdenVentaInsumoRec()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->updateOrdenVentaInsumoRec(
        $_POST['codigo'],
        $_POST['orden_venta'],
        $_POST['recibido']
    );
}

function deleteOrdenVenta()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->deleteOrdenVenta($_POST['codigo']);
}

function deleteOrdenVentaInsumo()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->deleteOrdenVentaInsumo($_POST['codigo']);
}

function deleteOrdenVentaPago()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->deleteOrdenVentaPago($_POST['codigo']);
}

function  getOrdenVentacomponenteinsumo()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getOrdenVentacomponenteinsumo($_POST['codigo']);
}

function getOrdenVenta()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getOrdenVenta($_POST['codigo']);
}

function getOrdenVentaInsumo()
{
    $controlador = OrdenVentasController::singleton_orden_ventas();

    echo $controlador->getOrdenVentaInsumo($_POST['codigo']);
}

class OrdenVentasController
{

    private static $instancia;
    private $conn;

    public function __construct()
    {
        try {
            include $_SERVER['DOCUMENT_ROOT'] . "/VICA/model/orden_ventas.model.php";
            $this->conn = OrdenVentasModel::singleton_orden_ventas();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_orden_ventas()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function getCountOrdenVentas()
    {
        return intval($this->conn->getCountOrdenVentas()[0]);
    }

    public function getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda)
    {

        $_SESSION["pagina"] = $pagina;

        $_SESSION["cant_reg"] = $registros;

        $_SESSION["busqueda"] = $busqueda;

        $_SESSION['orderby'] = $orderby;

        $_SESSION['sentido'] = $sentido;

        $devuelve = $this->conn->getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda);

        $tipos = $this->getTipos();

        $registros = $devuelve;

        $_SESSION['registros'] = $registros;

        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/templates/orden_ventas.busqueda.template.php";
    }

    public function getRegistrosFiltroSingle($codigo)
    {

        $orden_venta = $this->conn->getOrdenVenta($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();

        $vendedores = $this->getVendedores();

        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/templates/orden_venta.busqueda.template.php";
    }

    public function getRegistrosFiltroSinglePagos($codigo)
    {

        $orden_venta = $this->conn->getOrdenVenta($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();

        $vendedores = $this->getVendedores();

        $formas = $this->getFormas();

        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/templates/orden_venta.pagos.template.php";
    }

    public function getRegistrosFiltroSingleRecepcion($codigo, $ver)
    {

        $orden_venta = $this->conn->getOrdenVenta($codigo)[0];

        $unidades = $this->getUnidades();

        $proveedores = $this->getProveedores();

        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/templates/orden_venta.recepcion.template.php";
    }

    public function getRegistrosFiltroAsociados($codigo)
    {

        $registros = $this->conn->getDetallesAsociados($codigo);

        $ov = $this->getVenta(intval($codigo))[0];

        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/templates/orden_venta.insumos.template.php";
    }

    public function getRegistrosFiltroAsociadosPagos($codigo)
    {

        $registros = $this->conn->getPagosAsociados($codigo);

        $ov = $this->getVenta(intval($codigo))[0];

        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/templates/orden_venta.pago.template.php";
    }

    public function getRegistrosFiltroAsociadosRecepcion($codigo)
    {

        $registros = $this->conn->getDetallesAsociados($codigo);

        $oc = $this->conn->getOrdenVenta($codigo)[0];

        include $_SERVER['DOCUMENT_ROOT'] . "/VICA/templates/orden_venta.insumos.rec.template.php";
    }

    public function addOrdenVenta($fecha, $cliente, $pais, $provincia, $producto,$cuit, $tipoprod, $tipouso, $observaciones, $general, $entrega, $cobranza, $precio, $tipo, $cantidad)
    {
        $devuelve = $this->conn->addOrdenVenta($fecha, $cliente, $pais, $provincia, $producto,$cuit, $tipoprod, $tipouso, $observaciones, $general, $entrega, $cobranza, $precio, $tipo, $cantidad);
        
        if ($devuelve > 0){
            $cod_ot = $devuelve;            
            if ($tipoprod == 3 || $tipoprod == 2) { // maquina
                $insumos = $this->conn->getComponentesAsociados(abs($producto));
            } else {
                $insumos = $this->conn->getInsumosAsociados(abs($producto));
            }
            foreach($insumos as $ins){
                
                if ($tipoprod == 3 || $tipoprod == 2) { // maquina
                    $precio = floatval($this->conn->getComponente($ins["cod_componente"])[0]["costo_unitario"]);
                    $precio_usd = floatval($this->conn->getComponente($ins["cod_componente"])[0]["costo_unitario_usd"]);
                    $dev = $this->conn->addOrdenVentaInsumo($cod_ot, $ins["cod_componente"], $ins["cantidad"] * $cantidad, $precio, $precio_usd);
                } else {
                    $precio = floatval($this->conn->getComponente($ins["cod_insumo"])[0]["costo_unitario"]);
                    $precio_usd = floatval($this->conn->getComponente($ins["cod_insumo"])[0]["costo_unitario_usd"]);
                    $dev = $this->conn->addOrdenVentaInsumo($cod_ot, $ins["cod_insumo"], $ins["cantidad"] * $cantidad, $precio, $precio_usd);
                }
            }

            if (count($insumos) == 0 and $tipoprod == 1){ // Insumos
                $precio = floatval($this->conn->getComponente(abs($producto))[0]["costo_unitario"]);
                $precio_usd = floatval($this->conn->getComponente(abs($producto))[0]["costo_unitario_usd"]);
                $dev = $this->conn->addOrdenVentaInsumo($cod_ot, abs($producto), 1  * $cantidad, $precio, $precio_usd);
            }
        }

        return $devuelve;
    }

    public function addOrdenVentaInsumo($orden_venta, $insumo, $cantidad, $precio)
    {
        $ov = $this->getVenta($orden_venta)[0];
        if ($ov["maquina"]){
            $precio = floatval($this->conn->getComponente($insumo)[0]["costo_unitario"]);
            $precio_usd = floatval($this->conn->getComponente($insumo)[0]["costo_unitario_usd"]);
            $devuelve = $this->conn->addOrdenVentaInsumo($orden_venta, $insumo, $cantidad, $precio, $precio_usd);
        } else {
            $precio = floatval($this->conn->getComponente($insumo)[0]["costo_unitario"]);
            $precio_usd = floatval($this->conn->getComponente($insumo)[0]["costo_unitario_usd"]);
            $devuelve = $this->conn->addOrdenVentaInsumo($orden_venta, $insumo, $cantidad, $precio, $precio_usd);
        }

        return $devuelve;
    }

    public function addOrdenVentaPago($orden_venta, $fecha, $forma, $importe, $observaciones)
    {
        $ov = $this->getVenta($orden_venta)[0];
        $devuelve = $this->conn->addOrdenVentaPago($orden_venta, $fecha, $forma, $importe, $observaciones);
        return $devuelve;
    }

    public function cambiarEstadoOrdenVenta($codigo, $estado)
    {
        $devuelve = $this->conn->cambiarEstadoOrdenVenta($codigo, $estado);

        return $devuelve;
    }

    public function editOrdenVenta($codigo, $data)
    {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editOrdenVenta($codigo, $datos);

        return $devuelve;
    }

    public function editOrdenVentaRec($codigo, $data)
    {
        $datos = json_decode($data, true);

        $devuelve = $this->conn->editOrdenVentaRec($codigo, $datos);

        return $devuelve;
    }

    public function updateOrdenVenta($codigo, $fecha, $fechaentrega, $cliente, $pais, $provincia, $producto,$cuit, $tipoprod, $observaciones, $general, $entrega, $cobranza, $precio)
    {
        $devuelve = $this->conn->updateOrdenVenta($codigo, $fecha, $fechaentrega, $cliente, $pais, $provincia, $producto,$cuit, $tipoprod, $observaciones, $general, $entrega, $cobranza, $precio);

        return $devuelve;
    }

    public function updateOrdenVentaInsumo($codigo, $orden_venta, $insumo, $cantidad, $precio)
    {
        $devuelve = $this->conn->updateOrdenVentaInsumo($codigo, $orden_venta, $insumo, $cantidad, $precio);

        return $devuelve;
    }

    public function updateOrdenVentaPago($codigo, $orden_venta, $fecha, $forma, $importe, $observaciones)
    {
        $devuelve = $this->conn->updateOrdenVentaPago($codigo, $orden_venta, $fecha, $forma, $importe, $observaciones);

        return $devuelve;
    }

    public function updateOrdenVentaInsumoRec($codigo, $orden_venta, $recibido)
    {
        $devuelve = $this->conn->updateOrdenVentaInsumoRec($codigo, $orden_venta, $recibido);

        return $devuelve;
    }

    public function deleteOrdenVenta($codigo)
    {
        $devuelve = $this->conn->deleteOrdenVenta($codigo);

        return $devuelve;
    }

    public function deleteOrdenVentaInsumo($codigo)
    {
        $devuelve = $this->conn->deleteOrdenVentaInsumo($codigo);

        return $devuelve;
    }

    public function deleteOrdenVentaPago($codigo)
    {
        $devuelve = $this->conn->deleteOrdenVentaPago($codigo);

        return $devuelve;
    }

    public function getOrdenVenta($codigo)
    {
        $devuelve = $this->conn->getOrdenVenta($codigo);


        $componente = $this->conn->getComponente($devuelve[0]['cod_componente'])[0];

        $maquina = $this->conn->getMaquina($devuelve[0]['cod_maquina'])[0];
        
        if ($devuelve[0]['cod_maquina'] > 0) {
            $devuelve[0]['cod']= $maquina['codigo'];
            $devuelve[0]['es_usado'] = $maquina['es_usado'];
            $devuelve[0]['es_insumo'] = 3;
        } else {
            $devuelve[0]['cod']= $componente['codigo'];
            $devuelve[0]['es_usado'] = $componente['es_usado'];
            $devuelve[0]['es_insumo'] = $componente['es_insumo'] == 1 ? 1 : 2;
        }

        //$devuelve[0]['tipo_insumo']


        return json_encode($devuelve[0]);




        //var_dump($devuelve);
        //echo json_encode($devuelve[0]);


    }
    public function getOrdenVentacomponenteinsumo($codigo)
    {
        $devuelve = $this->conn->getOrdenVenta($codigo);
        return json_encode($devuelve[0]['tipo']);
    }
    public function getOrdenVentaInsumo($codigo)
    {
        $devuelve = $this->conn->getOrdenVentaInsumo($codigo);

        return json_encode($devuelve[0]);
    }

    public function getUnidades()
    {
        $devuelve = $this->conn->getUnidades();

        return $devuelve;
    }

    public function getVendedores()
    {
        $devuelve = $this->conn->getVendedores();

        return $devuelve;
    }

    public function getProveedores()
    {
        $devuelve = $this->conn->getProveedores();

        return $devuelve;
    }

    public function getClientes()
    {
        $devuelve = $this->conn->getClientes();

        return $devuelve;
    }

    public function getOrdenVentasCategorias()
    {
        $devuelve = $this->conn->getOrdenVentasCategorias();

        return $devuelve;
    }

    public function getInsumos()
    {
        $devuelve = $this->conn->getInsumos();

        return $devuelve;
    }

    public function getComponentes()
    {
        $devuelve = $this->conn->getComponentes();

        return $devuelve;
    }

    public function getProductos()
    {
        $devuelve = $this->conn->getProductos();

        return $devuelve;
    }


    public function getProductos2()
    {
        $devuelve = $this->conn->getProductos2();
        return $devuelve;
    }
    public function getProductos3()
    {
        $devuelve = $this->conn->getProductos3();
        return $devuelve;
    }
    public function getMaquinas()
    {
        $devuelve = $this->conn->getMaquinas();

        return $devuelve;
    }

    public function getEstados()
    {
        $devuelve = $this->conn->getEstados();

        return $devuelve;
    }

    public function getTipos()
    {
        $devuelve = $this->conn->getTipos();

        return $devuelve;
    }

    public function getFormas()
    {
        $devuelve = $this->conn->getFormas();

        return $devuelve;
    }

    public function getPaises()
    {
        $devuelve = $this->conn->getPaises();

        return $devuelve;
    }

    public function getProvincias()
    {
        $devuelve = $this->conn->getProvincias();

        return $devuelve;
    }
    
    public function getVenta($codigo) {
        $devuelve = $this->conn->getVenta($codigo);
        
        return $devuelve;
        
    }
}
