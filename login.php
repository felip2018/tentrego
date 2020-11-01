<!DOCTYPE html>
<html>
<head>
	<title>TEntrego</title>
	
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" CONTENT="no-cache">
		
	<link rel="icon" href="vista/img/favicon.png" type="image/png" sizes="25x25">

	<link rel="stylesheet" type="text/css" href="vista/css/style.css">

	<!--IMPLEMENTACION DE BOOTSTRAB-->
	<link rel="stylesheet" type="text/css" href="vista/js/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="vista/css/style_login.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	
	
	<!--IMPLEMENTACION DE BOOTSTRAB-->
	<script type="text/javascript" src="vista/js/bootstrap/js/jquery.js"></script>
	<script type="text/javascript" src="vista/js/bootstrap/js/bootstrap.min.js"></script>


	<!--FUNCIONES JAVASCRIPT PARA EL INICIO DE LA SESION-->
	<script type="text/javascript" src="vista/js/fnc_login_facebook.js"></script>
	<script type="text/javascript" src="vista/js/fnc_login.js"></script>
	<script type="text/javascript" src="vista/js/fnc_signup.js"></script>
	<script type="text/javascript" src="vista/js/fnc_validate_account.js"></script>
	
	<!--IMPLEMENTACION DE FONT AWESOME-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<script>
		jQuery(document).ready(function () 
		{
			// EVALUAR SI YA HAY UNA SESION INICIADA
			if (localStorage.acceso != undefined) 
			{
				if (localStorage.id_perfil == 1) 
				{
					location.href = "app/adm/";
				}
				else if (localStorage.id_perfil == 2)
				{
					location.href = "app/user/";
				}
			}
			else
			{
				console.log("No se ha logueado!");
			}

		});

		function pulsar(e) 
		{
		    if (e.keyCode === 13 && !e.shiftKey) 
		    {
		        e.preventDefault();
		        validar_login();
		    }
		}

		//	CAMBIAR CLAVE DE USUARIO
		function cambiar_clave()
		{
			jQuery(".modal").modal('toggle');
			jQuery(".modal-title").html('Cambiar contraseña');
			jQuery(".modal-body").html('<p>Se te enviará al email un link para poder recuperar tu contraseña. Por favor ingresa el correo electrónico de tu cuenta:</p>'+
				'<input class="form-control" type="text" name="email" id="email"><hr>'+
				'<div class="alert alert-warning alert_cambio_clave" style="display:none;"></div>'+
				'<button class="btn btn-primary btn-block modal-btn-accept">Cambiar contraseña</button>');

			jQuery(".modal-footer").html('');

			jQuery(".modal-btn-accept").click(function () {
					
				jQuery(".alert_cambio_clave").css("display","none");
				jQuery(".alert_cambio_clave").html("");

				var email = jQuery("#email").val();
				if (email != '')
				{
					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/ajax_cambio_clave.php?action=solicitarCambioClave",
						data:{
							email: email
						},
						success:function (response) {
							console.log(response);
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "success") 
							{
								jQuery(".modal-title").html('Solicitud exitosa');
								jQuery(".modal-body").html('Se ha realizado la solicitud de cambio de clave correctamente, por favor revise su correo electrónico.');
								jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
								});
							}
							else if (jsonResponse.estado == "error") 
							{
								jQuery(".modal-title").html('Ha ocurrido un error');
								jQuery(".modal-body").html(jsonResponse.data);
								jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
								});
							}
						}
					})
				}
				else
				{
					jQuery(".alert_cambio_clave").css("display","block");
					jQuery(".alert_cambio_clave").html("Ingrese el email de tu cuenta de <b>Click Store</b>");
				}
			});

		}

	</script>

	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '320544408486189',
	      cookie     : true,
	      xfbml      : true,
	      version    : 'v3.0'
	    });
	      
	    FB.AppEvents.logPageView();   
	      
	  };

	  (function(d, s, id){
	     var js, fjs = d.getElementsByTagName(s)[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement(s); js.id = id;
	     js.src = "https://connect.facebook.net/en_US/sdk.js";
	     fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));
	</script>

</head>
<body>
	<?php
		if (isset($_GET['email']) && isset($_GET['codigo_validacion'])) 
		{
			// SE EJECUTA LA VALIDACION DE LA CUENTA
			echo "<script>
				validar_cuenta('" . $_GET['email'] . "','" . $_GET['codigo_validacion'] . "');
			  </script>";	
		}
	?>
	<div class="container pt-5">
		<div class="row" style="padding: 10px;">
			
			<div class="col-12">
				<div class="row">

					<!--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5"></div>-->
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5" id="panel_login" style="border-radius: 0px;text-align: center;margin: auto;">
						<div style="text-align: left;">
							<a href="../">	
								<i class="fa fa-chevron-left"></i> Volver
							</a>
						</div>

						<div style="background: rgb(192,57,43);">
							<img src="vista/img/logo_click_store_2.png" alt="Logo Click Store">
						</div>

						<form id="form_ingreso">
							
							<div class="row" style="padding: 10px;">
								
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
									<label for="login">Usuario</label>
									<input class="form-control" type="text" name="login" id="login">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
									<label for="clave">Contraseña</label>
									<input class="form-control" type="password" name="clave" id="clave" onkeypress="pulsar(event)">
								</div>
								<div id="alerta" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-danger" style="display: none;">
								</div>

							</div>
							<table style="width: 100%;">
								<tr>
									<td>
										<button type="button" class="btn btn-primary btn-block" onclick="validar_login()">
											<i class="fa fa-sign-in-alt"></i> Ingresar
										</button>
									</td>
									<td>
										<button type="button" class="btn btn-secondary btn-block" onclick="registrarse()">
											<i class="fa fa-user-plus"></i> Registrarse
										</button>
									</td>
								</tr>
							</table>
							
							<button type="button" class="btn btn-block mt-1 btn_facebook" style="background: rgb(66,103,168);color: #FFF;"> Continuar con Facebook</button>
						</form>
						
						<hr>

						<button type="button" class="btn btn-default btn-block" onclick="cambiar_clave()">
							<i class="fa fa-key"></i> ¿Olvidó su contraseña?
						</button>

						<hr>
						<p style="font-size: 10pt;color: #000;">&copy; Copyright 2018 Departamento de Tecnologia - <a href="https://www.nextytech.net" target="_blank">Netx&Tech</a> v1.0</p>
					</div>
				</div>
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