<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include_once $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class PersonasModel {
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

    public static function singleton_personas() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountPersonas(){
        try {
            $sql = "SELECT count(*) FROM personas;";
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
            $sql = "SELECT * FROM personas WHERE descripcion like '%" . $busqueda . "%' ORDER BY " . $orderby . " " . $sentido;
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
    
    public function deletePersona($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from personas where codigo = ? 
                and codigo not in (select cod_cliente from orden_ventas) and codigo not in (select cod_vendedor from orden_ventas)
                and codigo not in (select cod_proveedor from orden_compras)
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
    
    public function addPersona($descripcion, $telefono, $localidad, $cuit, $mail, $pais, $provincia, $cliente, $proveedor, $transportista, $vendedor, $empleado){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO personas (descripcion, telefono, localidad, cod_provincia, cod_pais, cliente, proveedor, transportista, vendedor, cuit, mail, empleado, usuario_m, fecha_m) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(2, $telefono, PDO::PARAM_STR);
            $stmt->bindValue(3, $localidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $provincia, PDO::PARAM_INT);
            $stmt->bindValue(5, $pais, PDO::PARAM_INT);
            $stmt->bindValue(6, $cliente, PDO::PARAM_INT);
            $stmt->bindValue(7, $proveedor, PDO::PARAM_INT);
            $stmt->bindValue(8, $transportista, PDO::PARAM_INT);
            $stmt->bindValue(9, $vendedor, PDO::PARAM_INT);
            $stmt->bindValue(10, $cuit, PDO::PARAM_STR);
            $stmt->bindValue(11, $mail, PDO::PARAM_STR);
            $stmt->bindValue(12, $empleado, PDO::PARAM_INT);
            $stmt->bindValue(13, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(14, $hoy, PDO::PARAM_STR);
            
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
    
    public function updatePersona($codigo, $descripcion, $telefono, $localidad, $cuit, $mail, $pais, $provincia, $cliente, $proveedor, $transportista, $vendedor, $empleado){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE personas set '
                                            . 'descripcion = ? , '
                                            . 'telefono = ? , '
                                            . 'localidad = ? , '
                                            . 'cod_provincia = ? , '
                                            . 'cod_pais = ? , '
                                            . 'cliente = ? , '
                                            . 'proveedor = ? , '
                                            . 'transportista = ? , '
                                            . 'vendedor = ? , '
                                            . 'cuit = ? , '
                                            . 'mail = ? , '
                                            . 'empleado = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');            
            $stmt->bindValue(1, $descripcion, PDO::PARAM_STR);
            $stmt->bindValue(2, $telefono, PDO::PARAM_STR);
            $stmt->bindValue(3, $localidad, PDO::PARAM_STR);
            $stmt->bindValue(4, $provincia, PDO::PARAM_INT);
            $stmt->bindValue(5, $pais, PDO::PARAM_INT);
            $stmt->bindValue(6, $cliente, PDO::PARAM_INT);
            $stmt->bindValue(7, $proveedor, PDO::PARAM_INT);
            $stmt->bindValue(8, $transportista, PDO::PARAM_INT);
            $stmt->bindValue(9, $vendedor, PDO::PARAM_INT);
            $stmt->bindValue(10, $cuit, PDO::PARAM_STR);
            $stmt->bindValue(11, $mail, PDO::PARAM_STR);
            $stmt->bindValue(12, $empleado, PDO::PARAM_INT);
            $stmt->bindValue(13, $_SESSION["usuario"], PDO::PARAM_STR);
            $stmt->bindValue(14, $hoy, PDO::PARAM_STR);
            $stmt->bindValue(15, $codigo, PDO::PARAM_INT);
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
    
    public function getPersona($codigo){
        try {
            $sql = "SELECT * FROM personas WHERE codigo = " . $codigo . ";";
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
    
    public function getProvincias(){
        try {
            $sql = "SELECT * FROM provincias order by descripcion;";
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
    
    public function getPaises(){
        try {
            $sql = "SELECT * FROM paises order by descripcion;";
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