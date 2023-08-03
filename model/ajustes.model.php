<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);

session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include $_SERVER['DOCUMENT_ROOT']."/VICA/bd/conexion.php";

class AjustesModel {
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

    public static function singleton_ajustes() {
        if ( !isset( self::$instancia ) ) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }
    
    public function getEmpresas() {
        try {
            $sql = "SELECT * FROM empresas order by codigo;";
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
    public function filtrar_tipo_de_stock($tipo){
        try {
            if($tipo==1){
                $sql="SELECT p.*,f.descripcion as familia FROM componentes p LEFT JOIN componentes_categorias f ON p.cod_componente_categoria=f.codigo WHERE p.es_insumo = 1 AND p.costo_unitario IS NOT NULL";
            }else if($tipo==2){
                $sql="SELECT p.*,f.descripcion as familia FROM componentes p LEFT JOIN componentes_categorias f ON p.cod_componente_categoria=f.codigo WHERE p.es_insumo = 0 AND p.costo_unitario IS NOT NULL";
            }else{
                $sql="SELECT descripcion, costo_unitario FROM maquinas WHERE costo_unitario IS NOT NULL";
            }
            $query= $this->conn->prepare($sql);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
                return $result;
            }
        } catch (PDOException $g) {
            $error = "Error!: " . $g->getMessage();

            return $error;
        }
    }   
    public function getInsumos($tipo){
        try {
            if($tipo==1){
                $sql="SELECT p.*,f.descripcion as familia FROM componentes p LEFT JOIN componentes_categorias f ON p.cod_componente_categoria=f.codigo WHERE p.es_insumo = 1 AND p.costo_unitario IS NOT NULL";
            }else if($tipo==2){
                $sql="SELECT p.*,f.descripcion as familia FROM componentes p LEFT JOIN componentes_categorias f ON p.cod_componente_categoria=f.codigo WHERE p.es_insumo = 0 AND p.costo_unitario IS NOT NULL";
            }else if($tipo==3){
                $sql="SELECT * FROM maquinas ";
            }else{
                 $sql = "SELECT 
                        p.*, 
                        f.descripcion as familia
                    FROM 
                        componentes p LEFT JOIN
                        componentes_categorias f ON p.cod_componente_categoria = f.codigo
                    WHERE 
                        p.es_insumo = 1 
                    order by descripcion;";
            }
            //usar un if para diferenciar las consultas
           
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
          
    public function afectarPrecios($seleccionados, $factor, $valor, $tipo){
        $factor = floatval($factor);
        if ($factor == 0){
            return var_dump("Verifique que el factor sea mayor a cero!");
        }
        if (count($seleccionados) == 0){
            return var_dump("Verifique que haya seleccionado al menos un producto!");
        }
        $hoy = date("Y-m-d");
        $ahora = date("Y-m-d H:i:s");
        $lista = "(";
        foreach ($seleccionados as $s){
            $lista .= $s . ",";
        }
        $lista = substr($lista, 0, -1);
        $lista .= ")";
        try {
            $this->conn->beginTransaction();
            if ($tipo == 3 || $tipo == 2){ // maquina
                if ($valor == 1){
                    $stmt = $this->conn->prepare('UPDATE maquinas set '
                                                    . 'precio_unitario = precio_unitario * ' . floatval($factor) . ' '
                                                    . ' where codigo in ' . $lista . ' ');          
                } else {
                    $stmt = $this->conn->prepare('UPDATE maquinas set '
                                                    . 'costo_unitario = costo_unitario * ' . floatval($factor) . ' '
                                                    . ' where codigo in ' . $lista . ' ');          
                }
            } else { // componente
                if ($valor == 1){
                    $stmt = $this->conn->prepare('UPDATE componentes set '
                                                    . 'precio_unitario = precio_unitario * ' . floatval($factor) . ' '
                                                    . ' where codigo in ' . $lista . ' ');          
                } else {
                    $stmt = $this->conn->prepare('UPDATE componentes set '
                                                    . 'costo_unitario = costo_unitario * ' . floatval($factor) . ' '
                                                    . ' where codigo in ' . $lista . ' ');          
                }
            }
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
    
}	
?>