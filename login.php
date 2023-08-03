<?php

session_start();
$titlepage = "VICA - Ingreso";

?>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $titlepage; ?></title>

	<link rel="icon" type="image/png" href="imagenes/loguito.png" />
		
    <link href="inspinia/css/bootstrap.min.css" rel="stylesheet">
    <link href="inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="inspinia/css/animate.css" rel="stylesheet">
    <link href="inspinia/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">
				<?php $imagen = "imagenes/icono.png"; ?>
				<img src="<?php echo $imagen; ?>" height="150" width="150">
				</h1>
				

            </div>
            <p>Iniciar Sesión</p>
            <form class="m-t" role="form" action="#">
                <div class="form-group">
                    <input type="text" id="inputUser" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" id="ingresar" class="btn btn-primary block full-width m-b boton_marron_carni">Ingresar</button>

            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="inspinia/js/jquery-3.1.1.min.js"></script>
    <script src="inspinia/js/bootstrap.min.js"></script>

</body>

</html>

<script src="inc/js/login_js.js"></script>