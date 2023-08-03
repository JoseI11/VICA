<?php

$Filepath = "cc.xls";
require('php-excel-reader/excel_reader2.php');
require('SpreadsheetReader.php');
date_default_timezone_set('UTC');
$StartMem = memory_get_usage();
try {
    $Spreadsheet = new SpreadsheetReader($Filepath);
    $BaseMem = memory_get_usage();
    $Sheets = $Spreadsheet->Sheets();
    $empleados = [];
    foreach ($Sheets as $Index => $Name) {
        $Time = microtime(true);
        $Spreadsheet->ChangeSheet($Index);
        $Spreadsheet->ChangeSheet(14);
        $entro = 0;
        $cliente = 89;
        foreach ($Spreadsheet as $Key => $Row) {
            
            if ($Row) {
                if (
                        $Row[0] != "" and
                        $Row[1] != "" and
                        $Row[2] != "" and
                        $Row[3] != "" and
                        $Row[4] != "" and
                        $Row[6] != "" and
                        $Row[7] == "* 2,017"){
                    $cuenta++;
                    
                    $aux = explode("/", $Row[0]);
                    $Row[0] = $aux[2] . "-" . $aux[1] . "-" . $aux[0];
                    
                    $fecha = date("Y-m-d", strtotime($Row[0]));
                    $producto = $Row[1];
                    $cantidad = str_replace(",","",$Row[2]);
                    $preciounitario = str_replace(",","",$Row[3]);
                    $preciounitario = str_replace("$","",$preciounitario);
                    $subtotal = str_replace(",","",$Row[4]);
                    $subtotal = str_replace("$","",$subtotal);
                    if (count(explode(" ", $Row[6])) > 1){
                        $mes = str_replace(",","",explode(" ", $Row[6])[1]);
                    } else {
                        $mes = str_replace(",","",explode(" ", $Row[6])[0]);
                    }
                    $anio = str_replace(",","",explode(" ", $Row[7])[1]);
                    
                    $categ = 1;
                    
                    if (strtolower($Row[8]) == "vacuno"){
                        $categ = 1;
                    }
                    if (strtolower($Row[8]) == "porcino"){
                        $categ = 2;
                    }
                    if (strtolower($Row[8]) == "pollo"){
                        $categ = 3;
                    }
                    if (strtolower($Row[8]) == "elaborado vacuno"){
                        $categ = 11;
                    }
                    if (strtolower($Row[8]) == "elaborado porcino"){
                        $categ = 12;
                    }
                    if (strtolower($Row[8]) == "elaborado mixto"){
                        $categ = 4;
                    }
                    if (strtolower($Row[8]) == "elaborado pollo"){
                        $categ = 13;
                    }
                    if (strtolower($Row[8]) == "elaborado"){
                        $categ = 4;
                    }
                    if (strtolower($Row[8]) == "pollo tercerizado"){
                        $categ = 5;
                    }
                    if (strtolower($Row[8]) == "achuras"){
                        $categ = 5;
                    }
                    if (strtolower($Row[8]) == "chacinados"){
                        $categ = 5;
                    }
                    if (strtolower($Row[8]) == "bolson economico"){
                        $categ = 5;
                    }
                    if (strtolower($Row[8]) == "verduras"){
                        $categ = 15;
                    }
                    if (strtolower($Row[8]) == "carbon"){
                        $categ = 17;
                    }
                    $sql = "insert into cuentascorrientes (fecha, producto, cantidad, preciounitario, subtotal, pesable, mes, anio, categoria, id_cliente) values ('" . $fecha . "','" . $producto . "'," . $cantidad . "," . $preciounitario . "," . $subtotal . ",1," . $mes . "," . $anio . "," . $categ . "," . $cliente . ");";
                    echo $sql . "<br />";
                }
                /* if (strlen(trim($Row[1])) == 0 and 
                  strlen(trim($Row[2])) == 0 and
                  strlen(trim($Row[3])) == 0 and
                  strlen(trim($Row[4])) == 0 and
                  strlen(trim($Row[5])) == 0){
                  continue;
                  }

                  if ($Row[2] == "Horario"){
                  continue;
                  }

                  if ($Row[0] == "Legajo"){
                  if (isset($empleado) and count($empleado) > 0){
                  $empleados[] = $empleado;
                  $entro = 0;
                  }
                  $empleado = [];
                  $legajo = $Row[1];
                  $nomape = $Row[3];
                  $empleado["legajo"] = $legajo;
                  $empleado["nomape"] = $nomape;
                  $empleado["jornadas"] = [];
                  $entro = 1;
                  continue;
                  }
                  if ($entro == 1){
                  if (strlen(trim($Row[0])) > 0){
                  $fecha 	 = $Row[0];
                  $horario = $Row[2];
                  $fichada = $Row[4];
                  $jornada = [];
                  $jornada["fecha"] = $fecha;
                  $jornada["horario"] = $horario;
                  $jornada["fichada"] = $fichada;
                  $empleado["jornadas"][] = $jornada;
                  }
                  } */
            } else {
                echo "FAIL";
            }
        }
        
        break;
    }
} catch (Exception $E) {
    echo $E -> getMessage();
}
?>
