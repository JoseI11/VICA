<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class OrdenComprasModel {
    private static $instancia;
    
    private $conn;

    public function __construct() {
        try {                
            $this->conn = Conexion::singleton_conexion();
        } catch ( Exception $e ) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_orden_compras() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountOrdenCompras(){
        try {
            $sql = "SELECT count(*) FROM orden_compras;";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result[0];
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }
    
    public function getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda){
        try {
            $desde = ($pagina - 1) * $registros;
            $sql = "SELECT *, 
            (select descripcion from personas where codigo = cod_proveedor) as proveedor,
            (select descripcion from orden_compras_estados where codigo = cod_orden_compra_estado) as estado
            FROM orden_compras WHERE observaciones like '%" . $busqueda . "%' ORDER BY " . $orderby . " " . $sentido;
            if (intval($registros) > 0){
                $sql_limit = $sql . " limit " . $desde . "," . $registros . ";";
            } else {
                $sql_limit = $sql ;
            }
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                $_SESSION["totales"] = count($result);
            }
            $query = $this->conn->prepare($sql_limit);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
        
    }
    
    public function deleteOrdenCompra($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_compras where codigo = ? 
            ');
            $stmt->bindValue(1, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function deleteOrdenCompraInsumo($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_compras_detalles where codigo = ? 
            ');
            $stmt->bindValue(1, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function addOrdenCompra($fecha, $proveedor, $observaciones){
        $hoy = date("Y-m-d H:i:s");
        try {
            $estado = 1;
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO orden_compras (observaciones, cod_proveedor, fecha, cod_orden_compra_estado, usuario_m, fecha_m) VALUES (?,?,?,?,?,?);');
            $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
            $stmt->bindValue(2, $proveedor, PDO::PARAM_INT);
            $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
            $stmt->bindValue(4, $estado, PDO::PARAM_INT);
            $stmt->bindValue(5, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(6, $hoy, PDO::PARAM_STR);
            
            if($stmt->execute()){
                $this->conn->commit();
                $sql = "SELECT max(codigo) as maximo FROM orden_compras;";
                $query = $this->conn->prepare($sql);
                $query->execute();
                if ($query->rowCount() > 0) {
                    $result = $query->fetchAll();
                    return $result[0]["maximo"];
                }
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function addOrdenCompraInsumo($orden_compra, $insumo, $cantidad, $precio){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE componentes SET costo_unitario = ? where codigo = ?;');
            $stmt->bindValue(1, $precio, PDO::PARAM_STR);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->execute();
    
            $stmt = $this->conn->prepare('INSERT INTO orden_compras_detalles (cod_orden_compra, cod_componente, cantidad, precio, usuario_m, fecha_m) VALUES (?,?,?,?,?,?);');
            $stmt->bindValue(1, $orden_compra, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $precio, PDO::PARAM_STR);
            $stmt->bindValue(5, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(6, $hoy, PDO::PARAM_STR);
            
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function editOrdenCompra($codigo, $datos){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_compras set '
                                            . 'observaciones = ? , '
                                            . 'fecha = ? , '
                                            . 'cod_proveedor = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindValue(2, $datos["fecha"], PDO::PARAM_STR);
            $stmt->bindValue(3, $datos["proveedor"], PDO::PARAM_INT);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(6, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function editOrdenCompraRec($codigo, $datos){
        $hoy = date("Y-m-d H:i:s");
        if (!$datos["estimado"]) $datos["estimado"] = null;
        if (!$datos["recepcion"]) $datos["recepcion"] = null;
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_compras set '
                                            . 'fecha_estimada_recepcion = ? , '
                                            . 'fecha_recepcion = ? , '
                                            . 'remito = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $datos["estimado"], PDO::PARAM_STR);
            $stmt->bindValue(2, $datos["recepcion"], PDO::PARAM_STR);
            $stmt->bindValue(3, $datos["remito"], PDO::PARAM_STR);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(6, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function cambiarEstadoOrdenCompra($codigo, $estado){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_compras set '
                                            . 'cod_orden_compra_estado = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $estado, PDO::PARAM_INT);
            $stmt->bindValue(2, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(3, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(4, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function updateOrdenCompra($codigo, $descripcion, $insumo, $unidad){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_compras set '
                                            . 'descripcion = ? , '
                                            . 'cod_unidad = ? , '
                                            . 'es_insumo = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(2, $unidad, PDO::PARAM_INT);
            $stmt->bindValue(3, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(6, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function updateOrdenCompraInsumo($codigo, $orden_compra, $insumo, $cantidad, $precio){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            
            $stmt = $this->conn->prepare('UPDATE componentes SET costo_unitario = ? where codigo = ?;');
            $stmt->bindValue(1, $precio, PDO::PARAM_STR);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->conn->prepare('UPDATE orden_compras_detalles set '
                                            . 'cod_orden_compra = ? , '
                                            . 'cod_componente = ? , '
                                            . 'cantidad = ? , '
                                            . 'precio = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');    
            $stmt->bindValue(1, $orden_compra, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $precio, PDO::PARAM_STR);
            $stmt->bindValue(5, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(6, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(7, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function updateOrdenCompraInsumoRec($codigo, $orden_compra, $recibido){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_compras_detalles set '
                                            . 'cantidad_recibida = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');    
            $stmt->bindValue(1, $recibido, PDO::PARAM_STR);
            $stmt->bindValue(2, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(3, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(4, $codigo, PDO::PARAM_INT);
            if($stmt->execute()){
                $this->conn->commit();
                return 0;
            }  else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch(PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    
    public function getOrdenCompra($codigo){
        try {
            $sql = "SELECT * FROM orden_compras WHERE codigo = " . $codigo . ";";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
    
    public function getOrdenCompraInsumo($codigo){
        try {
            $sql = "SELECT * FROM orden_compras_detalles WHERE codigo = " . $codigo . ";";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
    
    public function getUnidades(){
        try {
            $sql = "SELECT * FROM unidades order by descrip_abrev;";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
    
    public function getProveedores(){
        try {
            $sql = "SELECT * FROM personas where proveedor = 1 order by descripcion;";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
    
    public function getOrdenComprasCategorias(){
        try {
            $sql = "SELECT * FROM orden_compras_categorias order by descripcion;";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
    
    public function getInsumos(){
        try {
            $sql = "SELECT * FROM componentes where es_insumo in (0,1) order by descripcion;";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
    
    public function getDetallesAsociados($cod_orden_compra){
        try {
            $sql = "SELECT codigo, cod_componente, cantidad, precio, cantidad_recibida, 
            (select descripcion from componentes where codigo = cod_componente) as insumo, 
            (select es_usado from componentes where codigo = cod_componente) as es_usado
            FROM orden_compras_detalles where cod_orden_compra = " . intval($cod_orden_compra) . " order by insumo;";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
}	
?>