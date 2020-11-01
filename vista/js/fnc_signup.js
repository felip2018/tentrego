//	FUNCION PARA EL REGISTRO DE USUARIOS
function registrarse()
{
	jQuery(".modal").modal("toggle");
	jQuery(".modal-title").html('Nuevo Usuario');
	jQuery(".modal-body").html('<form class="col-xs-12" id="form_registro_usuario">'+
							'<div class="form-group">'+
								'<p>Nombres (*)</p>'+
								'<input class="form-control" type="text" name="nombre" id="nombre" data-name="Nombres">'+
							'</div>'+
							'<div class="form-group">'+
								'<p>Apellidos (*)</p>'+
								'<input class="form-control" type="text" name="apellido" id="apellido" data-name="Apellidos">'+
							'</div>'+
							'<div class="form-group">'+
								'<p>Telefono (*)</p>'+
								'<input class="form-control" type="number" min="0" name="telefono" id="telefono" data-name="Telefono">'+
							'</div>'+
							'<div class="form-group">'+
								'<p>E-mail (*)</p>'+
								'<input class="form-control" type="text" name="email" id="email" data-name="E-mail">'+
							'</div>'+
							'<div class="form-group">'+
								'<p>Contraseña (*)</p>'+
								'<input class="form-control" type="password" name="contrasena" id="contrasena" data-name="Contraseña">'+
							'</div>'+
							'<div class="form-group">'+
								'<p>Repetir Contraseña (*)</p>'+
								'<input class="form-control" type="password" name="repetir_contrasena" id="repetir_contrasena" data-name="Repetir Contraseña">'+
							'</div>'+
							'<div class="form-group">'+
								'<table style="width: 100%;text-align: center;">'+
									'<tr>'+
										'<td style="width: 10%;"><input style="width: 20px;height: 20px;" type="checkbox" name="notificaciones" id="notificaciones" value="1" data-name="Recibir Notificaciones"></td>'+
										'<td style="width: 90%;"><p>Me gustaria recibir notificaciones de promociones via correo electrónico.</p></td>'+
									'</tr>'+
								'</table>'+
							'</div>'+
							'<div class="form-group">'+
								'<table style="width: 100%;text-align: center;">'+
									'<tr>'+
										'<td style="width: 10%;"><input style="width: 20px;height: 20px;" type="checkbox" name="terminos_condiciones" id="terminos_condiciones" value="1" data-name="Terminos y condiciones"></td>'+
										'<td style="width: 90%;"><p>Acepto los términos y condiciones y la Política de Privacidad y Tratamiento de Datos Personales.</p></td>'+
									'</tr>'+
								'</table>'+			
							'</div>'+
							'<hr>'+

							'<div id="alerta_formulario" class="alert alert-danger" style="display: none;"></div>'+

				'<!--<button title="Registrarse" type="button" class="btn btn-primary btn-block" onclick="validar_form_registro()">Registrarse</button>-->'+

	'</form>');

	jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	jQuery(".modal-btn-accept").click(function () {
		var nombre 				= jQuery("#nombre");
		var apellido 			= jQuery("#apellido");
		var telefono 			= jQuery("#telefono");
		var email 				= jQuery("#email");
		var contrasena 			= jQuery("#contrasena");
		var repetir_contrasena 	= jQuery("#repetir_contrasena");
		var terminos 			= jQuery("#terminos_condiciones");

		var campos = [nombre,apellido,telefono,email,contrasena,repetir_contrasena];
		var j = 6;
		
		jQuery("#alerta_formulario").html("");
		jQuery("#alerta_formulario").css("display","none");

		//	EVALUAR SI LOS CAMPOS DEL FORMULARIO ESTAN VACIOS
		for (var i = 0; i < campos.length; i++) 
		{
			if (campos[i].val() == "") 
			{
				jQuery("#alerta_formulario").css("display","block");
				jQuery("#alerta_formulario").html("El campo '"+campos[i].attr('data-name')+"' es obligatorio.");
				campos[i].focus();
				break;
			}
			else
			{
				j = j - 1;
			}
		}

		if (j == 0) 
		{
			var errores = [];
			
			// 	EVALUAR TIPOS DE DATOS INGRESADOS EN EL FORMULARIO (EXPRESIONES REGULARES)

			var exp_nombre = /^[a-zA-Z a-zA-Z]+$/;
			if (! exp_nombre.test(nombre.val())) 
			{
				errores.push("Error #1: No ingrese caracteres especiales en el campo 'Nombres'");
			}

			var exp_apellido = /^[a-zA-Z a-zA-Z]+$/;
			if (! exp_apellido.test(apellido.val())) 
			{
				errores.push("Error #2: No ingrese caracteres especiales en el campo 'Apellidos'");
			}

			var exp_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
			if (! exp_email.test(email.val())) 
			{
				errores.push("Error #3: El 'E-mail' ingresado no cumple con la estructura de correo electrónico.");
			}

			if (errores.length == 0) 
			{

				if (terminos.prop('checked')) 
				{

					if (contrasena.val() === repetir_contrasena.val()) 
					{
						var form 		= document.getElementById('form_registro_usuario');
						var formData 	= new FormData(form);

						jQuery.ajax({
							type:"POST",
							url:"vista/ajax/ajax_registro.php?action=registrar",
							data: formData,
							contentType:false,
							processData:false,
							success:function (respuesta){
								
								jQuery("#espera").css("display","none");
								console.log(respuesta);
								var jsonResponse = JSON.parse(respuesta);

								if (jsonResponse.status == "success") 
								{
									jQuery(".modal-title").html('Registro exitoso');
									jQuery(".modal-body").html('Felicidades, el registro se realizo correctamente.<br>Procede a validar tu cuenta desde tu correo electronico.');
									jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

									jQuery(".modal-btn-accept").click(function () {
										window.location.reload();
									});
								}
								else if (jsonResponse.status == "registrado") 
								{
									jQuery(".modal-title").html('Error de registro');
									jQuery(".modal-body").html('El correo electrónico ya se encuentra en uso.');
									jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

									jQuery(".modal-btn-accept").click(function () {
										jQuery(".modal").modal('toggle');
									});
								}
								else
								{
									console.log(respuesta);
								}

							}
						});

					}
					else
					{
						console.log("Las claves no coinciden");
						jQuery("#alerta_formulario").css("display","block");
						jQuery("#alerta_formulario").html("¡Las contraseñas con coinciden!");
					}
				}
				else
				{
					console.log("No ha aceptado los terminos y condiciones");
					jQuery("#alerta_formulario").css("display","block");
					jQuery("#alerta_formulario").html("¿No esta de acuerdo con nuestra politica de términos y condiciones?");
				}
			}
			else
			{
				for (var i = 0; i < errores.length; i++) 
				{
					jQuery("#alerta_formulario").css("display","block");
					jQuery("#alerta_formulario").html("");
					jQuery("#alerta_formulario").append('> '+errores[i]+'<br>');
				}
			}
		}

	});

}