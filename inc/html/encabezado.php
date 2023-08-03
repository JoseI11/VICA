<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);
session_start();

/*if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 72000)) {
    // last request was more than 20 hours ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header("Location: login.php");
}
$_SESSION['LAST_ACTIVITY'] = time(); */

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
}

$favicon = "imagenes/loguito.png";
$favicon2 = "imagenes/loguito2.png";
$bootstrap = "inc/bootstrap/css/bootstrap.css";
$estilos = "inc/css/asistencias_css.css";
$imagen = "imagenes/logo alargado-05.png";
$chartist = "inc/chartist/chartist.css";


$_inicio    	= ["INICIO", "inicio.php", 0, "fa-home"];
$_maquinas		= ["MÁQUINAS", "maquinas.php", 0, "fa-gear"];
$_ocs			= ["ORDEN DE COMPRA", "orden_compras.php", 0, "fa-tint"];
$_ovs			= ["ORDEN DE VENTA", "orden_ventas.php", 0, "fa-money"];
$_ots			= ["ORDEN DE TRABAJO", "orden_trabajos.php", 0, "fa-wrench"];
$_stocks		= ["STOCKS", "stocks.php", 0, "fa-list"];
$_conf  		= ["CONFIGURACIÓN", "#", 1, "fa-gears"];
$_conf_eventos	= ["Eventos", "eventos.php", -1, ""];
$_conf_formas_p	= ["Formas de Pago", "formas.php", -1, ""];
$_conf_pais		= ["Paises", "paises.php", -1, ""];
$_conf_pcias	= ["Provincias", "provincias.php", -1, ""];
$_conf_roles	= ["Roles", "roles.php", -1, ""];
$_conf_unid		= ["Unidades", "unidades.php", -1, ""];
$_personas  	= ["PERSONAS", "personas.php", 0, "fa-user"];
$_usuarios  	= ["USUARIOS", "usuarios.php", 0, "fa-users"];
$_salir     	= ["SALIR", "cerrar.php", 0, "fa-sign-out"];

$_conf_ajustes			= ["Ajustes", "#", -1, "", 400];
$_conf_ajustes_motivos 	= ["Motivos", "ajustes_motivos.php", -1, "", -400];

$_conf_comp 			= ["Componentes", "#", -1, "", 100];
$_conf_comp_categorias 	= ["Categorías", "comp_categorias.php", -1, "", -100];

$_conf_maq 				= ["Máquinas", "#", -1, "", 200];
$_conf_maq_modelos 		= ["Modelos", "maq_modelos.php", -1, "", -200];

$_conf_vta 				= ["Orden Ventas", "#", -1, "", 300];
$_conf_vta_estados 		= ["Estados", "vta_estados.php", -1, "", -300];
$_conf_vta_tipos 		= ["Tipos", "vta_tipos.php", -1, "", -300];

$_conf_cpra 			= ["Orden Compras", "#", -1, "", 500];
$_conf_cpra_estados 	= ["Estados", "cpra_estados.php", -1, "", -500];

$_conf_ot 				= ["Orden Trabajos", "#", -1, "", 600];
$_conf_ot_estados 		= ["Estados", "ot_estados.php", -1, "", -600];
$_conf_ot_tipos 		= ["Tipos", "ot_tipos.php", -1, "", -600];
$_conf_ot_categorias	= ["Categorias", "categorias.php", -1, "", -600];

$_comp  		= ["COMPONENTES", "#", 2, "fa-gift"];
$_comp_listado  = ["Listado", "componentes.php", -2, ""];
$_comp_precios  = ["Ajsutar Precios", "ajustes.php", -2, ""];

