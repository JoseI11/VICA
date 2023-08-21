<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class OrdenTrabajosModel {
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

    public static function singleton_orden_trabajos() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountOrdenTrabajos(){
        try {
            $sql = "SELECT count(*) FROM orden_trabajo;";
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
            (select descripcion from componentes where codigo = orden_trabajo.cod_componente) as producto,
            (select descripcion from maquinas where codigo = orden_trabajo.cod_maquina) as maquina,
            (select descripcion from orden_trabajo_estados where codigo = cod_orden_trabajo_estado) as estado,
            (select cod_orden_venta_tipo from orden_ventas where codigo = cod_orden_venta) as cod_orden_venta_tipo
            FROM orden_trabajo WHERE observaciones like '%" . $busqueda . "%' ORDER BY " . $orderby . " " . $sentido;
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
    
    public function deleteOrdenTrabajo($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_trabajo where codigo = ? 
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
    
    public function deleteOrdenTrabajoInsumo($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_trabajo_componentes where codigo = ? 
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

    public function deleteDetalleTrabajoInsumo($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from ud_ordentrabajodetalle where id = ? 
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

    public function deleteCorreasTrabajoInsumo($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from ud_ordentrabajocorreas where id = ? 
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

    public function deleteTransmisionTrabajoInsumo($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from ud_ordentrabajotransmision where id = ? 
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
    
    public function deleteOtPersona($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_trabajo_personas where codigo = ? 
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
    
    public function addOrdenTrabajo($fecha, $cliente, $producto, $observaciones, $id_cajaquebrado,$id_cajaquebrado2, $id_sinfin, $id_motor, $personal_ot){
        $hoy = date("Y-m-d H:i:s");
        $ov = $this->getVenta($producto)[0];
        try {
            $estado = 1;
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO orden_trabajo (observaciones, cliente, fecha_programada_entrega, cod_orden_trabajo_estado, cod_componente, cod_maquina, cod_orden_venta, version,  usuario_m, fecha_m,id_cajaquebrados,id_cajaquebrados2,id_sinfin,id_motor,personal_ot) VALUES (?,?,?,?,?,?,?,0,?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
            $stmt->bindValue(2, $cliente, PDO::PARAM_STR);
            $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
            $stmt->bindValue(4, $estado, PDO::PARAM_INT);
            $stmt->bindValue(5, $ov["cod_componente"], PDO::PARAM_INT);
            $stmt->bindValue(6, $ov["cod_maquina"], PDO::PARAM_INT);
            $stmt->bindValue(7, $ov["codigo"], PDO::PARAM_INT);
            $stmt->bindValue(8, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(9, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(10, $id_cajaquebrado, PDO::PARAM_INT);
            $stmt->bindValue(11, $id_cajaquebrado2, PDO::PARAM_INT);
            $stmt->bindValue(12, $id_sinfin, PDO::PARAM_INT);
            $stmt->bindValue(13, $id_motor, PDO::PARAM_INT);
            $stmt->bindValue(14, $personal_ot,PDO::PARAM_STR);
            
            if($stmt->execute()){
                $this->conn->commit();
                $sql = "SELECT max(codigo) as maximo FROM orden_trabajo;";
                $query = $this->conn->prepare($sql);
                $query->execute();
                if ($query->rowCount() > 0) {
                    $result = $query->fetchAll();
                    return $result[0]["maximo"];
                }

                if ($id_cajaquebrado != 0){
                    $caj = $this->getInsumosAsociados($id_cajaquebrado);
					foreach($caj as $ins){
                    //$precio = floatval($this->conn->getComponente($ins["cod_insumo"])[0]["costo_unitario"]);cod_insumo, cantidad
                             
                     }

            }

            if ($id_cajaquebrado2 != 0){
                $caj = $this->getInsumosAsociados($id_cajaquebrado2);
                foreach($caj as $ins){
                //$precio = floatval($this->conn->getComponente($ins["cod_insumo"])[0]["costo_unitario"]);cod_insumo, cantidad
                         
                 }

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

    public function addOrdenTrabajo2($option){
        try {
            $sql = "SELECT CONCAT('Obs: ',observaciones) as observaciones,
             CONCAT('Cantidad: ',COALESCE(cantidad,'Null'), ' - Fecha Entrega: ', COALESCE(fecha_entrega_maquina,'Null')) as observaciones2 FROM orden_ventas where codigo = " . $option . ";";
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

  
    public function addOrdenTrabajoPersona($orden_trabajo, $categoria, $persona){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO orden_trabajo_personas (cod_ot, cod_comp_cat, cod_persona, usuario_m, fecha_m) VALUES (?,?,?,?,?);');
            $stmt->bindValue(1, $orden_trabajo, PDO::PARAM_INT);
            $stmt->bindValue(2, $categoria, PDO::PARAM_INT);
            $stmt->bindValue(3, $persona, PDO::PARAM_STR);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            
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
    
    public function addOrdenTrabajoInsumo($orden_trabajo, $insumo, $cantidad, $precio, $precio_usd){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO orden_trabajo_componentes (cod_orden_trabajo, cod_componente, cantidad, costo_unitario, costo_unitario_usd, usuario_m, fecha_m) VALUES (?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $orden_trabajo, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $precio, PDO::PARAM_STR);
            $stmt->bindValue(5, $precio_usd, PDO::PARAM_STR);
            $stmt->bindValue(6, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(7, $hoy, PDO::PARAM_STR);
            
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
    
    public function addDetalleOt($orden_trabajo, $empleado, $detalle){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO ud_ordentrabajodetalle (id_ordentrabajo, id_empleado, detalle, usuario_m, fecha_m) VALUES (?,?,?,?,?);');
            $stmt->bindValue(1, $orden_trabajo, PDO::PARAM_INT);
            $stmt->bindValue(2, $empleado, PDO::PARAM_INT);
            $stmt->bindValue(3, $detalle, PDO::PARAM_STR);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            
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

    public function addCorreasOt($orden_trabajo, $empleado, $detalle){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO ud_ordentrabajocorreas (id_ordentrabajo, id_empleado, detalle, usuario_m, fecha_m) VALUES (?,?,?,?,?);');
            $stmt->bindValue(1, $orden_trabajo, PDO::PARAM_INT);
            $stmt->bindValue(2, $empleado, PDO::PARAM_INT);
            $stmt->bindValue(3, $detalle, PDO::PARAM_STR);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            
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

    public function addTransmisionOt($orden_trabajo, $empleado, $detalle){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO ud_ordentrabajotransmision (id_ordentrabajo, id_empleado, detalle, usuario_m, fecha_m) VALUES (?,?,?,?,?);');
            $stmt->bindValue(1, $orden_trabajo, PDO::PARAM_INT);
            $stmt->bindValue(2, $empleado, PDO::PARAM_INT);
            $stmt->bindValue(3, $detalle, PDO::PARAM_STR);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            
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
    

    public function updateOrdenTrabajoPersona($codigo, $categoria, $persona){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_trabajo_personas set '
            . 'cod_comp_cat = ? , '
            . 'cod_persona = ? , '
            . 'usuario_m = ?, '
            . 'fecha_m = ? '
            . ' where codigo = ?');            
            $stmt->bindValue(1, $categoria, PDO::PARAM_INT);
            $stmt->bindValue(2, $persona, PDO::PARAM_INT);
            $stmt->bindValue(3, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(4, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(5, $codigo, PDO::PARAM_INT);
            
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
    
    public function updateOrdenTrabajoTarea($codigo, $orden_venta, $cantidad, $observaciones){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            
            $stmt = $this->conn->prepare('DELETE from orden_trabajo_detalles where cod_orden_venta = ? and cod_orden_trabajo_categoria = ? ');
            $stmt->bindValue(1, $orden_venta, PDO::PARAM_INT);
            $stmt->bindValue(2, $codigo, PDO::PARAM_INT);
            $stmt->execute();

            $stmt = $this->conn->prepare('INSERT INTO orden_trabajo_detalles (cod_orden_venta, cod_orden_trabajo_categoria, valor, observaciones, usuario_m, fecha_m) VALUES (?,?,?,?,?,?);');
            $stmt->bindValue(1, $orden_venta, PDO::PARAM_INT);
            $stmt->bindValue(2, $codigo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $observaciones, PDO::PARAM_STR);
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
    
    public function editOrdenTrabajo($codigo, $datos){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_trabajo set '
                                            . 'observaciones = ? , '
                                            . 'fecha_programada_entrega = ? , '
                                            . 'fecha_pintura = ? , '
                                            . 'observaciones_pintura = ? , '
                                            . 'personal_pintura = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ?, '
                                            . 'sinfin_detalle = ?, '
                                            . 'sinfin_seguimiento = ?, '
                                            . 'motor_detalle = ?, '
                                            . 'motor_seguimiento = ?, '
                                            . 'sinfin_empleado = ?, '
                                            . 'cajaquebrado_detalle = ?, '
                                            . 'cajaquebrado_seguimiento = ?, '
                                            . 'cajaquebrado_empleado = ?, '
                                            . 'cajaquebrado_detalle2 = ?, '
                                            . 'cajaquebrado_seguimiento2 = ?, '
                                            . 'cajaquebrado_empleado2 = ?, '
                                            . 'personal_ot = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindValue(2, $datos["fecha_programada_entrega"], PDO::PARAM_STR);
            $stmt->bindValue(3, $datos["fecha_pintura"], PDO::PARAM_STR);
            $stmt->bindValue(4, $datos["observaciones_pintura"], PDO::PARAM_STR);
            $stmt->bindValue(5, $datos["personal_pintura"], PDO::PARAM_STR);
            $stmt->bindValue(6, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(7, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(8, $datos["sinfinDetalle"], PDO::PARAM_STR);
            $stmt->bindValue(9, $datos["sinfinSeguimiento"], PDO::PARAM_STR);
            $stmt->bindValue(10, $datos["motorDetalle"], PDO::PARAM_STR);
            $stmt->bindValue(11, $datos["motorSeguimiento"], PDO::PARAM_STR);
            $stmt->bindValue(12, $datos["sinfinpersonaAdd"], PDO::PARAM_STR);
            $stmt->bindValue(13, $datos["cajaquebradoDetalle"], PDO::PARAM_STR);
            $stmt->bindValue(14, $datos["cajaquebradoSeguimiento"], PDO::PARAM_STR);
            $stmt->bindValue(15, $datos["cajaquebradopersonaAdd"], PDO::PARAM_STR);
            $stmt->bindValue(16, $datos["cajaquebradoDetalle2"], PDO::PARAM_STR);
            $stmt->bindValue(17, $datos["cajaquebradoSeguimiento2"], PDO::PARAM_STR);
            $stmt->bindValue(18, $datos["cajaquebradopersona2Add"], PDO::PARAM_STR);
            $stmt->bindValue(19, $datos["personal_ot"], PDO::PARAM_STR);
            $stmt->bindValue(20, $codigo, PDO::PARAM_INT);
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
    
    public function editOrdenTrabajoRec($codigo, $datos){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_trabajo set '
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
    
    public function cambiarEstadoOrdenTrabajo($codigo, $estado){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            if ($estado == 1) {
                $sql = 'UPDATE orden_trabajo set '
                . 'cod_orden_trabajo_estado = ? , '
                . 'version = version + 1 , '
                . 'usuario_m = ?, '
                . 'fecha_m = ? '
                . ' where codigo = ?';
            } else {
                $sql = 'UPDATE orden_trabajo set '
                . 'cod_orden_trabajo_estado = ? , '
                . 'usuario_m = ?, '
                . 'fecha_m = ? '
                . ' where codigo = ?';
            }
            $stmt = $this->conn->prepare($sql);            
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
    
    public function updateOrdenTrabajo($codigo, $fecha, $cliente, $producto, $observaciones){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_trabajo set '
                                            . 'observaciones = ? , '
                                            . 'cliente = ? , '
                                            . 'fecha_programada_entrega = ? , '
                                            . 'cod_componente = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
            $stmt->bindValue(2, $cliente, PDO::PARAM_STR);
            $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
            $stmt->bindValue(4, $producto, PDO::PARAM_INT);
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
    
    public function updateOrdenTrabajoInsumo($codigo, $orden_trabajo, $insumo, $cantidad, $precio, $precio_usd){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_trabajo_componentes set '
                                            . 'cod_orden_trabajo = ? , '
                                            . 'cod_componente = ? , '
                                            . 'cantidad = ? , '
                                            . 'costo_unitario = ? , '
                                            . 'costo_unitario_usd = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');    
            $stmt->bindValue(1, $orden_trabajo, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $precio, PDO::PARAM_STR);
            $stmt->bindValue(5, $precio_usd, PDO::PARAM_STR);
            $stmt->bindValue(6, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(7, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(8, $codigo, PDO::PARAM_INT);
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

    public function updateDetalleTrabajoInsumo($codigo, $id_empleado, $detalle){
      //$detalle="hola";
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE ud_ordentrabajodetalle set '
                                            . 'id_empleado = ? , '
                                            . 'detalle = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where id = ?');    
            $stmt->bindValue(1, $id_empleado, PDO::PARAM_INT);
            $stmt->bindValue(2, $detalle, PDO::PARAM_STR);
            $stmt->bindValue(3, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(4, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(5, $codigo, PDO::PARAM_INT);
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

    public function updateCorreasTrabajoInsumo($codigo, $id_empleado, $detalle){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE ud_ordentrabajocorreas set '
                                            . 'id_empleado = ? , '
                                            . 'detalle = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where id = ?');    
            $stmt->bindValue(1, $id_empleado, PDO::PARAM_INT);
            $stmt->bindValue(2, $detalle, PDO::PARAM_STR);
            $stmt->bindValue(3, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(4, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(5, $codigo, PDO::PARAM_INT);
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

   

    public function updateTransmisionTrabajoInsumo($codigo, $id_empleado, $detalle){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE ud_ordentrabajotransmision set '
                                            . 'id_empleado = ? , '
                                            . 'detalle = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where id = ?');    
            $stmt->bindValue(1, $id_empleado, PDO::PARAM_INT);
            $stmt->bindValue(2, $detalle, PDO::PARAM_STR);
            $stmt->bindValue(3, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(4, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(5, $codigo, PDO::PARAM_INT);
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

    
    public function updateOrdenTrabajoInsumoRec($codigo, $orden_trabajo, $recibido){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_trabajo_detalles set '
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
    
    public function getOrdenVenta($codigo){
        try {
            $sql = "SELECT * FROM orden_ventas WHERE codigo = " . $codigo . ";";
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
    
    public function getOrdenTrabajo($codigo){
        try {
            //$sql = "SELECT * FROM orden_trabajo WHERE codigo = " . $codigo . ";";
            $sql="SELECT orden_trabajo.*, com1.descrip_abrev as codigo_sinfin, com1.descripcion as dimension_sinfin, per1.descripcion as empleado_sinfin,
            com2.descrip_abrev as codigo_cajaquebrado, com2.descripcion as dimension_cajaquebrado, com4.descrip_abrev as codigo_cajaquebrado2, com4.descripcion as dimension_cajaquebrado2, per2.descripcion as empleado_cajaquebrado, per3.descripcion as empleado_cajaquebrado2,
            com3.descrip_abrev as codigo_motor, com3.descripcion as dimension_motor
            FROM orden_trabajo
            LEFT JOIN maquinas com1 ON orden_trabajo.id_sinfin = com1.codigo
            LEFT JOIN maquinas com2 ON orden_trabajo.id_cajaquebrados = com2.codigo
            LEFT JOIN maquinas com3 ON orden_trabajo.id_motor = com3.codigo
            LEFT JOIN maquinas com4 ON orden_trabajo.id_cajaquebrados2 = com4.codigo
            LEFT JOIN personas per1 ON orden_trabajo.sinfin_empleado = per1.codigo
            LEFT JOIN personas per2 ON orden_trabajo.cajaquebrado_empleado = per2.codigo
            LEFT JOIN personas per3 ON orden_trabajo.cajaquebrado_empleado2 = per3.codigo
            WHERE orden_trabajo.codigo = " . $codigo . ";";
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
    
    public function getOtPersona($codigo, $cod_ov){
        try {
            $sql = "SELECT * FROM orden_trabajo_personas WHERE codigo = " . $codigo . " ;";
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
    
    public function getTarea($codigo, $cod_ov){
        try {
            $sql = "SELECT * FROM orden_trabajo_detalles WHERE cod_orden_trabajo_categoria = " . $codigo . " and cod_orden_venta = " . $cod_ov . ";";
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
    
    public function getOrdenTrabajoInsumo($codigo){
        try {
            $sql = "SELECT * FROM orden_trabajo_componentes WHERE codigo = " . $codigo . ";";
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

    public function getDetalleTrabajoInsumo($codigo){
        try {
            $sql = "SELECT * FROM ud_ordentrabajodetalle WHERE id = " . $codigo . ";";
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

    public function getDetalleTrabajoPdf($codigo){
        try {
            $sql = "SELECT udo.*, per.descripcion as empleado
            FROM ud_ordentrabajodetalle udo 
            LEFT JOIN personas per ON udo.id_empleado = per.codigo 
            WHERE id_ordentrabajo = " . $codigo . ";";
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

    public function getPoleaTrabajoPdf($codigo){
        try {
            $sql = "SELECT udo.*, per.descripcion as empleado
            FROM ud_ordentrabajocorreas udo 
            LEFT JOIN personas per ON udo.id_empleado = per.codigo 
            WHERE id_ordentrabajo = " . $codigo . ";";
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

    public function getTransmisionTrabajoPdf($codigo){
        try {
            $sql = "SELECT udo.*, per.descripcion as empleado
            FROM ud_ordentrabajotransmision udo 
            LEFT JOIN personas per ON udo.id_empleado = per.codigo 
            WHERE id_ordentrabajo = " . $codigo . ";";
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

    public function getCorreasTrabajoInsumo($codigo){
        try {
            $sql = "SELECT * FROM ud_ordentrabajocorreas WHERE id = " . $codigo . ";";
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

    public function getTransmisionTrabajoInsumo($codigo){
        try {
            $sql = "SELECT * FROM ud_ordentrabajotransmision WHERE id = " . $codigo . ";";
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
    
    public function getTareas(){
        try {
            $sql = "SELECT * FROM orden_trabajo_categorias order by nombre;";
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
    
    public function getTareasRealizadas($cod_ov){
        try {
            $sql = "SELECT * FROM orden_trabajo_detalles where cod_orden_venta = " . intval($cod_ov) . ";";
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
    
    public function getClientes(){
        try {
            $sql = "SELECT * FROM personas where cliente = 1 order by descripcion;";
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
    
    public function getCategoriasComponentes(){ 
        try {
            $sql = "SELECT * FROM componentes_categorias order by descripcion;";
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
    
    public function getPersonasOt($cod_ot){ 
        try {
            $sql = "SELECT * FROM orden_trabajo_personas where cod_ot = " . $cod_ot . " order by codigo;";
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
    
    public function getPersonas(){ 
        try {
            $sql = "SELECT * FROM personas where empleado = 1 order by descripcion;";
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
    
    public function getMaquinas(){
        try {
            $sql = "SELECT * FROM maquinas order by descripcion;";
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
    
    public function getProductos(){
        try {
            $sql = "SELECT * FROM componentes where es_insumo = 0 order by descripcion;";
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
    
    public function getDetallesAsociados($cod_orden_trabajo){
        try {
            $sql = "SELECT orden_trabajo_componentes.*, 
            (select descripcion from componentes where codigo = cod_componente) as insumo,
            (select codigo_mp from componentes where codigo = cod_componente) as codigo_mp,
            (select dimension from componentes where codigo = cod_componente) as dimension
            FROM orden_trabajo_componentes where cod_orden_trabajo = " . intval($cod_orden_trabajo) . " order by insumo;";
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

    public function getDetallesAsociados2($cod_orden_trabajo){
        try {
            $sql="SELECT id, id_ordentrabajo, P.descripcion, UDO.detalle, UDO.fecha_m
            FROM ud_ordentrabajodetalle UDO
            LEFT JOIN personas P ON UDO.ID_EMPLEADO = P.CODIGO
            WHERE UDO.id_ordentrabajo = " . intval($cod_orden_trabajo) . "
            ORDER BY fecha_m;";
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

    public function getDetallesAsociados3($cod_orden_trabajo){
        try {
            $sql="SELECT id, id_ordentrabajo, P.descripcion, UDO.detalle, UDO.fecha_m
            FROM ud_ordentrabajocorreas UDO
            LEFT JOIN personas P ON UDO.ID_EMPLEADO = P.CODIGO
            WHERE UDO.id_ordentrabajo = " . intval($cod_orden_trabajo) . "
            ORDER BY fecha_m";
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

    public function getDetallesAsociados4($cod_orden_trabajo){
        try {
            $sql="SELECT id, id_ordentrabajo, P.descripcion, UDO.detalle, UDO.fecha_m
            FROM ud_ordentrabajotransmision UDO
            LEFT JOIN personas P ON UDO.ID_EMPLEADO = P.CODIGO
            WHERE UDO.id_ordentrabajo = " . intval($cod_orden_trabajo) . "
            ORDER BY fecha_m";
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

    public function getInsumosAsociados($cod_componente){
        try {
            $sql = "SELECT codigo, cod_insumo, cantidad, 
            (select descripcion from componentes where codigo = cod_insumo) as insumo
            FROM componentes_insumos where cod_componente = " . intval($cod_componente) . " order by insumo;";
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

    public function getInsumosAsociadosMaq($cod_maquina){
        try {
            $sql = "SELECT codigo, cod_componente, cantidad, 
            (select descripcion from componentes where codigo = cod_componente) as insumo
            FROM maquinas_componentes where cod_maquina = " . intval($cod_maquina) . " order by insumo;";
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
    
    public function getComponente($codigo){
        try {
            $sql = "SELECT * FROM componentes WHERE codigo = " . $codigo . ";";
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
    
    public function getVentas(){
        try {
            $sql = "SELECT *, (select descripcion from personas where codigo = orden_ventas.cod_cliente) as cliente
            , (select descripcion from componentes where codigo = orden_ventas.cod_componente) as componente
            , (select descripcion from maquinas where codigo = orden_ventas.cod_maquina) as maquina
            FROM orden_ventas where 1 = 1 order by codigo desc;";
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
    
    public function getVentasPendientesInicio(){
        try {
            $sql = "SELECT *, (select descripcion from personas where codigo = orden_ventas.cod_cliente) as cliente
            , (select descripcion from componentes where codigo = orden_ventas.cod_componente) as componente
            , (select descripcion from maquinas where codigo = orden_ventas.cod_maquina) as maquina
            FROM orden_ventas where cod_orden_venta_estado_general = 2 and cod_orden_venta_tipo in (1,2) and cod_orden_venta_estado_entrega != 7 
            order by codigo desc;";
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
    
    public function getVentasPendientes(){
        try {
            $sql = "SELECT *, (select descripcion from personas where codigo = orden_ventas.cod_cliente) as cliente
            , (select descripcion from componentes where codigo = orden_ventas.cod_componente) as componente
            , (select descripcion from maquinas where codigo = orden_ventas.cod_maquina) as maquina
            FROM orden_ventas where cod_orden_venta_estado_general = 2 and cod_orden_venta_tipo in (1,2) and cod_orden_venta_estado_entrega != 7 
            AND (select max(codigo) from orden_trabajo where cod_orden_venta = orden_ventas.codigo) is null 
            order by codigo desc;";
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

    public function getCajaDeQuebrados(){
        try {
            $sql = "SELECT * from maquinas where cod_maquina_modelo = 9;";
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

    public function getSinFin(){
        try {
            $sql = "SELECT * from maquinas where cod_maquina_modelo = 8;";
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

    public function getMotor(){
        try {
            $sql = "SELECT * from maquinas where cod_maquina_modelo = 10;";
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

    public function getVenta($codigo){
        try {
            $sql = "SELECT *, (select descripcion from personas where codigo = orden_ventas.cod_cliente) as cliente
            , (select descripcion from componentes where codigo = orden_ventas.cod_componente) as componente
            , (select descripcion from componentes where codigo = orden_ventas.cod_componente) as producto
            , (select codigo_mp from componentes where codigo = cod_componente) as producto_codigo_mp
            , (select cc.descripcion from componentes c, componentes_categorias cc where cc.codigo = c.cod_componente_categoria and c.codigo = orden_ventas.cod_componente) as producto_cat
            , (select descripcion from maquinas where codigo = orden_ventas.cod_maquina) as maquina
            , (select descrip_abrev from maquinas where codigo = cod_maquina) as maquina_descrip_abrev
            , (select cc.descripcion from maquinas c, maquinas_modelos cc where cc.codigo = c.cod_maquina_modelo and c.codigo = orden_ventas.cod_maquina) as maquina_cat
            FROM orden_ventas where codigo = " . intval($codigo) . " order by codigo desc;";
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