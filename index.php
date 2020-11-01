<?php
	session_start();
	require_once "controlador/con_navegacion.php";
	require_once "modelo/mod_navegacion.php";

	require_once "controlador/con_carrito.php";
	require_once "modelo/mod_carrito.php";

	if (!isset($_SESSION['carrito'])) {
		$_SESSION['carrito'] = new CarritoMod();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>TEntrego</title>
	<!--FAVICON-->
	<link rel="icon" href="./vista/img/favicon.png" type="image/png" sizes="20x20">
	
	
	<!--BOOTSTRAP-->
	<link rel="stylesheet" type="text/css" href="./vista/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="./vista/css/style.css">
	
	
	<!--<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">-->
	<link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed|Montserrat|Raleway" rel="stylesheet">
	
	<!--FONT-AWESOME-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	
	
	
</head>
<body>
	<div class="container-fluid">
		<div class="row" id="navbar">
			<div class="col-12" style="background: rgb(192,57,43);">
				<div class="row">
					<div class="col-xs-12 col-md-4" style="padding: 10px;text-align: center;">
						<img src="./vista/img/logo_click_store_2.png" alt="Logo Click Store">
					</div>

					<div class="col-xs-12 col-md-8" style="padding: 10px;text-align: right;color:#FFF;">
						<a class="btn_sup" href="./login.php" target="_blank"><i class="fa fa-sign-in-alt"></i> Ingresar</a>
						<a class="btn_sup" href="./registrarse"><i class="fa fa-user-plus"></i> Registrarse</a>
						<a class="btn_sup" href="./como_comprar"><i class="fa fa-question-circle"></i> ¿Como Comprar?</a>
					</div>	
				</div>
			</div>

			<div class="clearfix"></div>
			
			<div class="col-xs-12 col-md-12" style="padding: 10px;text-align: center;">
				<a href="./inicio"><i class="fa fa-home"></i> Inicio</a>
				<a href="./tienda"><i class="fa fa-store"></i> Tienda</a>
				<a href="./promociones"><i class="fa fa-bullhorn"></i> Promociones</a>
				<a href="./carrito_compra"><i class="fa fa-shopping-cart"></i> Carrito de Compras</a>
				<a href="./contactenos"><i class="fa fa-envelope"></i> Contactenos</a>
			</div>

		</div>

		<div class="row" id="content">
			<?php
				$navegacion = new NavegacionCon();
				$navegacion -> navegacionPagCon();
			?>
		</div>
		<div class="row" id="footer">
			<div class="col-xs-12 col-md-4">
				<h4>Acerca de</h4>
				<p>
					Somos una tienda en linea con presencia en bogotá, con el propósito de expandirnos a otros sectores de colombia. Queremos llegar a tí con los productos de mejor calidad disponibles en el mercado y a precios accesibles para todos.
				</p>
				<p>
					Otorgamos a nuestros clientes la posibilidad de adquirir beneficios a nombre de <b>Click Store</b> bien sea por su fidelidad y/o compromiso al comprar a través de la plataforma o también por hacer uso de sus redes sociales para compartir contenido.
				</p>
			</div>
			<div class="col-xs-12 col-md-4">
				<h4>Menú</h4>
				<a class="enlace_footer" href="./inicio"><i class="fa fa-home"></i> Inicio</a>
				<a class="enlace_footer" href="./tienda"><i class="fa fa-store"></i> Tienda</a>
				<a class="enlace_footer" href="./promociones"><i class="fa fa-bullhorn"></i> Promociones</a>
				<a class="enlace_footer" href="./carrito_compra"><i class="fa fa-shopping-cart"></i> Carrito</a>
				<a class="enlace_footer" href="./contactenos"><i class="fa fa-envelope"></i> Contactenos</a>
			</div>
			<div class="col-xs-12 col-md-4">
				<h4>Mi Cuenta</h4>
				<a href="./ingresar" class="enlace_footer"><i class="fa fa-user"></i> Ingresar</a></li>
				<a href="./registrarse" class="enlace_footer"><i class="fa fa-sign-in-alt"></i> Registrarse</a></li>
				<a href="./como_comprar" class="enlace_footer"><i class="fa fa-question-circle"></i> ¿Como Comprar?</a>
			</div>
			<div class="col-xs-12 col-md-12" style="padding: 10px;text-align: center;">
				<img src="./vista/img/logo_click_store_2.png" alt="Logo Click Store">
			</div>
			<div class="col-xs-12 col-md-12" style="padding: 10px;text-align: center;">
				<button class="btn btn-primary" style="border-radius: 20px;" onclick="window.open('https://www.facebook.com/CLICKSTOREBogota/','_blank')"><img src="./vista/img/facebook-square.svg" alt="Facebook Icon" height="25px" width="25px"></button>
				<button class="btn btn-primary" style="border-radius: 20px;" onclick="window.open('https://www.instagram.com/clickstorebogota/?hl=es','_blank')"><img src="./vista/img/instagram.svg" alt="Facebook Icon" height="25px" width="25px"></button>
			</div>
			<div class="col-xs-12 col-md-4" style="text-align: center; ">
				<p><i class="fa fa-home" style="color:#FFF;"></i> 12K Street , 45 Building Road Canada.</p>
			</div>
			<div class="col-xs-12 col-md-4" style="text-align: center; ">
				<p><i class="fa fa-phone" style="color:#FFF;"></i> +1234 758 839 , +1273 748 730</p>
			</div>
			<div class="col-xs-12 col-md-4" style="text-align: center; ">
				<p><i class="fa fa-at" style="color:#FFF;"></i> correo@email.com</p>
			</div>
			<div class="col-xs-12 col-md-12" style="text-align: center; ">
				<!--<p><i class="fa fa-copyright" style="color:#FFF;"></i> 2018 Next&Tech. Todos los derechos reservados.</p>-->
				<p>&copy 2020 TEntrego. Todos los derechos reservados, el registro o el uso de este sitio constituye la aceptación de nuestros <a href="./terminos" title="Términos y condiciones" style="color:#FFF;">Términos y condiciones</a>, así como también nuestras <a href="./politicas" style="color:#FFF;">Política de privacidad</a>. | Diseñado y desarrollado por <a href="https://www.nextytech.net" title="N&T" target="_blank" style="color:#FFF;">Next&Tech.net</a></p>
			</div>
		</div>
	</div>

    <!--VENTANA MODAL-->
	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          	<div class="modal-header">
	              	<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
	              	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  	<span aria-hidden="true">&times;</span>
	              	</button>
	            </div>
	            <div class="modal-body">
	            </div>
	            <div class="modal-footer">
	              <button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="espera">
      	<div class="alert alert-warning" id="espera_alert">
        	<i class="fa fa-spinner fa-spin" style="font-size: 20pt;"></i> Espere un momento mientras se procesa su petición...
      	</div>  
    </div>
	

    <!--JQUERY-->
	<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
	<!--JQUERY-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="./vista/js/bootstrap/bootstrap.min.js"></script>

    <!--FUNCIONES-->
	<script type="text/javascript" src="./vista/js/core.js"></script>
	<script type="text/javascript" src="./vista/js/funciones/fnc_registro.js"></script>
	<script type="text/javascript" src="./vista/js/funciones/fnc_tienda.js"></script>
	<script type="text/javascript" src="./vista/js/funciones/fnc_carrito.js"></script>
	<script type="text/javascript" src="./vista/js/funciones/fnc_info.js"></script>
	<script type="text/javascript" src="./vista/js/funciones/fnc_contacto.js"></script>

	<!--NOTIFICACIONES PUSH-->
	<script type="text/javascript" src="./vista/js/push_js/bin/push.min.js"></script>



	<!-- The core Firebase JS SDK is always required and must be listed first -->
	<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>

	<!-- TODO: Add SDKs for Firebase products that you want to use
	     https://firebase.google.com/docs/web/setup#available-libraries -->
	<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-analytics.js"></script>

	<script>
	  // Your web app's Firebase configuration
	  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
	  var firebaseConfig = {
	    apiKey: "AIzaSyA7HU_21fjiYQj6fSGOyBaSmbJSqk2YMjY",
	    authDomain: "teentrego-82444.firebaseapp.com",
	    databaseURL: "https://teentrego-82444.firebaseio.com",
	    projectId: "teentrego-82444",
	    storageBucket: "teentrego-82444.appspot.com",
	    messagingSenderId: "555056891785",
	    appId: "1:555056891785:web:2aa86f74121c9dcc728358",
	    measurementId: "G-5TTTQW1EPH"
	  };
	  // Initialize Firebase
	  firebase.initializeApp(firebaseConfig);
	  firebase.analytics();
	</script>
</body>
</html>