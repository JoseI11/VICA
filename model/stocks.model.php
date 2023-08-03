<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once $_SERVER['DOCUMENT_ROOT'] . "/VICA/bd/conexion.php";

class StocksModel
{
    private static $instancia;

    private $conn;

    public function __construct()
    {
        try {
            $this->conn = Conexion::singleton_conexion();
        } catch (Exception $e) {
            $error = "Error!: " . $e->getMessage();
            return $error;
        }
    }

    public static function singleton_stocks()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function getCountStocks()
    {
        try {
            $sql = "SELECT count(*) FROM stocks;";
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

    public function getMotivos()
    {
        try {
            $sql = "SELECT * FROM ajustes_motivos order by descripcion;";
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

    public function getRegistrosFiltroMaquina($orderby, $sentido, $registros, $pagina, $busqueda, $componente, $tipouso, $tipoinsumo)
    {
        try {
            //usar un if para filtrar si es nuevo o usado y tipo

            $desde = ($pagina - 1) * $registros;
            $sql = "SELECT 
                        productos.*,
                        (select ci.observaciones from ajustes ci where ci.cod_ajuste_motivo = 1 and ci.cod_maquina = productos.codigo) as inicial,
                        DATE_FORMAT(productos.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
                    FROM 
                        maquinas productos
                    WHERE
                        codigo > 0 and
                        codigo =" . intval($componente) . " ";
            // && es_usado =" .$tipouso." && es_insumo=".$tipoinsumo.""
            $sql_limit = $sql;
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

    public function getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda, $componente, $tipouso, $tipoinsumo)
    {
        try {
            //usar un if para filtrar si es nuevo o usado y tipo

            $desde = ($pagina - 1) * $registros;
            $sql = "SELECT 
                        productos.*,
                        (select ci.observaciones from ajustes ci where ci.cod_ajuste_motivo = 1 and ci.cod_componente = productos.codigo) as inicial,
                        DATE_FORMAT(productos.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
                    FROM 
                        componentes productos
                    WHERE
                        codigo > 0 and
                        codigo =" . intval($componente) . " ";
            // && es_usado =" .$tipouso." && es_insumo=".$tipoinsumo.""
            $sql_limit = $sql;
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

    public function getStock($codigo)
    {
        try {
            $sql = "SELECT * FROM stocks WHERE codigo = " . $codigo . ";";
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

    public function getAjustesMaquinas($cod_producto,$tipo,$insumo)
    {
        try {
            $sql = "SELECT 
                        a.*,
                        am.impacto,
                        DATE_FORMAT(a.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
                    FROM 
                        ajustes a,
                        ajustes_motivos am
                    WHERE
                        a.cod_ajuste_motivo = am.codigo and
                        a.cod_ajuste_motivo != 1  and 
                        a.cod_maquina = " . intval($cod_producto) . " ";
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

    public function getAjustes($cod_producto,$tipo,$insumo)
    {
        try {
            $sql = "SELECT 
                        a.*,
                        am.impacto,
                        DATE_FORMAT(a.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
                    FROM 
                        ajustes a,
                        ajustes_motivos am
                    WHERE
                        a.cod_ajuste_motivo = am.codigo and
                        a.cod_ajuste_motivo != 1  and 
                        a.cod_componente = " . intval($cod_producto) . " ";
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

    public function getVentas($cod_producto)
    {
        try {
            $sql = "SELECT 
                        v.*,
                        1 as cantidad,
                        p.descripcion as persona,
                        DATE_FORMAT(v.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
                    FROM 
                        orden_ventas v,
                        personas p
                    WHERE
                        v.cod_orden_venta_estado_general = 4 and
                        v.cod_cliente = p.codigo and
                        v.cod_maquina = " . intval($cod_producto) . " ";
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

    public function getVentasEntregadasOtro($cod_producto)
    {
        try {
            $sql = "SELECT 
                        v.*,
                        vc.cantidad as cantidad,
                        vc.costo_unitario as costo_unitario,
                        p.descripcion as persona,
                        DATE_FORMAT(v.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
                    FROM 
                        orden_ventas v,
                        orden_venta_componentes vc,
                        personas p
                    WHERE
                        vc.cod_orden_venta = v.codigo and
                        v.cod_orden_venta_estado_entrega = 7 and
                        v.cod_cliente = p.codigo and
                        v.cod_componente = " . intval($cod_producto) . " ";
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

    public function getVentasEntregadas($cod_producto)
    {
        try {
            $sql = "SELECT 
                        v.*,
                        1 as cantidad,
                        p.descripcion as persona,
                        DATE_FORMAT(v.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
                    FROM 
                        orden_ventas v,
                        personas p
                    WHERE
                        v.cod_orden_venta_estado_entrega = 7 and
                        v.cod_cliente = p.codigo and
                        v.cod_maquina = " . intval($cod_producto) . " ";
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

    public function getCompras($cod_producto)
    {
        try {
            $sql = "SELECT 
                        dc.*,
                        p.descripcion as persona,
                        c.fecha
                    FROM 
                        orden_compras c,
                        orden_compras_detalles dc,
                        personas p
                    WHERE
                        c.cod_orden_compra_estado = 3 and
                        c.cod_proveedor = p.codigo and
                        c.codigo = dc.cod_orden_compra and 
                        dc.cod_componente = " . intval($cod_producto) . " ";
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

    public function getProducido($cod_producto)
    {
        try {
            $sql = "SELECT 
                        dc.*,
                        c.fecha_programada_entrega as fecha
                    FROM 
                        orden_trabajo c,
                        orden_trabajo_componentes dc
                    WHERE
                        c.cod_orden_trabajo_estado = 3 and
                        c.codigo = dc.cod_orden_trabajo and 
                        dc.cod_componente = " . intval($cod_producto) . " ";
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

    public function getProducidoTerminado($cod_producto)
    {
        try {
            $sql = "SELECT 
                        c.*,
                        c.fecha_programada_entrega as fecha,
                        v.cantidad as cantidad
                    FROM 
                        orden_trabajo c
                    LEFT JOIN orden_ventas v ON c.cod_orden_venta = v.codigo
                    WHERE
                        c.cod_orden_trabajo_estado = 3 and
                        c.cod_componente = " . intval($cod_producto) . " ";
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

    public function getProducidoTerminadoMaquina($cod_producto)
    {
        try {
            $sql = "SELECT 
                        c.*,
                        c.fecha_programada_entrega as fecha,
                        1 as cantidad
                    FROM 
                        orden_trabajo c
                    WHERE
                        c.cod_orden_trabajo_estado = 3 and
                        c.cod_maquina = " . intval($cod_producto) . " ";
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

    public function getProductos()
    {
        try {
            
            $sql="SELECT c.codigo,c.descripcion, DATE_FORMAT(c.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif,c.costo_unitario,c.precio_unitario,c.es_insumo,c.es_usado FROM componentes c  UNION SELECT m.codigo, m.descripcion,DATE_FORMAT(m.fecha_m,'%Y-%m-%d %H:%i:%s') as fecha_modif,m.costo_unitario,m.precio_unitario,m.es_insumo,m.es_usado FROM maquinas m ";
            
            
            //$sql = "SELECT c.codigo,c.descripcion, DATE_FORMAT(c.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif,c.costo_unitario,c.precio_unitario,c.es_insumo,c.es_usado FROM componentes c UNION SELECT m.codigo, m.descripcion,DATE_FORMAT(m.fecha_m,'%Y-%m-%d %H:%i:%s') as fecha_modif,m.costo_unitario,m.precio_unitario,m.es_insumo,m.es_usado FROM maquinas m";
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
    public function getProductos2()
    {
        try {
            
            //SELECT c.codigo,c.descripcion, DATE_FORMAT(c.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif,c.costo_unitario,c.precio_unitario,c.es_insumo,c.es_usado FROM componentes c UNION SELECT m.codigo, m.descripcion,DATE_FORMAT(m.fecha_m,'%Y-%m-%d %H:%i:%s') as fecha_modif,m.costo_unitario,m.precio_unitario,m.es_insumo,m.es_usado FROM maquinas m;
           /* $sql = "SELECT 
            *,
            DATE_FORMAT(fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif
        FROM 
            componentes
        ORDER BY
            descripcion;";*/
      
                $sql="SELECT c.codigo,c.descripcion, DATE_FORMAT(c.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif,c.costo_unitario,c.precio_unitario,c.es_insumo,c.es_usado FROM componentes c";
         
                //$sql="SELECT m.codigo, m.descripcion,DATE_FORMAT(m.fecha_m,'%Y-%m-%d %H:%i:%s') as fecha_modif,m.costo_unitario,m.precio_unitario,m.es_insumo,m.es_usado FROM maquinas m ";
            
           
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
    public function addRegistro($impacto, $fecha, $producto, $cantidad, $motivo, $tipodeuso, $tipoproducto)
    {
        $hoy = date("Y-m-d");
        $ahora = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO ajustes (fecha, cod_componente, cod_ajuste_motivo, cantidad, es_usado, tipo_producto, observaciones, usuario_m, fecha_m) VALUES (?,?,?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $fecha, PDO::PARAM_STR);
            $stmt->bindValue(2, $producto, PDO::PARAM_INT);
            $stmt->bindValue(3, $impacto, PDO::PARAM_INT);
            $stmt->bindValue(4, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(5, $tipodeuso, PDO::PARAM_INT);
            $stmt->bindValue(6, $tipoproducto, PDO::PARAM_INT);
            $stmt->bindValue(7, $motivo, PDO::PARAM_STR);
            $stmt->bindValue(8, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(9, $ahora, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $this->conn->commit();
                return 0;
            } else {
                $this->conn->rollBack();
                return var_dump($stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
}
