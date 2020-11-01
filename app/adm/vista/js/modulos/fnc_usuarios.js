/*REGISTRAR USUARIOS*/
function nuevo_usuario()
{
	$("#panel_animado").css("display","block");
	$("#contenido_animado").load("vista/modulos/usuarios/nuevo_usuario.php");
	//$(".modal").modal('toggle');
	//$(".modal-title").html('Registro de usuario');
	//$(".modal-body").load("vista/modulos/usuarios/nuevo_usuario.php");
	//$(".modal-footer").html('');
}

/*VALIDACION Y REGISTRO DE USUARIO*/
function salvar_usuario(ac)
{
	var errores = [];

	var id_tipo_identi 	= $("#id_tipo_identi");
	var num_identi 		= $("#num_identi");
	var nombre			= $("#nombre");
	var apellido 		= $("#apellido");
	var email 			= $("#email");
	var telefono 		= $("#telefono");
	var id_perfil 		= $("#id_perfil");

	var campos = [id_tipo_identi,num_identi,nombre,apellido,email,telefono,id_perfil];
	var j = 7;

	$("#alert_registro").css("display","none");
	$(".form-control").css("border","1px solid #AAA");

	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == "")
		{
			$("#alert_registro").css("display","block");
			$("#alert_registro").html("Diligencie el campo en el formulario para continuar!");
			campos[i].css("border","2px solid red");
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
		var exp1 = /[0-9]{1}/;
		if (! exp1.test(id_tipo_identi.val())) 
		{
			errores.push("Error #1: Selección invalida en el campo 'Tipo de Identificación'");
		}

		var exp2 = /[0-9]/;
		if (! exp2.test(num_identi.val())) 
		{
			errores.push("Error #2: Valor invalido en el campo 'Numero de Identificación'");
		}

		var exp3 = /[a-zA-Z]/;
		if (! exp3.test(nombre.val())) 
		{
			errores.push("Error #3: No ingrese caracteres especiales en el campo 'Primer Nombre'");
		}

		if (! exp3.test(apellido.val())) 
		{
			errores.push("Error #5: No ingrese caracteres especiales en el campo 'Primer Apellido'");
		}

		var exp5 = /\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})/;
		if (! exp5.test(email.val())) 
		{
			errores.push("Error #7: El 'E-mail' ingresado no cumple con la estructura básica.");
		}

		if (! exp1.test(id_perfil.val())) 
		{
			errores.push("Error #8: Selección invalida en el campo 'Perfil'");
		}


		if (errores.length == 0) 
		{
			$(".modal").modal('toggle');
			$(".modal-title").html('Registrar nuevo usuario.');
			$(".modal-body").html('¿Desea registrar este usuario en el sistema?');
			$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			$(".modal-btn-accept").click(function () {
				
				var form 		= document.getElementById('form_registro_usuario');
				var formData 	= new FormData(form);

				$.ajax({
					type:"POST",
					url:"vista/ajax/ajax_usuarios.php?ac="+ac,
					data: formData,
					contentType:false,
					processData:false,
					success:function (respuesta) 
					{
						console.log(respuesta);
						var jsonResponse = JSON.parse(respuesta);

						if (jsonResponse.estado == "registrado") 
						{
							$(".modal-title").html('Registro exitoso');
							$(".modal-body").html('Se ha registrado el usuario correctamente en el sistema.')
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('usuarios');
							});
						}
						else if(jsonResponse.estado == "ya_existe")
						{
							$(".modal-title").html('Registro invalido');
							$(".modal-body").html('El usuario ya se encuentra registrado en el sistema.')
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
							});
						}
						else if(jsonResponse.estado == "actualizado")
						{
							$(".modal-title").html('Actualizacion exitosa');
							$(".modal-body").html('Se ha actualizado el usuario de forma correcta en el sistema.')
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('usuarios');
							});
						}
						else if(jsonResponse.estado == "error")
						{
							$(".modal-title").html('Ha ocurrido un error!');
							$(".modal-body").html(jsonResponse.data);
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
							});
						}
					}
				})
			});

		}
		else
		{
			$("#alert_registro").css("display","block");
			$("#alert_registro").html("");

			for (var i = 0; i < errores.length; i++) 
			{
				$("#alert_registro").append("> "+errores[i]+"<br>");
			}

			console.log(errores);
		}

	}

}

/*EDITAR USUARIO*/
function editar_usuario(pk_usuario)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/usuarios/editar_usuario.php",
		data:('pk_usuario='+pk_usuario)
	}).done(function (respuesta) {
		$("#panel_animado").css("display","block");
		$("#contenido_animado").html(respuesta);
	})
}

/*ESTADO USUARIO*/
function estado_usuario(estado,pk_usuario)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_usuarios.php?ac=3",
		data:('estado='+estado+'&pk_usuario='+pk_usuario)
	}).done(function(respuesta) {
		var jsonResponse = JSON.parse(respuesta);
		if (jsonResponse.estado == "success") 
		{
			loadPage('usuarios');
		}
		else if(jsonResponse.estado == "error")
		{
			$(".modal").modal('toggle');
			$(".modal-title").html('Ha ocurrido un error!');
			$("-modal-body").html(jsonResponse.data);
			$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			$(".modal-btn-accept").click(function () {
				$(".modal").modal('toggle');
			});
		}
	})
}