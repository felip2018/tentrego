<?php
	require_once "controlador/con_cambio_clave.php";
	require_once "modelo/mod_cambio_clave.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Cambiar clave</title>
	<!--FAVICON-->
	<link rel="icon" href="../vista/img/favicon.png" type="image/png" sizes="20x20">
	
	<!--JQUERY-->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<!--JQUERY-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!--BOOTSTRAP-->
	<link rel="stylesheet" type="text/css" href="../vista/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="../vista/css/style.css">
	<script type="text/javascript" src="../vista/js/bootstrap/bootstrap.min.js"></script>
	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet">
	<!--FONT-AWESOME-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	
	
	<script type="text/javascript">
		//	VALIDACION DE FORMULARIO Y ACTUALIZACION DE CLAVE
		function actualizar_clave()
		{
			var email 			= $("#email");
			var codigo 			= $("#codigo");
			var nueva_clave 	= $("#nueva_clave");
			var repetir_clave 	= $("#repetir_clave");

			$(".alert_cambio_clave").css('display','none');
			$(".alert_cambio_clave").html('');

			if (nueva_clave.val() != '') 
			{
				if (repetir_clave.val() != '') 
				{
					if (nueva_clave.val() === repetir_clave.val()) 
					{
						$(".modal").modal('toggle');
						$(".modal-title").html('Cambiar contraseña');
						$(".modal-body").html('¿Desea actualizar la contraseña actual?');
						$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

						$(".modal-btn-accept").on("click",function () {
							$.ajax({
								type:"POST",
								url:"vista/ajax/ajax_cambio_clave.php?action=cambiarClave",
								data:{
									email: 			email.val(),
									codigo: 		codigo.val(),
									nueva_clave: 	nueva_clave.val()
								},
								success:function (response) {
									console.log(response);
									var jsonResponse = JSON.parse(response);
									if (jsonResponse.estado == "success") 
									{
										$(".modal-title").html('Cambio de clave exitoso');
										$(".modal-body").html('Se ha realizado el cambio de clave de forma exitosa.');
										$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

										$(".modal-btn-accept").on("click",function () {
											location.href="index.php";
										});

									}
									else if (jsonResponse.estado == "error") 
									{
										$(".modal-title").html('Ha ocurrido un error');
										$(".modal-body").html(jsonResponse.data);
										$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

										$(".modal-btn-accept").on("click",function () {
											$(".modal").modal('toggle');
										});

									}

								}
							})
						});

					}
					else
					{
						$(".alert_cambio_clave").css('display','block');
						$(".alert_cambio_clave").html('La contraseñas no coinciden, por favor verifique que sean iguales.');
					}
				}
				else
				{
					$(".alert_cambio_clave").css('display','block');
					$(".alert_cambio_clave").html('Verifique la nueva contraseña.');
				}
			}
			else
			{
				$(".alert_cambio_clave").css('display','block');
				$(".alert_cambio_clave").html('Digite la nueva contraseña.');
			}
		}
	</script>


</head>
<body>
	<div class="container-fluid">
		<div class="row" id="navbar">
			<div class="col-12" style="background: rgb(192,57,43);">
				<div class="row">
					<div class="col-12" style="padding: 10px;text-align: center;">
						<img src="../vista/img/logo_click_store_2.png" alt="Logo Click Store">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container" style="padding: 100px 10px 100px 10px;">
		<?php
			if (isset($_GET['email']) && isset($_GET['codigo_validacion'])) 
			{
				$email 				= $_GET['email'];
				$codigo_validacion 	= $_GET['codigo_validacion'];

				$cambio_clave = new CambioClaveCon();
				$estado = $cambio_clave -> validarPermisoCon($email,$codigo_validacion);

				if ($estado == "Activo") 
				{
					# SI SE PUEDE REALIZAR EL CAMBIO DE CLAVE

		?>
					
					<div class="alert alert-info">
						Cambiar Contraseña
					</div>
					<div class="row alert-success">
						<div class="col-4" style="margin: auto;border: 1px solid #DDD;padding: 20px;">
							<form id="form_cambio_clave">
								<input type="hidden" name="email" id="email" value="<?php echo $email;?>">
								<input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo_validacion;?>">
								<b>Nueva contraseña</b>
								<input class="form-control" type="password" name="nueva_clave" id="nueva_clave">
								<b>Repetir contraseña</b>
								<input class="form-control" type="password" name="repetir_clave" id="repetir_clave">
							</form>
							<div class="alert alert-warning alert_cambio_clave" style="display: none;"></div>
							<br>
							<button type="button" class="btn btn-primary btn-block" onclick="actualizar_clave()">
								<i class="fa fa-fingerprint"></i> Actualizar contraseña
							</button>
						</div>
					</div>
		<?php

				}
				elseif ($estado == "Inactivo")
				{
					# NO SE PUEDE REALIZAR EL CAMBIO DE CLAVE, EL CODIGO DE VALIDACION YA CADUCÓ
		?>
					<div class="alert alert-danger">
						No se puede realizar el cambio de clave debido a que el codigo de validación ha caducado. Recuerde que tiene dos dias para realizar su cambio de clave una vez se ha creado la solicitud. A continuación debe realizar de nuevo la solicitud para cambiar su contraseña desde el panel de acceso a <b>Click Store</b>.<br>
						
						<button type="button" class="btn btn-primary" onclick="window.open('index.php','_self')">Panel de acceso</button>

					</div>

		<?php
				}
				elseif ($estado == "Actualizado")
				{
					# NO SE PUEDE REALIZAR EL CAMBIO DE CLAVE, EL CODIGO DE VALIDACION YA CADUCÓ
		?>
					<div class="alert alert-success">
						Ya se hizo el cambio de clave con este código de verificación.
						
						<button type="button" class="btn btn-primary" onclick="window.open('index.php','_self')">Panel de acceso</button>

					</div>

		<?php
				}
			}
			else
			{
				#	NO SE PUEDE MOSTRAR EL CONTENIDO
		?>
				<div class="alert alert-danger">
					No se puede realizar el cambio de clave por los valores establecidos.
				</div>
		<?php
			}
		?>
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
</body>