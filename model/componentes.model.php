<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class ComponentesModel {
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

    public static function singleton_componentes() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountComponentes(){
        try {
            $sql = "SELECT count(*) FROM componentes;";
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
            (select descripcion from unidades where codigo = cod_unidad) as unidad,
            (select descripcion from componentes_categorias where codigo = cod_componente_categoria) as categoria FROM componentes WHERE es_usado = 0 and (codigo_mp like '%" . $busqueda . "%' or dimension like '%" . $busqueda . "%') ORDER BY " . $orderby . " " . $sentido;
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
    
    public function deleteComponente($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from componentes where codigo = ? 
                and codigo not in (select cod_componente from orden_trabajo_componentes) 
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
    
    public function deleteComponenteInsumo($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from componentes_insumos where codigo = ? or codigo = ?');
            $stmt->bindValue(1, $codigo, PDO::PARAM_INT);
            $stmt->bindValue(2, $codigo+1, PDO::PARAM_INT);
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
    
    public function addComponente($descripcion, $insumo, $usado, $codigo_mp, $unidad, $dimension, $categoria, $costo, $precio, $stock_min, $stock_max, $iva, $espesor, $largo, $largo_total, $peso, $peso_total){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $usado = 0;
            $stmt = $this->conn->prepare('INSERT INTO componentes (descripcion, cod_unidad, es_insumo, es_usado,codigo_mp, usuario_m, fecha_m, dimension, cod_componente_categoria,costo_unitario,precio_unitario, stock_minimo, stock_maximo, iva, espesor, largo, largo_total, peso, peso_total) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(2, $unidad, PDO::PARAM_INT);
            $stmt->bindValue(3, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(4, $usado, PDO::PARAM_INT);
            $stmt->bindValue(5, $codigo_mp, PDO::PARAM_INT);
            $stmt->bindValue(6, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(7, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(8, $dimension, PDO::PARAM_STR);
            $stmt->bindValue(9, $categoria, PDO::PARAM_STR);
            $stmt->bindValue(10, floatval($costo), PDO::PARAM_STR);
            $stmt->bindValue(11, floatval($precio), PDO::PARAM_STR);
            $stmt->bindValue(12, floatval($stock_min), PDO::PARAM_STR);
            $stmt->bindValue(13, floatval($stock_max), PDO::PARAM_STR);
            $stmt->bindValue(14, floatval($iva), PDO::PARAM_STR);
            $stmt->bindValue(15, $espesor, PDO::PARAM_STR);
            $stmt->bindValue(16, $largo, PDO::PARAM_STR);
            $stmt->bindValue(17, $largo_total, PDO::PARAM_STR);
            $stmt->bindValue(18, $peso, PDO::PARAM_STR);
            $stmt->bindValue(19, $peso_total, PDO::PARAM_STR);

            if($stmt->execute()){

                $usado = 1;
                $stmt = $this->conn->prepare('INSERT INTO componentes (descripcion, cod_unidad, es_insumo, es_usado,codigo_mp, usuario_m, fecha_m, dimension, cod_componente_categoria,costo_unitario,precio_unitario, stock_minimo, stock_maximo, iva, espesor, largo, largo_total, peso, peso_total) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);');
                $stmt->bindValue(1, $descripcion, PDO::PARAM_STR);
                $stmt->bindValue(2, $unidad, PDO::PARAM_INT);
                $stmt->bindValue(3, $insumo, PDO::PARAM_INT);
                $stmt->bindValue(4, $usado, PDO::PARAM_INT);
                $stmt->bindValue(5, $codigo_mp, PDO::PARAM_INT);
                $stmt->bindValue(6, $_SESSION["usuario"], PDO::PARAM_STR);
                $stmt->bindValue(7, $hoy, PDO::PARAM_STR);
                $stmt->bindValue(8, $dimension, PDO::PARAM_STR);
                $stmt->bindValue(9, $categoria, PDO::PARAM_STR);
                $stmt->bindValue(10, floatval($costo), PDO::PARAM_STR);
                $stmt->bindValue(11, floatval($precio), PDO::PARAM_STR);
                $stmt->bindValue(12, floatval($stock_min), PDO::PARAM_STR);
                $stmt->bindValue(13, floatval($stock_max), PDO::PARAM_STR);
                $stmt->bindValue(14, floatval($iva), PDO::PARAM_STR);
                $stmt->bindValue(15, $espesor, PDO::PARAM_STR);
                $stmt->bindValue(16, $largo, PDO::PARAM_STR);
                $stmt->bindValue(17, $largo_total, PDO::PARAM_STR);
                $stmt->bindValue(18, $peso, PDO::PARAM_STR);
                $stmt->bindValue(19, $peso_total, PDO::PARAM_STR);
                $stmt->execute();

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
    
    public function addComponenteInsumo($componente, $insumo, $cantidad){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO componentes_insumos (cod_componente, cod_insumo, cantidad, usuario_m, fecha_m) VALUES (?,?,?,?,?);');
            $stmt->bindValue(1, $componente, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            
            if($stmt->execute()){
                
                $stmt = $this->conn->prepare('INSERT INTO componentes_insumos (cod_componente, cod_insumo, cantidad, usuario_m, fecha_m) VALUES (?,?,?,?,?);');
                $stmt->bindValue(1, $componente+1, PDO::PARAM_INT);
                $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
                $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
                $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
                $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
                $stmt->execute();

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
    
    public function editComponente($codigo, $datos){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE componentes set '
                                            . 'descripcion = ? , '
                                            . 'cod_unidad = ? , '
                                            . 'cod_componente_categoria = ? , '
                                            . 'costo_unitario = ? , '
                                            . 'precio_unitario = ? , '
                                            . 'iva = ? , '
                                            . 'stock_minimo = ? , '
                                            . 'stock_maximo = ? , '
                                            . 'codigo_mp = ? , '
                                            . 'dimension = ? , '
                                            . 'largo = ? , '
                                            . 'largo_total = ? , '
                                            . 'espesor = ? , '
                                            . 'peso = ? , '
                                            . 'peso_total = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ? or codigo = ?');            
            $stmt->bindValue(1, $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindValue(2, $datos["unidad"], PDO::PARAM_INT);
            $stmt->bindValue(3, $datos["categoria"], PDO::PARAM_INT);
            $stmt->bindValue(4, floatval($datos["costo"]), PDO::PARAM_STR);
            $stmt->bindValue(5, floatval($datos["precio"]), PDO::PARAM_STR);
            $stmt->bindValue(6, floatval($datos["iva"]), PDO::PARAM_STR);
            $stmt->bindValue(7, floatval($datos["minimo"]), PDO::PARAM_STR);
            $stmt->bindValue(8, floatval($datos["maximo"]), PDO::PARAM_STR);
            $stmt->bindValue(9, $datos["codigo_mp"], PDO::PARAM_STR);
            $stmt->bindValue(10, floatval($datos["dimension"]), PDO::PARAM_STR);
            $stmt->bindValue(11, floatval($datos["largo"]), PDO::PARAM_STR);
            $stmt->bindValue(12, floatval($datos["largo_total"]), PDO::PARAM_STR);
            $stmt->bindValue(13, floatval($datos["espesor"]), PDO::PARAM_STR);
            $stmt->bindValue(14, floatval($datos["peso"]), PDO::PARAM_STR);
            $stmt->bindValue(15, floatval($datos["peso_total"]), PDO::PARAM_STR);
            $stmt->bindValue(16, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(17, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(18, $codigo, PDO::PARAM_INT);
            $stmt->bindValue(19, $codigo+1, PDO::PARAM_INT);
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
    
    public function updateComponente($codigo, $descripcion, $insumo, $usado, $unidad){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE componentes set '
                                            . 'descripcion = ? , '
                                            . 'cod_unidad = ? , '
                                            . 'es_insumo = ? , '
                                          //. 'es_usado = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ? or codigo = ?');            
            $stmt->bindValue(1, $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(2, $unidad, PDO::PARAM_INT);
            $stmt->bindValue(3, $insumo, PDO::PARAM_INT);
            //$stmt->bindValue(4, $usado, PDO::PARAM_INT);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(6, $codigo, PDO::PARAM_INT);
            $stmt->bindValue(7, $codigo+1, PDO::PARAM_INT);
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
    
    public function updateComponenteInsumo($codigo, $componente, $insumo, $cantidad){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE componentes_insumos set '
                                            . 'cod_componente = ? , '
                                            . 'cod_insumo = ? , '
                                            . 'cantidad = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ? or codigo = ?');    
            $stmt->bindValue(1, $componente, PDO::PARAM_INT);
            $stmt->bindValue(2, $insumo, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(5, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(6, $codigo, PDO::PARAM_INT);
            $stmt->bindValue(7, $codigo+1, PDO::PARAM_INT);
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
    
    public function getComponente($codigo){
        try {
            $sql = "SELECT *,
                (select descripcion from unidades where codigo = cod_unidad) as unidad,
                (select descripcion from componentes_categorias where codigo = cod_componente_categoria) as categoria
             FROM componentes WHERE codigo = " . $codigo . ";";
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
    
    public function getComponenteInsumo($codigo){
        try {
            $sql = "SELECT * FROM componentes_insumos WHERE codigo = " . $codigo . ";";
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
    
    public function getComponentesCategorias(){
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
    
    public function getInsumos(){
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
    
    public function getInsumosAsociados($cod_componente){
        try {
            $sql = "SELECT codigo, cod_insumo, cantidad, 
            (select codigo_mp from componentes where codigo = cod_insumo) as insumo
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
}	
?>