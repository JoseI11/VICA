<?php
session_start();
?>

<div id="div_paginacion" class="row" style="margin-top: -10px; font-size: 11px;" orderby="<?php $_SESSION["orderby"]; ?>" sentido="<?php $_SESSION["sentido"]; ?>">
    <div class="col-lg-2 col-md-3 col-sm-3  hidden-xs" style="float: left;text-align: left;margin-top: 5px; ">
        <label for="busqueda">Buscar:</label>
        <input type="text" id="busqueda" name="busqueda" value="<?php echo $_SESSION["busqueda"]; ?>" style="width: 75px;" />
        <a href="#" style="margin-left: 5px;" id="busqueda-erase" name="busqueda-erase"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span></a>
        <a href="#" style="margin-left: 5px;" id="busqueda-icono" name="busqueda-icono"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs" style="float: left;text-align: left;margin-top: 0px;">
        <label>Registros <br />por página:</label>
        <select id="cant_reg" class="form-control asistencia" style="width: 90px;display: inline-block;vertical-align: middle; font-size: 11px; height: auto; margin-top: -15px;">
            <option value="10" <?php if ($_SESSION['cant_reg'] == 10) echo "selected"; ?>>10</option>
            <option value="25" <?php if ($_SESSION['cant_reg'] == 25) echo "selected"; ?>>25</option>
            <option value="50" <?php if ($_SESSION['cant_reg'] == 50) echo "selected"; ?>>50</option>
            <option value="-1" <?php if ($_SESSION['cant_reg'] == -1) echo "selected"; ?>>TODOS</option> <!-- glyphicon glyphicon-warning-sign -->
        </select>
    </div>
    <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="float: left;text-align: left;margin-top: 8px;" id='leyenda_paginacion'>
        <?php if ($_SESSION["totales"] > 0) { ?>
        <label>Mostrando <?php echo ($_SESSION["pagina"] - 1) * $_SESSION["cant_reg"] + 1; ?> a <?php
            if ($_SESSION["totales"] <= $_SESSION["pagina"] * $_SESSION["cant_reg"])
                echo $_SESSION["totales"];
            else
                echo $_SESSION["pagina"] * $_SESSION["cant_reg"];
            ?> de <?php echo $_SESSION["totales"]; ?> reg.</label>
        <?php } else { ?>
            <label>No hay registros para mostrar</label>
        <?php } ?>
    </div>
    <div id="paginacion_paginas" class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="float: right;text-align: right; margin-right: 30px;">
        <ul class="pagination" style="vertical-align: middle; margin-bottom: 10px;margin-top: 0px;">
            <span style="color: #337ab7;">Páginas:</span>
        </ul>
        <ul class="pagination" style="vertical-align: middle; margin-bottom: 10px;margin-top: 0px;">
            <?php
            $antes = 0;
            $actual = 0;
            $despues = 0;
            if ($_SESSION["cant_reg"] > 0){
                for ($i = 0; $i < ceil($_SESSION["totales"] / $_SESSION["cant_reg"]); $i++) {
                    if (($i + 1) < $_SESSION["pagina"]) {
                        $antes = $i + 1;
                    }
                    if (($i + 1) == $_SESSION["pagina"]) {
                        $actual = $i + 1;
                    }
                    if (($i + 1) > $_SESSION["pagina"]) {
                        $despues = $i + 1;
                    }
                }
            }   
            $_SESSION["ultima_pagina"] = $despues;
            if ($antes > 1) {
                echo '<li class="paginas"><a id="first" href="#">' . '<<' . '</a></li>';
                echo '<li class="paginas"><a id="before" href="#">' . $antes . '</a></li>';
            }
            if ($antes == 1) {
                echo '<li class="paginas"><a id="first" href="#" style="display: none;">' . '<<' . '</a></li>';
                echo '<li class="paginas"><a id="before" href="#">' . $antes . '</a></li>';
            }
            if ($antes == 0) {
                echo '<li class="paginas"><a id="first" href="#" style="display: none;">-2</a></li>';
                echo '<li class="paginas"><a id="before" href="#" style="display: none;">-1</a></li>';
            }
            echo '<li class="active"><a id="actual" href="#">' . $actual . '</a></li>';
            if ($despues > ($actual + 1)) {
                echo '<li class="paginas"><a id="next" href="#">' . strval($actual + 1) . '</a></li>';
                echo '<li class="paginas"><a id="last" ultimo="' . $despues . '" href="#">' . '>>' . '</a></li>';
            }
            if ($despues == ($actual + 1)) {
                echo '<li class="paginas"><a id="next" href="#">' . $despues . '</a></li>';
                echo '<li class="paginas"><a id="last" ultimo="' . $despues . '" href="#" style="display: none;">' . '>>' . '</a></li>';
            }
            ?>
        </ul>
    </div>
</div>