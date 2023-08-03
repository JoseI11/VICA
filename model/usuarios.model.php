<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class UsuariosModel {
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

    public static function singleton_usuarios() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getCountUsuarios(){
        try {
            $sql = "SELECT count(*) FROM USUARIOS;";
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
            $sql = "SELECT usuarios.*, roles.descripcion as rol FROM usuarios left join roles on usuarios.cod_rol = roles.codigo
             WHERE usuario like '%" . $busqueda . "%' ORDER BY " . $orderby . " " . $sentido;
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
    
    public function deleteUsuario($codigo){
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('DELETE from usuarios where codigo = ?');
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
    
    public function addUsuario($usuario, $password, $nombre, $mail, $rol){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('INSERT INTO usuarios (usuario, password, nombre, mail, cod_rol, usuario_m, fecha_m) VALUES (?,?,?,?,?,?,?);');
            $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
            $stmt->bindValue(2, $password, PDO::PARAM_STR);
            $stmt->bindValue(3, $nombre, PDO::PARAM_STR);
            $stmt->bindValue(4, $mail, PDO::PARAM_STR);
            $stmt->bindValue(5, $rol, PDO::PARAM_INT);
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
    
    public function updateUsuario($codigo, $usuario, $password, $nombre, $mail, $rol){
        $hoy = date("Y-m-d H:i:s");
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare('UPDATE usuarios set '
                                            . 'usuario = ? , '
                                            . 'password = ? , '
                                            . 'nombre = ? , '
                                            . 'mail = ? , '
                                            . 'cod_rol = ? , '
                                            . 'usuario_m = ?, '
                                            . 'fecha_m = ? '
                                            . ' where codigo = ?');
            
            $stmt->bindValue(1, $usuario, PDO::PARAM_STR);
            $stmt->bindValue(2, $password, PDO::PARAM_STR);
            $stmt->bindValue(3, $nombre, PDO::PARAM_STR);
            $stmt->bindValue(4, $mail, PDO::PARAM_STR);
            $stmt->bindValue(5, $rol, PDO::PARAM_INT);
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
    
    public function getUsuario($codigo){
        try {
            $sql = "SELECT * FROM usuarios WHERE codigo = " . $codigo . ";";
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
    
    public function getRoles(){
        try {
            $sql = "SELECT * FROM roles ORDER BY descripcion;";
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