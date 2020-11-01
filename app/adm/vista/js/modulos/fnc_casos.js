//	VER DETALLE DEL CASO
function ver_caso(id_caso)
{
	//console.log("Id Caso -> "+id_caso);
	$.ajax({
		type:"POST",
		url:"vista/modulos/casos/ver_caso.php",
		data:{
			id_caso: id_caso
		},
		success:function (response) {
			$("#vista").html(response);
		}
	})
}

//	AGREGAR PROCESO DE ESTADO DE CASO
function agregar_proceso(id_caso,cliente,email)
{
	var estado 		= $("#estado");
	var descripcion = $("#descripcion");

	$(".alert_estado").css("display","none");
	$(".alert_estado").html('');

	if (estado.val() != '') 
	{
		if (descripcion.val() != '') 
		{
			$(".modal").modal('toggle');
			$(".modal-title").html('Actualizar estado');
			$(".modal-body").html('¿Desea actualizar el estado del caso seleccionado?');
			$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			$(".modal-btn-accept").click(function () {
				$.ajax({
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
							$(".modal-title").html('Actualización de estado');
							$(".modal-body").html('Se ha actualizado el estado del caso correctamente.');
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
								ver_caso(id_caso);
							});

						}
						else if (jsonResponse.estado == "success no email") 
						{
							$(".modal-title").html('Actualización de estado');
							$(".modal-body").html('Se ha actualizado el estado del caso correctamente.Pero no se ha podido registrar la notificación por correo electrónico.');
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
								ver_caso(id_caso);
							});

						}
						else if(jsonResponse.estado == "error")
						{
							$(".modal-title").html('Ha ocurrido un error');
							$(".modal-body").html(jsonResponse.data);
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
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
			$(".alert_estado").css("display","block");
			$(".alert_estado").html('Indique una descripción para el estado asignado.');
		}
	}
	else
	{
		$(".alert_estado").css("display","block");
		$(".alert_estado").html('Seleccione el estado del caso.');
	}
}