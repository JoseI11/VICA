<?php

function getCalendar($anio, $mes) {
    $cant_dias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

    $date = $anio . "-" . $mes . "-01";
    $dia = intval(date('w', strtotime($date))); // 0-dom 1-lun ... 6-sab

    $days = array();
    $day = array();
    $contador = 1;
    $aux = 0;
    for ($i = 0; $i < 7; $i++) {
        if ($i < $dia) {
            $day[$i] = 0;
        } else {
            $day[$i] = $contador;
            $contador++;
        }
    }
    $days[] = $day;
    $day = array();
    while ($contador <= $cant_dias) {
        $day[$aux] = $contador;
        $aux++;
        $contador++;
        if ($contador > $cant_dias) {
            while ($aux < 7) {
                $day[$aux] = 0;
                $aux++;
            }
            $days[] = $day;
            break;
        }
        if ($aux == 7) {
            $days[] = $day;
            $day = array();
            $aux = 0;
        }
    }
    return $days;
}

function getMeses() {
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
        'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    return $meses;
}

function getAnios($anio_ini, $anio_margen) {
    $anios = [];
    $anio_fin = date("Y");
    $aux = $anio_ini;
    while ($aux <= $anio_fin) {
        $anios[] = $aux;
        $aux++;
    }
    $aux = 0;
    while ($aux < $anio_margen) {
        $aux++;
        $anios[] = $anio_fin + $aux;
    }
    return $anios;
}

function getMiniCalendar($desde, $hasta) {
    $d = strtotime($desde);
    $h = strtotime($hasta);
    $from = date('Y-m-d',$d);
    $to = date('Y-m-d',$h);
    
    $cant_dias_m = cal_days_in_month(CAL_GREGORIAN, date("m",$d), date("Y",$d));
    
    $str = $h - $d;
    $cant_dias = floor($str/3600/24);
        
    $date = date("Y",$d) . "-" . date("m",$d) . "-" . date("d",$d);
    $dia = intval(date('w', strtotime($date))); // 0-dom 1-lun ... 6-sab

    $mes = date("m",$d);
    $anio = date("Y",$d);
    
    $days = array();
    $day = array();
    $contador = 0;
    $cuentames = intval(date("d",$d));
    $aux = 0;
    for ($i = 0; $i < 7; $i++) {
        if ($i < $dia) {
            $day[$i] = 0;
        } else {
            if ($cuentames < 10){
                $day[$i] = "0" . $cuentames . "/" . $mes . "/" . $anio;
            } else {
                $day[$i] = $cuentames . "/" . $mes . "/" . $anio;
            }
            $contador++;
            $cuentames++;
            if ($cuentames > $cant_dias_m){
                $cuentames = 1;
                $mes = date("m",$h);
                $anio = date("Y",$h);
            }
        }
    }
    $days[] = $day;
    $day = array();
        
    while ($contador <= $cant_dias) {
        if ($cuentames > $cant_dias_m){
            $cuentames = 1;
            $mes = date("m",$h);
            $anio = date("Y",$h);
        }
        //$day[$aux] = $cuentames . "/" . $mes . "/" . $anio;
        if ($cuentames < 10){
            $day[$aux] = "0" . $cuentames . "/" . $mes . "/" . $anio;
        } else {
            $day[$aux] = $cuentames . "/" . $mes . "/" . $anio;
        }
        $aux++;
        $contador++;
        $cuentames++;
        if ($contador > $cant_dias) {
            while ($aux < 7) {
                $day[$aux] = 0;
                $aux++;
            }
            $days[] = $day;
            break;
        }
        if ($aux == 7) {
            $days[] = $day;
            $day = array();
            $aux = 0;
        }
    }
    return $days;
}

function getMiniCalendarAnual($desde, $hasta) {
    $d = strtotime($desde);
    $h = strtotime($hasta);
    $from = date('Y-m-d',$d);
    $to = date('Y-m-d',$h);
    
    $cant_dias_m = cal_days_in_month(CAL_GREGORIAN, date("m",$d), date("Y",$d));
    
    $str = $h - $d;
    $cant_dias = round($str/3600/24);
                   
    $date = date("Y",$d) . "-" . date("m",$d) . "-" . date("d",$d);
    $dia = intval(date('w', strtotime($date))); // 0-dom 1-lun ... 6-sab

    $mes = date("m",$d);
    $anio = date("Y",$d);
    
    $days = array();
    $day = array();
    $contador = 0;
    $cuentames = intval(date("d",$d));
    $aux = 0;
    for ($i = 0; $i < 7; $i++) {
        if ($contador > $cant_dias) {
            break;
        }
        if ($i < $dia) {
            $day[$i] = 0;
        } else {
            if ($cuentames < 10){
                $day[$i] = "0" . $cuentames . "/" . $mes . "/" . $anio;
            } else {
                $day[$i] = $cuentames . "/" . $mes . "/" . $anio;
            }
            $contador++;
            $cuentames++;
            if ($cuentames > $cant_dias_m){
                $cuentames = 1;
                $mes++;
                if ($mes > 12){
                    $mes = 1;
                    $anio++;
                }                
                $cant_dias_m = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
            }
        }
    }
    $days[] = $day;
    $day = array();
    
    while ($contador <= $cant_dias) {
        if ($cuentames > $cant_dias_m){
            $cuentames = 1;
            $mes++;
            if ($mes > 12){
                $mes = 1;
                $anio++;
            }                
            $cant_dias_m = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        }
        //$day[$aux] = $cuentames . "/" . $mes . "/" . $anio;
        if ($cuentames < 10){
            $day[$aux] = "0" . $cuentames . "/" . $mes . "/" . $anio;
        } else {
            $day[$aux] = $cuentames . "/" . $mes . "/" . $anio;
        }
        $aux++;
        $contador++;
        $cuentames++;
        if ($contador > $cant_dias) {
            while ($aux < 7) {
                $day[$aux] = 0;
                $aux++;
            }
            $days[] = $day;
            break;
        }
        if ($aux == 7) {
            $days[] = $day;
            $day = array();
            $aux = 0;
        }
    }
    return $days;
}