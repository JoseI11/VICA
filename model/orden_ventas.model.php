<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once $_SERVER['DOCUMENT_ROOT'] . "/VICA/bd/conexion.php";

class OrdenVentasModel
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
        try {
            $sql = "SELECT count(*) FROM orden_ventas;";
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

    public function getRegistrosFiltro($orderby, $sentido, $registros, $pagina, $busqueda)
    {
        try {
            $desde = ($pagina - 1) * $registros;
            $sql = "SELECT *, 
            (select descripcion from personas where codigo = cod_cliente) as cliente,
            (select descripcion from componentes where codigo = cod_componente) as producto,
            (select descripcion from maquinas where codigo = cod_maquina) as maquina,
            (select descripcion from orden_ventas_estados where codigo = cod_orden_venta_estado_general and general = 1) as estado_general,
            (select descripcion from orden_ventas_estados where codigo = cod_orden_venta_estado_entrega and entrega = 1) as estado_entrega,
            (select descripcion from orden_ventas_estados where codigo = cod_orden_venta_estado_cobranza and cobranza = 1) as estado_cobranza,
            (select sum(importe) from orden_ventas_pagos where cod_ov = orden_ventas.codigo) as cobrado_parcial
            FROM orden_ventas WHERE observaciones like '%" . $busqueda . "%' ORDER BY " . $orderby . " " . $sentido;
            if (intval($registros) > 0) {
                $sql_limit = $sql . " limit " . $desde . "," . $registros . ";";
            } else {
                $sql_limit = $sql;
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

    public function deleteOrdenVenta($codigo)
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_ventas where codigo = ? 
            ');
            $stmt->bindValue(1, $codigo, PDO::PARAM_INT);
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

    public function deleteOrdenVentaInsumo($codigo)
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_venta_componentes where codigo = ? 
            ');
            $stmt->bindValue(1, $codigo, PDO::PARAM_INT);
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

    public function deleteOrdenVentaPago($codigo)
    {
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from orden_ventas_pagos where codigo = ? ');
            $stmt->bindValue(1, $codigo, PDO::PARAM_INT);
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

    // public function addOrdenVenta($fecha, $cliente, $pais, $provincia, $producto, $tipoprod, $tipouso, $observaciones, $general, $entrega, $cobranza, $precio, $tipo, $cantidad)
    // {
    //     $hoy = date("Y-m-d H:i:s");
    //     try {
    //         $estado = 1;
    //         $cadena = explode(":", $tipoprod);
    //         //echo $cadena[0];
    //         $this->conn->beginTransaction();
    //         if ($tipoprod == 3 || $tipoprod == 2) {
    //             // echo "Pasa Insumo";
    //             $stmt = $this->conn->prepare('INSERT INTO orden_ventas (observaciones, cod_cliente, fecha, cod_orden_venta_estado_general, cod_orden_venta_estado_entrega, cod_orden_venta_estado_cobranza, cod_maquina, precio_maquina, cod_orden_venta_tipo, cantidad, usuario_m, fecha_m,cod_pais,cod_provincia) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,(SELECT ps.codigo FROM paises ps INNER JOIN personas pr ON ps.codigo=pr.cod_pais WHERE pr.codigo=".$cliente."),(SELECT ps.codigo FROM provincias ps INNER JOIN personas pr ON ps.codigo=pr.cod_provincia WHERE pr.codigo=$cliente));');
    //             $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
    //             $stmt->bindValue(2, $cliente, PDO::PARAM_INT);
    //             $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
    //             $stmt->bindValue(4, $general, PDO::PARAM_INT);
    //             $stmt->bindValue(5, $entrega, PDO::PARAM_INT);
    //             $stmt->bindValue(6, $cobranza, PDO::PARAM_INT);
    //             $stmt->bindValue(7, abs($producto), PDO::PARAM_INT);
    //             $stmt->bindValue(8, $precio, PDO::PARAM_STR);
    //             $stmt->bindValue(9, $tipo, PDO::PARAM_INT);
    //             $stmt->bindValue(10, $cantidad, PDO::PARAM_STR);
    //           //  $stmt->bindValue(12, $provincia, PDO::PARAM_INT);
    //             $stmt->bindValue(11, $_SESSION["usuario"], PDO::PARAM_STR);
    //             $stmt->bindValue(12, $hoy, PDO::PARAM_STR);
    //             $stmt->bindValue("cliente", $cliente, PDO::PARAM_INT);
    //             $stmt->bindValue("cliente", $cliente, PDO::PARAM_INT);
    //             //$stmt->bindParam("codigo", $cliente, PDO::PARAM_INT);
    //             //    $stmt->bindValue(11, $pais, PDO::PARAM_INT);

    //             if ($stmt->execute()) {

    //                  $this->conn->commit();
    //                 $sql = "SELECT max(codigo) as maximo FROM orden_ventas;";
    //                 $query = $this->conn->prepare($sql);
    //                 $query->execute();
    //                 if ($query->rowCount() > 0) {
    //                     $result = $query->fetchAll();
    //                     return $result[0]["maximo"];
    //                 }
    //                 return 0;
    //             } else {
    //                 $this->conn->rollBack();
    //                 return var_dump($stmt->errorInfo());
    //             }
    //         } else {
    //             //echo "Pasa Componente";
    //             $stmt = $this->conn->prepare('INSERT INTO orden_ventas (observaciones, cod_cliente, fecha, cod_orden_venta_estado_general, cod_orden_venta_estado_entrega, cod_orden_venta_estado_cobranza, cod_maquina, precio_maquina, cod_orden_venta_tipo, cantidad, usuario_m, fecha_m,cod_pais,cod_provincia) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,(SELECT ps.codigo FROM paises ps INNER JOIN personas pr ON ps.codigo=pr.cod_pais WHERE pr.codigo="cliente"),(SELECT ps.codigo FROM provincias ps INNER JOIN personas pr ON ps.codigo=pr.cod_provincia WHERE pr.codigo="cliente"));');
    //             $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
    //             $stmt->bindValue(2, $cliente, PDO::PARAM_INT);
    //             $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
    //             $stmt->bindValue(4, $general, PDO::PARAM_INT);
    //             $stmt->bindValue(5, $entrega, PDO::PARAM_INT);
    //             $stmt->bindValue(6, $cobranza, PDO::PARAM_INT);
    //             $stmt->bindValue(7, abs($producto), PDO::PARAM_INT);
    //             $stmt->bindValue(8, $precio, PDO::PARAM_STR);
    //             $stmt->bindValue(9, $tipo, PDO::PARAM_INT);
    //             $stmt->bindValue(10, $_SESSION["usuario"], PDO::PARAM_STR);
    //             $stmt->bindValue(11, $hoy, PDO::PARAM_STR);
    //             $stmt->bindValue("cliente", $cliente, PDO::PARAM_INT);
    //             $stmt->bindValue("cliente", $cliente, PDO::PARAM_INT);
    //             if ($stmt->execute()) {
    //                 $this->conn->commit();


    //                 $sql = "SELECT max(codigo) as maximo FROM orden_ventas;";
    //                 $query = $this->conn->prepare($sql);
    //                 $query->execute();
    //                 if ($query->rowCount() > 0) {
    //                     $result = $query->fetchAll();
    //                     return $result[0]["maximo"];
    //                 }
    //                 return 0;  
    //             } else {
    //                 $this->conn->rollBack();
    //                 return var_dump($stmt->errorInfo());
    //             }
    //         } 
    //     } catch (PDOException $e) {
    //         $this->conn->rollBack();
    //         return -1;
    //     }
    // }
    public function getPais($cliente)
    {

        try {
            $sql = "SELECT ps.codigo as codigo FROM paises ps INNER JOIN personas pr ON ps.codigo=pr.cod_pais WHERE pr.codigo='" . $cliente . "'";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    public function getProvincia($cliente)
    {

        try {
            $sql = "SELECT ps.codigo as codigo FROM provincias ps INNER JOIN personas pr ON ps.codigo=pr.cod_provincia WHERE pr.codigo='" . $cliente . "'";
            $query = $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }
    public function addOrdenVenta($fecha, $cliente, $pais, $provincia, $producto, $cuit, $tipoprod, $tipouso, $observaciones, $general, $entrega, $cobranza, $precio, $tipo, $cantidad, $facturacion, $entregamaquina, $descuentosforma, $fechaentrega)
    {
        $hoy = date("Y-m-d H:i:s");
        try {

            $estado = 1;

            $cadena = explode(":", $tipoprod);


            $this->conn->beginTransaction();
            if ($tipoprod == 3 || $tipoprod == 2) {
                // echo "Pasa Insumo";
                $stmt = $this->conn->prepare('INSERT INTO orden_ventas (observaciones, cod_cliente, fecha, cod_orden_venta_estado_general, cod_orden_venta_estado_entrega, cod_orden_venta_estado_cobranza, cod_maquina, precio_maquina, cod_orden_venta_tipo, cantidad,usuario_m, fecha_m, cod_pais, cod_provincia,cuit,	nombre_facturacion,entrega_maquina,descuentos,fecha_estimada_entrega) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);');
                $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
                $stmt->bindValue(2, $cliente, PDO::PARAM_INT);
                $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
                $stmt->bindValue(4, $general, PDO::PARAM_INT);
                $stmt->bindValue(5, $entrega, PDO::PARAM_INT);
                $stmt->bindValue(6, $cobranza, PDO::PARAM_INT);
                $stmt->bindValue(7, abs($producto), PDO::PARAM_INT);
                $stmt->bindValue(8, $precio, PDO::PARAM_STR);
                $stmt->bindValue(9, $tipo, PDO::PARAM_INT);
                $stmt->bindValue(10, $cantidad, PDO::PARAM_STR);

                $stmt->bindValue(11, $_SESSION["usuario"], PDO::PARAM_STR);
                $stmt->bindValue(12, $hoy, PDO::PARAM_STR);
                $stmt->bindValue(13, $this->getPais($cliente), PDO::PARAM_INT);
                $stmt->bindValue(14,  $this->getProvincia($cliente), PDO::PARAM_INT);
                $stmt->bindValue(15, $cuit, PDO::PARAM_STR);
                $stmt->bindValue(16, $facturacion, PDO::PARAM_STR);
                $stmt->bindValue(17, $entregamaquina, PDO::PARAM_STR);
                $stmt->bindValue(18, $descuentosforma, PDO::PARAM_STR);
                $stmt->bindValue(19, $fechaentrega, PDO::PARAM_STR);


                if ($stmt->execute()) {
                    $this->conn->commit();
                    $sql = "SELECT max(codigo) as maximo FROM orden_ventas;";
                    $query = $this->conn->prepare($sql);
                    $query->execute();
                    if ($query->rowCount() > 0) {
                        $result = $query->fetchAll();
                        return $result[0]["maximo"];
                    }
                    return 0;
                } else {
                    $this->conn->rollBack();
                    return var_dump($stmt->errorInfo());
                }
            } else {
                //echo "Pasa Componente";
                $stmt = $this->conn->prepare('INSERT INTO orden_ventas (observaciones, cod_cliente, fecha, cod_orden_venta_estado_general, cod_orden_venta_estado_entrega, cod_orden_venta_estado_cobranza, cod_componente, precio_maquina, cod_orden_venta_tipo, cantidad,usuario_m, fecha_m,cod_pais,cod_provincia,cuit,nombre_facturacion,entrega_maquina,descuentos,fecha_estimada_entrega) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);');
                $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
                $stmt->bindValue(2, $cliente, PDO::PARAM_INT);
                $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
                $stmt->bindValue(4, $general, PDO::PARAM_INT);
                $stmt->bindValue(5, $entrega, PDO::PARAM_INT);
                $stmt->bindValue(6, $cobranza, PDO::PARAM_INT);
                $stmt->bindValue(7, abs($producto), PDO::PARAM_INT);
                $stmt->bindValue(8, $precio, PDO::PARAM_STR);
                $stmt->bindValue(9, $tipo, PDO::PARAM_INT);
                $stmt->bindValue(10, $cantidad, PDO::PARAM_STR);
                $stmt->bindValue(11, $_SESSION["usuario"], PDO::PARAM_STR);
                $stmt->bindValue(12, $hoy, PDO::PARAM_STR);
                $stmt->bindValue(13,  $this->getPais($cliente), PDO::PARAM_INT);
                $stmt->bindValue(14,  $this->getProvincia($cliente), PDO::PARAM_INT);
                $stmt->bindValue(15, $cuit, PDO::PARAM_STR);
                $stmt->bindValue(16, $facturacion, PDO::PARAM_STR);
                $stmt->bindValue(17, $entregamaquina, PDO::PARAM_STR);
                $stmt->bindValue(18, $descuentosforma, PDO::PARAM_STR);
                $stmt->bindValue(19, $fechaentrega, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $this->conn->commit();
                    $sql = "SELECT max(codigo) as maximo FROM orden_ventas;";
                    $query = $this->conn->prepare($sql);
                    $query->execute();
                    if ($query->rowCount() > 0) {
                        $result = $query->fetchAll();
                        return $result[0]["maximo"];
                    }
                    return 0;
                } else {
                    $this->conn->rollBack();
                    return var_dump($stmt->errorInfo());
                }
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }

    public function addOrdenVentaInsumo($orden_venta, $insumo, $cantidad, $precio, $precio_usd)
    {
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO orden_venta_componentes (cod_orden_venta, cod_componente, cantidad, costo_unitario, costo_unitario_usd, usuario_m, fecha_m) VALUES (?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $orden_venta, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $precio, PDO::PARAM_STR);
            $stmt->bindValue(5, $precio_usd, PDO::PARAM_STR);
            $stmt->bindValue(6, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(7, $hoy, PDO::PARAM_STR);

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

    public function addOrdenVentaPago($orden_venta, $fecha, $forma, $importe, $observaciones)
    {
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO orden_ventas_pagos (cod_ov, cod_forma_pago, importe, fecha, observaciones, usuario_m, fecha_m) VALUES (?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $orden_venta, PDO::PARAM_INT);
            $stmt->bindValue(2, $forma, PDO::PARAM_INT);
            $stmt->bindValue(3, $importe, PDO::PARAM_STR);
            $stmt->bindValue(4, $fecha, PDO::PARAM_STR);
            $stmt->bindValue(5, $observaciones, PDO::PARAM_STR);
            $stmt->bindValue(6, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(7, $hoy, PDO::PARAM_STR);

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

    public function editOrdenVenta($codigo, $datos)
    {
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_ventas set '
                . 'nombre_facturacion = ? , '
                . 'flete = ? , '
                . 'destino = ? , '
                . 'fecha_entrega_maquina = ? , '
                . 'comision_vendedor = ? , '
                . 'observaciones = ? , '
                . 'fecha = ? , '
                . 'cod_vendedor = ? , '
                . 'usuario_m = ?, '
                . 'fecha_m = ? '
                . ' where codigo = ?');
            $stmt->bindValue(1, $datos["nombre_facturacion"], PDO::PARAM_STR);
            $stmt->bindValue(2, $datos["flete"], PDO::PARAM_STR);
            $stmt->bindValue(3, $datos["destino"], PDO::PARAM_STR);
            $stmt->bindValue(4, $datos["fecha_entrega_maquina"], PDO::PARAM_STR);
            $stmt->bindValue(5, $datos["comision_vendedor"], PDO::PARAM_STR);
            $stmt->bindValue(6, $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindValue(7, $datos["fecha"], PDO::PARAM_STR);
            $stmt->bindValue(8, $datos["cod_vendedor"], PDO::PARAM_INT);
            $stmt->bindValue(9, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(10, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(11, $codigo, PDO::PARAM_INT);
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

    public function editOrdenVentaRec($codigo, $datos)
    {
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_ventas set '
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

    public function cambiarEstadoOrdenVenta($codigo, $estado)
    {
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_ventas set '
                . 'cod_orden_venta_estado = ? , '
                . 'usuario_m = ?, '
                . 'fecha_m = ? '
                . ' where codigo = ?');
            $stmt->bindValue(1, $estado, PDO::PARAM_INT);
            $stmt->bindValue(2, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(3, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(4, $codigo, PDO::PARAM_INT);
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

    public function updateOrdenVenta($codigo, $fecha, $fechaentrega, $cliente, $pais, $provincia, $producto, $cuit, $tipoprod, $observaciones, $general, $entrega, $cobranza, $precio, $facturacion, $entregamaquina, $descuentosforma)
    {
        $fechaentrega = $fechaentrega ? $fechaentrega : null;
        $hoy = date("Y-m-d H:i:s");
        try {
            $cadena = explode(":", $tipoprod);
            $this->conn->beginTransaction();
            if ($tipoprod == 3 || $tipoprod == 2) {
                $stmt = $this->conn->prepare('UPDATE orden_ventas set '
                    . 'observaciones = ? , '
                    . 'cod_cliente = ? , '
                    . 'fecha = ? , '
                    . 'cod_orden_venta_estado_general = ? , '
                    . 'cod_orden_venta_estado_entrega = ? , '
                    . 'cod_orden_venta_estado_cobranza = ? , '
                    . 'precio_maquina = ? , '
                    . 'fecha_estimada_entrega = ? , '
                    . 'cod_pais = ? , '
                    . 'cod_provincia = ? , '
                    . 'cuit = ? ,'
                    . 'usuario_m = ? , '
                    . 'fecha_m = ? ,'
                    . 'nombre_facturacion=? ,'
                    . 'entrega_maquina=? ,'
                    . 'descuentos=? '
                    . ' where codigo = ?');
                $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
                $stmt->bindValue(2, $cliente, PDO::PARAM_INT);
                $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
                $stmt->bindValue(4, $general, PDO::PARAM_INT);
                $stmt->bindValue(5, $entrega, PDO::PARAM_INT);
                $stmt->bindValue(6, $cobranza, PDO::PARAM_INT);
                $stmt->bindValue(7, $precio, PDO::PARAM_STR);
                $stmt->bindValue(8, $fechaentrega, PDO::PARAM_STR);
                $stmt->bindValue(9,  $this->getPais($cliente), PDO::PARAM_INT);
                $stmt->bindValue(10,  $this->getProvincia($cliente), PDO::PARAM_INT);
                $stmt->bindValue(11, $cuit, PDO::PARAM_STR);
                $stmt->bindValue(12, $_SESSION["usuario"], PDO::PARAM_STR);
                $stmt->bindValue(13, $hoy, PDO::PARAM_STR);
                $stmt->bindValue(14, $facturacion, PDO::PARAM_STR);
                $stmt->bindValue(15, $entregamaquina, PDO::PARAM_STR);
                $stmt->bindValue(16, $descuentosforma, PDO::PARAM_STR);
                $stmt->bindValue(17, $codigo, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $this->conn->commit();
                    return 0;
                } else {
                    $this->conn->rollBack();
                    return var_dump($stmt->errorInfo());
                }
            } else {
                $stmt = $this->conn->prepare('UPDATE orden_ventas set '
                    . 'observaciones = ? , '
                    . 'cod_cliente = ? , '
                    . 'fecha = ? , '
                    . 'cod_orden_venta_estado_general = ? , '
                    . 'cod_orden_venta_estado_entrega = ? , '
                    . 'cod_orden_venta_estado_cobranza = ? , '
                    . 'precio_maquina = ? , '
                    . 'fecha_estimada_entrega = ? , '
                    . 'cod_pais = ? , '
                    . 'cod_provincia = ? , '
                    . 'cuit = ?,'
                    . 'usuario_m = ? , '
                    . 'fecha_m = ? ,'
                    . 'nombre_facturacion=? ,'
                    . 'entrega_maquina=? ,'
                    . 'descuentos=? '
                    . ' where codigo = ?');
                $stmt->bindValue(1, $observaciones, PDO::PARAM_STR);
                $stmt->bindValue(2, $cliente, PDO::PARAM_INT);
                $stmt->bindValue(3, $fecha, PDO::PARAM_STR);
                $stmt->bindValue(4, $general, PDO::PARAM_INT);
                $stmt->bindValue(5, $entrega, PDO::PARAM_INT);
                $stmt->bindValue(6, $cobranza, PDO::PARAM_INT);
                $stmt->bindValue(7, $precio, PDO::PARAM_STR);
                $stmt->bindValue(8, $fechaentrega, PDO::PARAM_STR);
                $stmt->bindValue(9,  $this->getPais($cliente), PDO::PARAM_INT);
                $stmt->bindValue(10,  $this->getProvincia($cliente), PDO::PARAM_INT);
                $stmt->bindValue(11, $cuit, PDO::PARAM_STR);
                $stmt->bindValue(12, $_SESSION["usuario"], PDO::PARAM_STR);
                $stmt->bindValue(13, $hoy, PDO::PARAM_STR);
                $stmt->bindValue(14, $facturacion, PDO::PARAM_STR);
                $stmt->bindValue(15, $entregamaquina, PDO::PARAM_STR);
                $stmt->bindValue(16, $descuentosforma, PDO::PARAM_STR);
                $stmt->bindValue(17, $codigo, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    $this->conn->commit();
                    return 0;
                } else {
                    $this->conn->rollBack();
                    return var_dump($stmt->errorInfo());
                }
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return -1;
        }
    }

    public function updateOrdenVentaInsumo($codigo, $orden_venta, $insumo, $cantidad, $precio)
    {
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_ventas_detalles set '
                . 'cod_orden_venta = ? , '
                . 'cod_componente = ? , '
                . 'cantidad = ? , '
                . 'precio = ? , '
                . 'usuario_m = ?, '
                . 'fecha_m = ? '
                . ' where codigo = ?');
            $stmt->bindValue(1, $orden_venta, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $precio, PDO::PARAM_STR);
            $stmt->bindValue(5, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(6, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(7, $codigo, PDO::PARAM_INT);
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

    public function updateOrdenVentaInsumoRec($codigo, $orden_venta, $recibido)
    {
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE orden_ventas_detalles set '
                . 'cantidad_recibida = ? , '
                . 'usuario_m = ?, '
                . 'fecha_m = ? '
                . ' where codigo = ?');
            $stmt->bindValue(1, $recibido, PDO::PARAM_STR);
            $stmt->bindValue(2, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(3, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(4, $codigo, PDO::PARAM_INT);
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

    public function getOrdenVentacomponenteinsumo($codigo)
    {
        try {
            $sql = "SELECT es_insumo FROM componentes WHERE codigo = " . $codigo . ";";
            $query = $this->conn->prepare($sql);
            $query->execute();

            while ($filas = mysqli_fetch_array($query)) {


                return $filas['es_insumo'];
            }
        } catch (PDOException $e) {
            $error = "Error!: " . $e->getMessage();

            return $error;
        }
    }
    public function getOrdenVenta($codigo)
    {
        try {
            $sql = "SELECT ps.descripcion as pais, pv.descripcion as provincia,prs.cuit as cuit,os.cod_orden_venta_tipo as tipo,os.nombre_facturacion as facturacion,os.entrega_maquina as entregamaquina,os.descuentos as descuentos , os.*,
            (select descripcion from personas where codigo = os.cod_cliente) as cliente,
            (select descripcion from componentes where codigo = os.cod_componente) as producto,
            (select codigo_mp from componentes where codigo = os.cod_componente) as producto_codigo_mp,
            (select descripcion from maquinas where codigo = os.cod_maquina) as maquina,
            (select descrip_abrev from maquinas where codigo = os.cod_maquina) as maquina_descrip_abrev,
            (select descripcion from orden_ventas_estados where codigo = os.cod_orden_venta_estado_general and general = 1) as estado_general,
            (select descripcion from orden_ventas_estados where codigo = os.cod_orden_venta_estado_entrega and entrega = 1) as estado_entrega,
            (select descripcion from orden_ventas_estados where codigo = os.cod_orden_venta_estado_cobranza and cobranza = 1) as estado_cobranza FROM orden_ventas os INNER JOIN personas prs ON prs.codigo=os.cod_cliente INNER JOIN paises ps ON prs.cod_pais=ps.codigo INNER JOIN provincias pv ON prs.cod_provincia=pv.codigo WHERE os.codigo=" . $codigo . ";";
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

    public function getComponente($codigo)
    {
        try {
            $sql = "SELECT * FROM componentes WHERE codigo = " . $codigo . " AND es_insumo=0;";
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




    public function getInsumo($codigo)
    {
        try {
            $sql = "SELECT * FROM componentes WHERE codigo = " . $codigo . " AND es_insumo=1;";
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
    public function getMaquina($codigo)
    {
        try {
            $sql = "SELECT * FROM maquinas WHERE codigo = " . $codigo . ";";
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


    public function getOrdenVentaInsumo($codigo)
    {
        try {
            $sql = "SELECT * FROM orden_ventas_detalles WHERE codigo = " . $codigo . ";";
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

    public function getUnidades()
    {
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

    public function getEstados()
    {
        try {
            $sql = "SELECT * FROM orden_ventas_estados order by codigo;";
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

    public function getVendedores()
    {
        try {
            $sql = "SELECT * FROM personas where vendedor = 1 order by descripcion;";
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

    public function getProveedores()
    {
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

    public function getClientes()
    {
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

    public function getOrdenVentasCategorias()
    {
        try {
            $sql = "SELECT * FROM orden_ventas_categorias order by descripcion;";
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

    public function getComponentes()
    {
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

    public function getInsumos()
    {
        try {
            $sql = "SELECT * FROM componentes where es_insumo = 1 order by descripcion;";
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

            $sql = "SELECT c.codigo,c.descripcion, DATE_FORMAT(c.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif,c.costo_unitario,c.precio_unitario,c.es_insumo,c.es_usado FROM componentes c WHERE es_insumo=0";

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
    public function getProductos3()
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

            $sql = "SELECT c.codigo,c.descripcion, DATE_FORMAT(c.fecha_m, '%Y-%m-%d %H:%i:%s') as fecha_modif,c.costo_unitario,c.precio_unitario,c.es_insumo,c.es_usado FROM componentes c WHERE es_insumo=1";

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
    public function getMaquinas()
    {
        try {
            $sql = "SELECT * FROM maquinas where 1 = 1 order by descripcion;";
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

    public function getTipos()
    {
        try {
            $sql = "SELECT * FROM orden_ventas_tipos where 1 = 1 order by descripcion;";
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

    public function getFormas()
    {
        try {
            $sql = "SELECT * FROM forma_pagos where 1 = 1 order by descripcion;";
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

    public function getPagosAsociados($cod_orden_venta)
    {
        try {
            $sql = "SELECT orden_ventas_pagos.*, 
            (select descripcion from forma_pagos where codigo = cod_forma_pago) as forma
            FROM orden_ventas_pagos where cod_ov = " . intval($cod_orden_venta) . " order by fecha;";
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

    public function getDetallesAsociados($cod_orden_venta)
    {
        try {
            $sql = "SELECT orden_venta_componentes.*, 
            (select descripcion from componentes where codigo = cod_componente) as componente
            FROM orden_venta_componentes where cod_orden_venta = " . intval($cod_orden_venta) . " order by componente;";
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

    public function getInsumosAsociados($cod_componente)
    {
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

    public function getComponentesAsociados($cod_maquina)
    {
        try {
            $sql = "SELECT codigo, cod_componente, cantidad, 
            (select descripcion from componentes where codigo = cod_componente) as componente
            FROM maquinas_componentes where cod_maquina = " . intval($cod_maquina) . " order by componente;";
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

    public function getVenta($codigo)
    {
        try {
            $sql = "SELECT *, (select descripcion from personas where codigo = orden_ventas.cod_cliente) as cliente
            , (select descripcion from componentes where codigo = orden_ventas.cod_componente) as componente
            , (select descripcion from maquinas where codigo = orden_ventas.cod_maquina) as maquina
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

    public function getPaises()
    {
        try {
            $sql = "SELECT * FROM paises where 1 = 1 order by descripcion;";
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

    public function getProvincias()
    {
        try {
            $sql = "SELECT * FROM provincias where 1 = 1 order by descripcion;";
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
