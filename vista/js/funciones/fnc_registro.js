function validar_form_registro() 
{
	var nombre 				= $("#nombre");
	var apellido 			= $("#apellido");
	var telefono 			= $("#telefono");
	var email 				= $("#email");
	var contrasena 			= $("#contrasena");
	var repetir_contrasena 	= $("#repetir_contrasena");

	var terminos 			= $("#terminos_condiciones");

	var campos = [nombre,apellido,telefono,email,contrasena,repetir_contrasena];
	var j = 6;

	$("#alerta_formulario").html("");
	$("#alerta_formulario").css("display","none");
	$(".form-control").css("border","1px solid #AAA");
	/*EVALUAR CAMPOS VACIOS*/
	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == "")
		{
			$("#alerta_formulario").css("display","block");
			$("#alerta_formulario").html("Diligencie el campo '"+campos[i].attr("data-name")+"' para continuar.");
			campos[i].css("border","1px solid red");
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
		/*EVALUAR TIPOS DE DATOS INGRESADOS EN EL FORMULARIO (EXPRESIONES REGULARES)*/

		var exp_nombre = /[a-zA-Z a-zA-Z]/;
		if (! exp_nombre.test(nombre.val())) 
		{
			errores.push("Error #1: No ingrese caracteres especiales en el campo 'Nombres'");
		}

		var exp_apellido = /[a-zA-Z a-zA-Z]/;
		if (! exp_apellido.test(apellido.val())) 
		{
			errores.push("Error #2: No ingrese caracteres especiales en el campo 'Apellidos'");
		}

		if (errores.length == 0) 
		{

			if (terminos.prop('checked')) 
			{

				if (contrasena.val() === repetir_contrasena.val()) 
				{
					$(".modal").modal("toggle");
					$(".modal-title").html('<img src="vista/img/logo_click_store.png" alt="Logo Click Store">');
					$(".modal-body").html('¿Deseas registrarte y hacer parte de nuestra comunidad?');
					$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

									
					$(".modal-btn-accept").click(function () {

						var form 		= document.getElementById('form_registro_usuario');
						var formData 	= new FormData(form);

						$.ajax({
							type:"POST",
							url:"vista/ajax/ajax_registro.php?action=registrar",
							data: formData,
							contentType:false,
							processData:false,
							success:function (respuesta){
								
								$("#espera").css("display","none");
								console.log(respuesta);
								var jsonResponse = JSON.parse(respuesta);

								if (jsonResponse.status === "success") 
								{
									//ENVIO DE EMAILS
									enviarEmails();

									$(".modal-title").html('Registro exitoso');
									$(".modal-body").html('Se ha realizado el registro correctamente, se ha enviado el enlace de validación de cuenta a tu correo electrónico.');
									$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');
									
									$(".modal-btn-accept").click(function () {
										window.location.reload();
									});
								}
								else if (jsonResponse.status === "registrado") 
								{
									$(".modal-title").html('Error de registro');
									$(".modal-body").html('El correo electrónico ingresado ya se encuentra en uso');
									$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

									
									$(".modal-btn-accept").click(function () {
										$(".modal").modal('toggle');
									});
								}
								else
								{
									console.log(respuesta);
								}

							}
						});

					});

				}
				else
				{
					console.log("Las claves no coinciden");
					$("#alerta_formulario").css("display","block");
					$("#alerta_formulario").html("¡Las contraseñas con coinciden!");
				}
			}
			else
			{
				console.log("No ha aceptado los terminos y condiciones");
				$("#alerta_formulario").css("display","block");
				$("#alerta_formulario").html("¿No esta de acuerdo con nuestra politica de términos y condiciones?");
			}
		}

	}

}

