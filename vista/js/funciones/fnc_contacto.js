function enviar_form_contacto()
{
	var nombre 		= $("#nombre");
	var telefono 	= $("#telefono");
	var email 		= $("#email");
	var mensaje 	= $("#mensaje");

	var campos = [nombre,telefono,email,mensaje];
	var j = 4;

	$("#alerta_formulario_contacto").css("display","none");
	$("#alerta_formulario_contacto").html('');

	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == "")
		{
			$("#alerta_formulario_contacto").css("display","block");
			$("#alerta_formulario_contacto").html('Diligencie el campo "'+campos[i].attr("data-name")+'" para continuar');
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
		//VALIDACION MEDIANTE EXPRESIONES REGULARES
		var exp_nombre = /^[a-zA-Z a-zA-Z]+$/;
		if (! exp_nombre.test(nombre.val())) 
		{
			errores.push("Error #1: No ingrese caracteres especiales en el campo 'Nombre'");
		}

		var exp_telefono = /^[0-9 0-9]+$/;
		if (! exp_telefono.test(telefono.val())) 
		{
			errores.push("Error #2: No ingrese caracteres especiales en el campo 'Telefono'");	
		}

		var exp_email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
		if (! exp_email.test(email.val())) 
		{
			errores.push("Error #3: El 'E-mail' ingresado no cumple con la estructura de correo electrónico.");
		}

		var exp_mensaje = /^[a-zA-Z a-zA-Z]+$/;
		if (! exp_mensaje.test(mensaje.val())) 
		{
			errores.push("Error #4: No ingrese caracteres especiales en el campo 'Mensaje'");
		}

		if (errores.length == 0) 
		{
			$(".modal").modal("toggle");
			$(".modal-title").html('Formulario de contacto');
			$(".modal-body").html('¿Deseas enviar el mensaje de contacto?');
			$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Enviar Mensaje</button>');

			$(".modal-btn-accept").click(function (response) {
				var form 		= document.getElementById('form_contacto');
				var formData 	= new FormData(form);

				$.ajax({
					type:"POST",
					url:"vista/ajax/ajax_contacto.php?action=enviarFormulario",
					data:formData,
					contentType:false,
					processData:false,
					success:function (response) {
						console.log(response);
						var jsonResponse = JSON.parse(response);
						if (jsonResponse.estado == "enviado") 
						{
							$(".modal-title").html('Enviado');
							$(".modal-body").html('El mensaje se ha enviado correctamente!');
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Enviar Mensaje</button>');

							$(".modal-btn-accept").click(function (response) {
								location.reload();
							});

						}
						else if (jsonResponse.estado == "error") 
						{
							$(".modal-title").html('Error');
							$(".modal-body").html(jsonResponse.data);
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Enviar Mensaje</button>');

							$(".modal-btn-accept").click(function (response) {
								$(".modal").modal("toggle");
							});							
						}

					}
				})

			})

		}
		else
		{
			$("#alerta_formulario_contacto").css("display","block");
			$("#alerta_formulario_contacto").html('');

			for (var i = 0; i < errores.length; i++) 
			{
				$("#alerta_formulario_contacto").append('- '+errores[i]+'<br>');
			}

		}
	}

}