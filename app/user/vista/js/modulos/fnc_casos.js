//	CONSULTAR LISTA DE CASOS CREADOS POR EL CLIENTE
function casos(email) 
{
	console.log("Email ->"+ email);
}
//	VER DETALLE DEL CASO
function ver_caso(id_caso)
{
	//console.log("Id Caso -> "+id_caso);
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/casos/ver_caso.php",
		data:{
			id_caso: id_caso
		},
		success:function (response) {
			jQuery("#vista").html(response);
		}
	})
}

//	AGREGAR PROCESO DE ESTADO DE CASO
function agregar_proceso(id_caso,cliente,email)
{
	var estado 		= jQuery("#estado");
	var descripcion = jQuery("#descripcion");

	jQuery(".alert_estado").css("display","none");
	jQuery(".alert_estado").html('');

	if (estado.val() != '') 
	{
		if (descripcion.val() != '') 
		{
			jQuery(".modal").modal('toggle');
			jQuery(".modal-title").html('Actualizar estado');
			jQuery(".modal-body").html('¿Desea actualizar el estado del caso seleccionado?');
			jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			jQuery(".modal-btn-accept").click(function () {
				jQuery.ajax({
					type:"POST",
					url:"vista/ajax/ajax_casos.php?action=actualizarProceso",
					data:{
						id_caso: 		id_caso,
						cliente: 		cliente,
						email: 			email,
						estado: 		estado.val(),
						descripcion: 	descripcion.val()
					},
					success:function (response) {
						console.log(response);
						var jsonResponse = JSON.parse(response);
						if (jsonResponse.estado == "success") 
						{
							jQuery(".modal-title").html('Actualización de estado');
							jQuery(".modal-body").html('Se ha actualizado el estado del caso correctamente.');
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
								ver_caso(id_caso);
							});

						}
						else if (jsonResponse.estado == "success no email") 
						{
							jQuery(".modal-title").html('Actualización de estado');
							jQuery(".modal-body").html('Se ha actualizado el estado del caso correctamente.Pero no se ha podido registrar la notificación por correo electrónico.');
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
								ver_caso(id_caso);
							});

						}
						else if(jsonResponse.estado == "error")
						{
							jQuery(".modal-title").html('Ha ocurrido un error');
							jQuery(".modal-body").html(jsonResponse.data);
							jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							jQuery(".modal-btn-accept").click(function () {
								jQuery(".modal").modal('toggle');
							});
						}
						else
						{
							console.log(response);
						}
					}
				})
			});

		}
		else
		{
			jQuery(".alert_estado").css("display","block");
			jQuery(".alert_estado").html('Indique una descripción para el estado asignado.');
		}
	}
	else
	{
		jQuery(".alert_estado").css("display","block");
		jQuery(".alert_estado").html('Seleccione el estado del caso.');
	}
}