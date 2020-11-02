/*REGISTRAR USUARIOS*/
function nuevo_usuario()
{
	jQuery("#panel_animado").css("display","block");
	jQuery("#contenido_animado").load("vista/modulos/adm_usuarios/nuevo_usuario.php");
	//jQuery(".modal").modal('toggle');
	//jQuery(".modal-title").html('Registro de usuario');
	//jQuery(".modal-body").load("vista/modulos/usuarios/nuevo_usuario.php");
	//jQuery(".modal-footer").html('');
}

/*VALIDACION Y REGISTRO DE USUARIO*/
function salvar_usuario(ac)
{
	var errores = [];

	var id_tipo_identi 	= jQuery("#id_tipo_identi");
	var num_identi 		= jQuery("#num_identi");
	var nombre			= jQuery("#nombre");
	var apellido 		= jQuery("#apellido");
	var email 			= jQuery("#email");
	var telefono 		= jQuery("#telefono");
	var id_perfil 		= jQuery("#id_perfil");

	var campos = [id_tipo_identi,num_identi,nombre,apellido,email,telefono,id_perfil];
	var j = 7;

	jQuery("#alert_registro").css("display","none");
	jQuery(".form-control").css("border","1px solid #AAA");

	for (var i = 0; i < campos.length; i++) 
	{
		if(campos[i].val() == "")
		{
			jQuery("#alert_registro").css("display","block");
			jQuery("#alert_registro").html("Diligencie el campo en el formulario para continuar!");
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
			jQuery(".modal").modal('toggle');
			jQuery(".modal-title").html('Registrar nuevo usuario.');
			jQuery(".modal-body").html('¿Desea registrar este usuario en el sistema?');
			jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			jQuery(".modal-btn-accept").click(function () {
				
				var form 		= document.getElementById('form_registro_usuario');
				var formData 	= new FormData(form);

				jQuery.ajax({
					type:"POST",
					url:"vista/ajax/adm_ajax_usuarios.php?ac="+ac,
					data: formData,
					contentType:false,
					processData:false,
					success:function (respuesta) 
					{
						console.log(respuesta);
						var jsonResponse = JSON.parse(respuesta);

						if (jsonResponse.estado == "registrado") 
						{
							jQuery(".modal-title").html('Registro exitoso');
							jQuery(".modal-body").html('Se ha registrado el usuario correctamente en el sistema.')
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('usuarios');
							});
						}
						else if(jsonResponse.estado == "ya_existe")
						{
							jQuery(".modal-title").html('Registro invalido');
							jQuery(".modal-body").html('El usuario ya se encuentra registrado en el sistema.')
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
							});
						}
						else if(jsonResponse.estado == "actualizado")
						{
							jQuery(".modal-title").html('Actualizacion exitosa');
							jQuery(".modal-body").html('Se ha actualizado el usuario de forma correcta en el sistema.')
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('usuarios');
							});
						}
						else if(jsonResponse.estado == "error")
						{
							jQuery(".modal-title").html('Ha ocurrido un error!');
							jQuery(".modal-body").html(jsonResponse.data);
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
							});
						}
					}
				})
			});

		}
		else
		{
			jQuery("#alert_registro").css("display","block");
			jQuery("#alert_registro").html("");

			for (var i = 0; i < errores.length; i++) 
			{
				jQuery("#alert_registro").append("> "+errores[i]+"<br>");
			}

			console.log(errores);
		}

	}

}

/*EDITAR USUARIO*/
function editar_usuario(pk_usuario)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm_usuarios/editar_usuario.php",
		data:('pk_usuario='+pk_usuario)
	}).done(function (respuesta) {
		jQuery("#panel_animado").css("display","block");
		jQuery("#contenido_animado").html(respuesta);
	})
}

/*ESTADO USUARIO*/
function estado_usuario(estado,pk_usuario)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/adm_ajax_usuarios.php?ac=3",
		data:('estado='+estado+'&pk_usuario='+pk_usuario)
	}).done(function(respuesta) {
		var jsonResponse = JSON.parse(respuesta);
		if (jsonResponse.estado == "success") 
		{
			loadPage('usuarios');
		}
		else if(jsonResponse.estado == "error")
		{
			jQuery(".modal").modal('toggle');
			jQuery(".modal-title").html('Ha ocurrido un error!');
			jQuery("-modal-body").html(jsonResponse.data);
			jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			jQuery(".modal-btn-accept").click(function () {
				jQuery(".modal").modal('toggle');
			});
		}
	})
}