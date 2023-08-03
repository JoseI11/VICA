<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

if (isset($_POST['funcion'])) {
    if (function_exists($_POST['funcion'])) {
        $_POST['funcion']();
    }
}

function getRegistrosFiltro(){
    $controlador = StocksController::singleton_stocks();
    
    echo $controlador->getRegistrosFiltro($_POST['orderby'], $_POST['sentido'], $_POST['registros'], $_POST['pagina'], $_POST['busqueda'], $_POST["componente"],$_POST["tipo"],$_POST["insumo"]);
}

function getStock() {
    $controlador = StocksController::singleton_stocks();
    
    echo $controlador->getStock($_POST['codigo']);
}

function addRegistro() {
    $controlador = StocksController::singleton_stocks();      
    echo $controlador->addRegistro(   
        $_POST['impacto'],
        $_POST['fecha'],
        $_POST['producto'],
        $_POST['cantidad'],
        $_POST['motivo'],
        $_POST['tipodeuso'],
        $_POST['tipoproducto']
    );
}

class StocksController {

    private static $instancia;
    private $conn;

    public function __construct() {
        try {
            include $_SERVER['DOCUMENT_ROOT']."/VICA/model/stocks.model.php";
            $this->conn = StocksModel::singleton_stocks();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_stocks() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountStocks(){
        return intval($this->conn->getCountStocks()[0]);
        
    }

    
    public function getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda, $componente,$tipouso,$tipoinsumo){
        
        $_SESSION["pagina"] = $pagina;
        
        $_SESSION["cant_reg"] = $registros;
        
        $_SESSION["busqueda"] = $busqueda;
                
        $_SESSION['orderby'] = $orderby;
        
        $_SESSION['sentido'] = $sentido;
                    
        $devuelve               = $this->conn->getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda, $componente,$tipouso,$tipoinsumo);
        $devuelve_maquinas      = $this->conn->getRegistrosFiltroMaquina($orderby, $sentido, $registros, $pagina, $busqueda, $componente,$tipouso,$tipoinsumo);
        $ventas                 = $this->conn->getVentas($componente);
        $ventas_entregadas      = $this->conn->getVentasEntregadas($componente);
        $ventas_entregadas_otro = $this->conn->getVentasEntregadasOtro($componente);
        $compras                = $this->conn->getCompras($componente);
        $producido              = $this->conn->getProducido($componente);      
        $producido_terminado    = $this->conn->getProducidoTerminado($componente);      
        $producido_terminado_m  = $this->conn->getProducidoTerminadoMaquina($componente);      
        $ajustes                = $this->conn->getAjustes($componente,$tipouso,$tipoinsumo);  
        $ajustes_maquinas       = $this->conn->getAjustesMaquinas($componente,$tipouso,$tipoinsumo);  
        $aux                    = [];
        if ($tipoinsumo == 3 || $tipoinsumo == 2) { // maquina
            foreach ($devuelve_maquinas as $pos => $dev){
                $a = [];
                $a["fecha"] = "-";
                $a["descripcion"] = "Cantidad Inicial";
                $a["impacto"] = 1;
                $a["cantidad"] = floatval($dev["inicial"]);
                $aux["-"][] = $a;
            }
            foreach ($ajustes_maquinas as $pos => $dev){
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha"]));
                $a["descripcion"] = "Ajuste Manual: " . $dev["observaciones"];
                $a["impacto"] = $dev["impacto"];
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
            foreach ($ventas as $pos => $dev){
                if ($dev["cantidad"] <= 0){
                    continue;
                }
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha"]));
                $a["descripcion"] = "Producción Diaria" . " ( $ " . number_format($dev["precio_maquina"],2) . ") ";
                $a["impacto"] = 1;
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
            foreach ($ventas_entregadas as $pos => $dev){
                if ($dev["cantidad"] <= 0){
                    continue;
                }
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha"]));
                $a["descripcion"] = "Entrega a cliente" . " ( $ " . number_format($dev["precio_maquina"],2) . ") ";;
                $a["impacto"] = -1;
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
            foreach ($producido_terminado_m as $pos => $dev){
                if ($dev["cantidad"] <= 0){
                    continue;
                }
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha_m"]));
                $a["descripcion"] = "Producción Diaria";
                $a["impacto"] = 1;
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
        } else {
            foreach ($devuelve as $pos => $dev){
                $a = [];
                $a["fecha"] = "-";
                $a["descripcion"] = "Cantidad Inicial";
                $a["impacto"] = 1;
                $a["cantidad"] = floatval($dev["inicial"]);
                $aux["-"][] = $a;
            }
            foreach ($compras as $pos => $dev){
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha"]));
                $a["descripcion"] = "Compra " . $dev["persona"] . " ( $ " . number_format($dev["precio"] * $dev["cantidad_recibida"],2) . ") ";
                $a["impacto"] = 1;
                $a["cantidad"] += floatval($dev["cantidad_recibida"]);
                $aux[$dev["fecha"]][] = $a;
            }
            foreach ($ajustes as $pos => $dev){
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha"]));
                $a["descripcion"] = "Ajuste Manual: " . $dev["observaciones"];
                $a["impacto"] = $dev["impacto"];
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
            foreach ($producido as $pos => $dev){
                if ($dev["cantidad"] <= 0){
                    continue;
                }
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha_m"]));
                $a["descripcion"] = "Producción Diaria" . " ( $ " . number_format($dev["costo_unitario"] * $dev["cantidad"],2) . ") ";
                $a["impacto"] = 1;
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
            foreach ($producido_terminado as $pos => $dev){
                if ($dev["cantidad"] <= 0){
                    continue;
                }
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha_m"]));
                $a["descripcion"] = "Producción Diaria";
                $a["impacto"] = 1;
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
            foreach ($ventas_entregadas_otro as $pos => $dev){
                if ($dev["cantidad"] <= 0){
                    continue;
                }
                $a = [];
                $a["fecha"] = date("d/m/Y", strtotime($dev["fecha"]));
                $a["descripcion"] = "Entrega a cliente" . " ( $ " . number_format($dev["costo_unitario"],2) . ") ";;
                $a["impacto"] = -1;
                $a["cantidad"] += floatval($dev["cantidad"]);
                $aux[$dev["fecha"]][] = $a;
            }
        }
        ksort($aux);
        $registros              = $aux;        
        $_SESSION['registros']  = $registros;
        include $_SERVER['DOCUMENT_ROOT']."/VICA/templates/movstocks.busqueda.template.php";      
        
    }
    
    public function getStock($codigo) {
        $devuelve = $this->conn->getStock($codigo);
        
        return json_encode($devuelve[0]);
        
    }
    
    public function getMotivos() {
        $devuelve = $this->conn->getMotivos();
        return $devuelve;        
    }
    
    public function getProductos() {
        $devuelve = $this->conn->getProductos();
        return $devuelve;        
    }
    
    public function addRegistro($impacto,$fecha,$producto,$cantidad,$motivo,$tipodeuso,$tipoproducto) {
        $devuelve = $this->conn->addRegistro($impacto,$fecha,$producto,$cantidad,$motivo,$tipodeuso,$tipoproducto);
        return $devuelve;        
    }
}
