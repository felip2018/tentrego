function verInfoUsuario() 
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_inicio.php",
		data:{
			modulo:"inicio",
			action:"informacionUsuario",
			email: localStorage.email
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			//console.log(jsonResponse);
			if (jsonResponse.estado == "ok") 
			{
				var alerta = [];
				var foto_perfil = (jsonResponse.data['foto'] == "")? "vista/img/sin_imagen.png" : "../adm/vista/modulos/usuarios/fotos/"+jsonResponse.data['foto'];

				jQuery(".informacion_usuario").html('');
				jQuery(".informacion_usuario").html('<p>Información de Usuario</p>'+
												'<div class="alert alert-warning alert_info" style="display:none;"></div>'+
												'<div class="text-center">'+
													'<img id="foto_perfil" src="'+foto_perfil+'" alt="Foto de Perfil" style="width:200px;height:200px;border-radius:200px;">'+
												'</div>'+
												'<hr>'+
												'<form id="form_info_usuario">'+
													'<input class="form-control" type="hidden" name="modulo" value="inicio">'+
													'<input class="form-control" type="hidden" name="action" value="actualizarInfoUsuario">'+
													'<input class="form-control" type="hidden" name="pk_email" id="pk_email" value="'+jsonResponse.data['email']+'">'+
													'<b>Nombres</b>'+
													'<input class="form-control" type="text" name="nombre" id="nombre" value="'+jsonResponse.data['nombre']+'" data-name="Nombres">'+
													'<b>Apellidos</b>'+
													'<input class="form-control" type="text" name="apellido" id="apellido" value="'+jsonResponse.data['apellido']+'" data-name="Apellidos">'+
													'<b>Cedula</b>'+
													'<input class="form-control" type="text" name="num_identi" id="num_identi" value="'+jsonResponse.data['num_identi']+'" data-name="Cedula">'+
													'<b>Teléfono</b>'+
													'<input class="form-control" type="text" name="telefono" id="telefono" value="'+jsonResponse.data['telefono']+'" data-name="Teléfono">'+
													'<b>Dirección principal</b>'+
													'<input class="form-control" type="text" name="direccion" id="direccion" value="'+jsonResponse.data['direccion']+'" data-name="Dirección">'+
													'<b>Foto de perfil</b>'+
													'<input class="form-control" type="file" name="foto" id="foto">'+
													'<hr>'+
													'<button type="button" class="btn btn-success btn-block btn_update_data">'+
														'Guardar cambios'+
													'</button>'+

												'</form>');

				if (jsonResponse.data['num_identi'] == 0) {
					jQuery("#num_identi").css("border","1px solid red");
					//alerta[0] = "Actualiza tu número de identificación.";
					alerta.push("Actualiza tu número de identificación.");
				}

				if (jsonResponse.data['telefono'] == "") {
					jQuery("#telefono").css("border","1px solid red");
					//alerta[1] = "Ingresa tu telefono principal para la confirmación de tus pedidos.";
					alerta.push("Ingresa tu telefono principal para la confirmación de tus pedidos.");
				}

				if (jsonResponse.data['direccion'] == "") {
					jQuery("#direccion").css("border","1px solid red");
					//alerta[2] = "Ingresa tu dirección principal para el envio de tus pedidos.";
					alerta.push("Ingresa tu dirección principal para el envio de tus pedidos.");
				}

				if (alerta.length > 0) {
					jQuery(".alert_info").css("display","block");
					for (var i = 0; i < alerta.length; i++) {
						jQuery(".alert_info").append("- "+alerta[i]+"<br>");
					}
				}


				jQuery(".btn_update_data").click(function () {

					jQuery(".alert_info").css("display","block");
					jQuery(".alert_info").html("");

					var nombre 		= jQuery("#nombre");
					var apellido 	= jQuery("#apellido");
					var num_identi 	= jQuery("#num_identi");
					var telefono 	= jQuery("#telefono");
					var direccion 	= jQuery("#direccion");

					var campos = [nombre,apellido,num_identi,telefono,direccion];
					var j = 5;

					for (var i = 0; i < campos.length; i++) 
					{
						if(campos[i].val() == "")
						{
							jQuery(".alert_info").css("display","block");
							jQuery(".alert_info").html("Diligencie el campo '"+campos[i].attr('data-name')+"' para continuar.");
							campos[i].focus();
							break;
						}
						else
						{
							if (campos[i] == num_identi && campos[i].val() == '0') 
							{
								jQuery(".alert_info").css("display","block");
								jQuery(".alert_info").html("Ingrese un número de identificación válido.");
								campos[i].focus();
								break;		
							}
							else
							{
								j = j - 1;
							}
						}
					}

					if (j == 0) 
					{
						jQuery(".modal").modal("toggle");
						jQuery(".modal-title").html("Actualización de datos.");
						jQuery(".modal-body").html("¿Desea actualizar la información básica de su cuenta?");
						jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

						jQuery(".modal-btn-accept").click(function () {

							var form 		= document.getElementById('form_info_usuario');
							var formData 	= new FormData(form);

							jQuery.ajax({
								type:"POST",
								url:"vista/ajax/user_ajax_inicio.php",
								data: formData,
								contentType:false,
								processData:false,
								success:function (response) {
									//console.log(response);
									var jsonResponse = JSON.parse(response);
									if (jsonResponse.estado == "actualizado") 
									{
										jQuery(".modal-title").html("Actualización exitosa.");
										jQuery(".modal-body").html("Se ha actualizado la información correctamente.");
										jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

										jQuery(".modal-btn-accept").click(function () {
											location.reload();
										})

									}
									else if (jsonResponse.estado == "error") 
									{
										jQuery(".modal-title").html("Ha ocurrido un error!");
										jQuery(".modal-body").html(jsonResponse.data);
										jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

										jQuery(".modal-btn-accept").click(function () {
											jQuery(".modal").modal("toggle");
										});
									}
								}
							})
						})

					}
				})


			}
			else if (jsonResponse.estado == "vacio") 
			{
				jQuery(".modal-title").html("Error de cuenta");
				jQuery(".modal-body").html("No se ha encontrado información del usuario, inicie sesión nuevamente.");

				jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function() {
					localStorage.removeItem("acceso");
					localStorage.removeItem("id_tipo_identi");
					localStorage.removeItem("num_identi");
					localStorage.removeItem("nombre");
					localStorage.removeItem("email");
					localStorage.removeItem("telefono");
					localStorage.removeItem("id_perfil");
					localStorage.removeItem("clave");
					localStorage.removeItem("foto");
					localStorage.removeItem("fecha_usuario");
					localStorage.removeItem("estado");
					localStorage.removeItem("perfil");
					localStorage.removeItem("sesion");
					location.href = "../index.php";
				});
			}
			else if (jsonResponse.estado == "error") 
			{
				jQuery(".modal-title").html("¡Ha ocurrido un error!");
				jQuery(".modal-body").html(jsonResponse.data);

				jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function() {
					jQuery(".modal").modal('toggle');
				});
			}
		}
	});
}

function conteoPedidosUsuario() 
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_inicio.php",
		data:{
			modulo:"inicio",
			action:"pedidosUsuario",
			email: localStorage.email
		},
		success:function (response) {
			//console.log(response);
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "success") 
			{
				jQuery(".pedidos_usuario").html('<p>Pedidos de usuario</p>'+
											'<table class="table table-striped">'+
												'<thead>'+
													'<tr><th>Estado</th><th>#</th></tr>'+
												'</thead>'+
												'<tbody>'+
													'<tr><td>Por pagar</td><td>'+jsonResponse.data["por_pagar"]+'</td></tr>'+
													'<tr><td>Cancelados</td><td>'+jsonResponse.data["cancelado"]+'</td></tr>'+
													'<!--<tr><td>Pagados</td><td>'+jsonResponse.data["pagado"]+'</td></tr>-->'+
													'<tr><td>Entregados</td><td>'+jsonResponse.data["entregado"]+'</td></tr>'+
												'</tbody>'+
										   '</table>');
			}
		}
	});
}