$menu 	= [];
$menu[] = $_inicio;
if( in_array($_SESSION["cod_rol"], [1])) { // Administrador
	$menu[] = $_ocs;
	$menu[] = $_stocks;
	$menu[] = $_ovs;
	$menu[] = $_ots;
	$menu[] = $_maquinas;
	$menu[] = $_comp;
	$menu[] = $_comp_listado;
	$menu[] = $_comp_precios;
	$menu[] = $_conf;
	$menu[] = $_conf_ajustes;
	$menu[] = $_conf_ajustes_motivos;
	$menu[] = $_conf_comp;
	$menu[] = $_conf_comp_categorias;
	$menu[] = $_conf_eventos;
	$menu[] = $_conf_formas_p;
	$menu[] = $_conf_maq;
	$menu[] = $_conf_maq_modelos;
	$menu[] = $_conf_cpra;
	$menu[] = $_conf_cpra_estados;
	$menu[] = $_conf_ot;
	$menu[] = $_conf_ot_estados;
	$menu[] = $_conf_ot_tipos;
	$menu[] = $_conf_ot_categorias;
	$menu[] = $_conf_unid;
	$menu[] = $_conf_vta;
	$menu[] = $_conf_vta_estados;
	$menu[] = $_conf_vta_tipos;
	$menu[] = $_conf_pais;
	$menu[] = $_conf_pcias;
	$menu[] = $_conf_roles;
	$menu[] = $_personas;
	$menu[] = $_usuarios;
}
if( in_array($_SESSION["cod_rol"], [2])) { // Comercial
	$menu[] = $_ocs;
	$menu[] = $_stocks;
	$menu[] = $_ovs;
	$menu[] = $_maquinas;
	$menu[] = $_comp;
	$menu[] = $_comp_listado;
	$menu[] = $_comp_precios;
	$menu[] = $_personas;
}
if( in_array($_SESSION["cod_rol"], [3])) { // Produccion
	$menu[] = $_ocs;
	$menu[] = $_stocks;
	$menu[] = $_ots;
	$menu[] = $_maquinas;
	$menu[] = $_comp;
	$menu[] = $_comp_listado;
	$menu[] = $_comp_precios;
}
if( in_array($_SESSION["cod_rol"], [4])) { // Gerencia
	$menu[] = $_ocs;
	$menu[] = $_stocks;
	$menu[] = $_ovs;
	$menu[] = $_ots;
	$menu[] = $_maquinas;
	$menu[] = $_comp;
	$menu[] = $_comp_listado;
	$menu[] = $_comp_precios;
	$menu[] = $_conf;
	$menu[] = $_conf_ajustes;
	$menu[] = $_conf_ajustes_motivos;
	$menu[] = $_conf_comp;
	$menu[] = $_conf_comp_categorias;
	$menu[] = $_conf_eventos;
	$menu[] = $_conf_formas_p;
	$menu[] = $_conf_maq;
	$menu[] = $_conf_maq_modelos;
	$menu[] = $_conf_cpra;
	$menu[] = $_conf_cpra_estados;
	$menu[] = $_conf_ot;
	$menu[] = $_conf_ot_estados;
	$menu[] = $_conf_ot_tipos;
	$menu[] = $_conf_ot_categorias;
	$menu[] = $_conf_unid;
	$menu[] = $_conf_vta;
	$menu[] = $_conf_vta_estados;
	$menu[] = $_conf_vta_tipos;
	$menu[] = $_personas;
	$menu[] = $_usuarios;

}
$menu[] = $_salir;

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>
    <head>
        <link href="<?php echo $estilos; ?>" rel="stylesheet">
        <title><?php echo $titlepage; ?></title>   
        <link href="inc/bootstrap/css/select2.min.css" rel="stylesheet">
        <link href="inspinia/css/plugins/select2/select2.min.css" rel="stylesheet">	
        <link href="inspinia/css/bootstrap.min.css" rel="stylesheet">
        <link href="inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="inspinia/css/animate.css" rel="stylesheet">
        <link href="inspinia/css/style.css" rel="stylesheet">
        <link href="<?php echo $favicon; ?>" rel="icon" type="image/png"/>
    </head>
    <body style="background-color: #EEEEEE;"> <!-- 90,47,42    88,122,110      240,240,240-->
        <link href="<?php echo $favicon; ?>" rel="icon" type="image/png"/>
        <div class="modal fade" id="helpModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="name-header-modal" class="modal-title">AYUDA</h4>
                    </div>
                    <div class="modal-body text-left"  id="text-header-body-help">
                        <i>Paso 1:</i> 
                        <br />
                        <i>Paso 2:</i> 
                        <br />
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-cancelar" name="btn-cancelar" class="btn btn-default" data-dismiss="modal">Entendido!</button>
                    </div>
                </div>
            </div>
        </div>   
		<div id="wrapper">
			<nav class="navbar-default navbar-static-side" role="navigation">
                                <div class="sidebar-collapse">
					<ul class="nav metismenu" id="side-menu">
						<li class="nav-header">
							<div class="dropdown profile-element"> 
								<span>
									<img alt="image" height="40px;" width="40px;" class="img-circle" src="<?php echo "imagenes/loguito2.png"; ?>" />
								</span>
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
									<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION["nombre"]; ?></strong>
									 </span> <span class="text-muted text-xs block"><?php echo $_SESSION["cargo"]; ?> <b class="caret"></b></span> </span> 
								 </a>
								<ul class="dropdown-menu animated fadeInRight m-t-xs">
									<li><a href="cerrar.php">Salir</a></li>
								</ul>
							</div>
							<div class="logo-element">
								<img src="<?php echo $favicon2; ?>" height="20px">
							</div>
						</li>
						<?php
						foreach ($menu as $m) {
							if ($m[2] == 0){
								if ($m[1] == $_SESSION['menu']) {
									echo '<li class="active"><a href="' . $m[1] . '"><i class="fa ' . $m[3] . '"></i><span class="nav-label"><b>' . $m[0] . '</b></span></a></li>';
								} else {
									echo '<li><a href="' . $m[1] . '"><i class="fa ' . $m[3] . '"></i><span class="nav-label"><b>' . $m[0] . '</b></span></a></li>';
								}
							} 
							if ($m[2] > 0){
								echo '<li><a href="#"><i class="fa ' . $m[3] . '"></i><span class="nav-label"><b>' . $m[0] . '</b></span><span class="fa arrow"></span></a>';
								echo '<ul class="nav nav-second-level">';
								foreach ($menu as $men) {
                                                                        if ($men[2] * -1 == $m[2]){
                                                                                if ($men[4] > 0){
                                                                                    echo '<li>';
                                                                                    echo '<a href="#"><b>' . $men[0] . '</b> <span class="fa arrow"></span></a>';
                                                                                    echo '<ul class="nav nav-third-level">';
                                                                                    foreach ($menu as $_m) {
                                                                                        if ($men[4] * -1 == $_m[4]){
                                                                                            echo '<li>';
                                                                                            echo '<a href="' . $_m[1] . '"><b>' . $_m[0] . '</b></a>';
                                                                                            echo '</li>';
                                                                                        }
                                                                                    }    
                                                                                    echo '</ul>';
                                                                                    echo '</li>';
                                                                                } elseif ($men[4] < 0){

                                                                                } else {
                                                                                    if ($men[1] == $_SESSION['menu']) {
                                                                                            echo '<li class="active"><a href="' . $men[1] . '"><b>' . $men[0] . '</b></a></li>';
                                                                                    } else {
                                                                                            echo '<li><a href="' . $men[1] . '"><b>' . $men[0] . '</b></a></li>';
                                                                                    }
                                                                                }
                                                                        }
                                                                }
								echo '</ul>';
								echo '</li>';
							}
						}
						?>
						<!--
						<li class="active">
							<a href="#"><i class="fa fa-desktop"></i> <span class="nav-label">App Views</span>  <span class="pull-right label label-primary">SPECIAL</span></a>
							<ul class="nav nav-second-level">
								<li class="active"><a href="contacts.html">Contacts</a></li>
								<li><a href="profile.html">Profile</a></li>
								<li><a href="profile_2.html">Profile v.2</a></li>
								<li><a href="contacts_2.html">Contacts v.2</a></li>
								<li><a href="projects.html">Projects</a></li>
								<li><a href="project_detail.html">Project detail</a></li>
								<li><a href="activity_stream.html">Activity stream</a></li>
								<li><a href="teams_board.html">Teams board</a></li>
								<li><a href="social_feed.html">Social feed</a></li>
								<li><a href="clients.html">Clients</a></li>
								<li><a href="full_height.html">Outlook view</a></li>
								<li><a href="vote_list.html">Vote list</a></li>
								<li><a href="file_manager.html">File manager</a></li>
								<li><a href="calendar.html">Calendar</a></li>
								<li><a href="issue_tracker.html">Issue tracker</a></li>
								<li><a href="blog.html">Blog</a></li>
								<li><a href="article.html">Article</a></li>
								<li><a href="faq.html">FAQ</a></li>
								<li><a href="timeline.html">Timeline</a></li>
								<li><a href="pin_board.html">Pin board</a></li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">Menu Levels </span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li>
									<a href="#">Third Level <span class="fa arrow"></span></a>
									<ul class="nav nav-third-level">
										<li>
											<a href="#">Third Level Item</a>
										</li>
										<li>
											<a href="#">Third Level Item</a>
										</li>
										<li>
											<a href="#">Third Level Item</a>
										</li>

									</ul>
								</li>
								<li><a href="#">Second Level Item</a></li>
								<li>
									<a href="#">Second Level Item</a></li>
								<li>
									<a href="#">Second Level Item</a></li>
							</ul>
						</li>-->
					</ul>

				</div>
			</nav>

			<div id="page-wrapper" class="gray-bg">
				<div class="row border-bottom">
					<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
						<div class="navbar-header">
							<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
							<form role="search" class="navbar-form-custom" >
								<div class="form-group">
                                                                    <input style="cursor: pointer;" type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search" value="<?php echo $_SESSION["breadcrumb"]; ?>" disabled>
								</div>
							</form>								
						</div>
						<ul class="nav navbar-top-links navbar-right">
							<li>
								<span class="m-r-sm text-muted welcome-message">Sistema de Gestión</span>
							</li>
							<li>
								<a href="cerrar.php">
									<i class="fa fa-sign-out"></i> Salir
								</a>
							</li>
						</ul>
                                            

					</nav>
				</div>
                                <br />

<style>
	.container{
		width: 95%;
	}
</style>

