<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class MaquinasModel {
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

    public static function singleton_maquinas() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountMaquinas(){
        try {
            $sql = "SELECT count(*) FROM maquinas;";
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
            $sql = "SELECT * FROM maquinas WHERE descripcion like '%" . $busqueda . "%' ORDER BY " . $orderby . " " . $sentido;
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
    
    public function deleteMaquina($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from maquinas where codigo = ? '); 
                //and codigo not in (select cod_maquina from orden_trabajo_maquinas) 
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
    
    public function deleteMaquinaComponente($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from maquinas_componentes where codigo = ? 
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
    
    public function addMaquina($descrip_abrev, $descripcion, $observaciones, $modelo,$preciounitario,$costounitario,$tipodeuso){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO maquinas (descrip_abrev, descripcion, observaciones, cod_maquina_modelo,precio_unitario,costo_unitario,es_usado, usuario_m, fecha_m) VALUES (?,?,?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $descrip_abrev, PDO::PARAM_STR);
            $stmt->bindValue(2, $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(3, $observaciones, PDO::PARAM_STR);
            $stmt->bindValue(4, $modelo, PDO::PARAM_INT);
            $stmt->bindValue(5, $preciounitario, PDO::PARAM_STR);
            $stmt->bindValue(6, $costounitario, PDO::PARAM_STR);
            $stmt->bindValue(7, $tipodeuso, PDO::PARAM_INT);
            $stmt->bindValue(8, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(9, $hoy, PDO::PARAM_STR);
            
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
    
    public function addMaquinaComponente($maquina, $componente, $cantidad){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO maquinas_componentes (cod_maquina, cod_componente, cantidad, usuario_m, fecha_m) VALUES (?,?,?,?,?);');
            $stmt->bindValue(1, $maquina, PDO::PARAM_INT);
            $stmt->bindValue(2, $componente, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
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
    
    public function editMaquina($codigo, $datos){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE maquinas set '
                                            . 'descrip_abrev = ? , '
                                            . 'descripcion = ? , '
                                            . 'observaciones = ? , '
                                            . 'cod_maquina_modelo = ? , '
                                            . 'precio_unitario = ?, '
                                            . 'costo_unitario = ?, '
                                            . 'es_usado = ?, '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $datos["descrip_abrev"], PDO::PARAM_STR);
            $stmt->bindValue(2, $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindValue(3, $datos["observaciones"], PDO::PARAM_STR);
            $stmt->bindValue(4, $datos["modelo"], PDO::PARAM_INT);
            $stmt->bindValue(5, $datos["preciounitario"],PDO::PARAM_STR);
            $stmt->bindValue(6 , $datos["costounitario"],PDO::PARAM_STR);
            $stmt->bindValue(7, $datos["tipouso"], PDO::PARAM_INT);
            $stmt->bindValue(8, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(9, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(10, $codigo, PDO::PARAM_INT);
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
    
    public function updateMaquina($codigo, $descrip_abrev, $descripcion, $observaciones, $modelo,$preciounitario,$costounitario,$tipodeuso){
        $hoy = date("Y-m-d H:i:s");
        echo $tipodeuso;
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE maquinas set '
                                            . 'descrip_abrev = ? , '
                                            . 'descripcion = ? , '
                                            . 'observaciones = ? , '
                                            . 'cod_maquina_modelo = ? , '
                                            . 'precio_unitario = ?, '
                                            . 'costo_unitario = ?, '
                                            . 'es_usado = ?, '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');      
            $stmt->bindValue(1, $descrip_abrev, PDO::PARAM_STR);
            $stmt->bindValue(2, $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(3, $observaciones, PDO::PARAM_STR);
            $stmt->bindValue(4, $modelo, PDO::PARAM_INT);
            $stmt->bindValue(5, $preciounitario, PDO::PARAM_STR);
            $stmt->bindValue(6, $costounitario, PDO::PARAM_STR);
            $stmt->bindValue(7, $tipodeuso, PDO::PARAM_INT);
            $stmt->bindValue(8, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(9, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(10, $codigo, PDO::PARAM_INT);
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
    
    public function updateMaquinaComponente($codigo, $maquina, $componente, $cantidad){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE maquinas_componentes set '
                                            . 'cod_maquina = ? , '
                                            . 'cod_componente = ? , '
                                            . 'cantidad = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');    
            $stmt->bindValue(1, $maquina, PDO::PARAM_INT);
            $stmt->bindValue(2, $componente, PDO::PARAM_INT);
            $stmt->bindValue(3, $cantidad, PDO::PARAM_STR);
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
    
    public function getMaquina($codigo){
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
    
    public function getMaquinaComponente($codigo){
        try {
            $sql = "SELECT * FROM maquinas_componentes WHERE codigo = " . $codigo . ";";
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
    
    public function getMaquinasCategorias(){
        try {
            $sql = "SELECT * FROM maquinas_modelos order by descripcion;";
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
    
    public function getComponentes(){
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
    
    public function getComponentesAsociados($cod_maquina){
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
}	
?>