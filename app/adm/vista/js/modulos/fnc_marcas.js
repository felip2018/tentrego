// 	AGREGAR NUEVA MARCA
function nueva_marca()
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/marcas/nueva_marca.php",
		success:function (response) {
			$("#panel_animado").css("display","block");
			$("#contenido_animado").html(response);
		}
	});
}

//	VALIDACION DE FORMULARIO DE MARCA
function salvar_marca(ac)
{
	$("#alert_registro").css("display","none");
	$("#alert_registro").html("");

	var marca = $("#nombre");
	if (marca.val() != "") 
	{
		switch(ac)
		{
			case '1':
				// 	REGISTRO
				$(".modal").modal('toggle');
				$(".modal-title").html('¿Desea registrar esta Marca en el sistema?');
				$(".modal-body").html('Da click en <b>Aceptar</b> para realizar el registro');
				$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				$(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_marca');
					var formData 	= new FormData(form);

					$.ajax({
						type:"POST",
						url:"vista/ajax/ajax_marcas.php?ac=1",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							console.log(response);
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "registrado") 
							{
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('marcas');
							}
							else if (jsonResponse.estado == "ya_existe") 
							{
								$(".modal-title").html('No se puede realizar el registro');
								$(".modal-body").html("La marca ingresada ya se encuentra registrada en el sistema.");
								$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								$(".modal-btn-accept").click(function () {
									$(".modal").modal('toggle');
								});
							}
							else
							{
								$(".modal-title").html('Ha ocurrido un error!');
								$(".modal-body").html(jsonResponse.data);
								$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								$(".modal-btn-accept").click(function () {
									$(".modal").modal('toggle');
								});
							}
						}
					});
				});

				break;

			case '2':
				// 	ACTUALIZACION
				$(".modal").modal('toggle');
				$(".modal-title").html('¿Desea actualizar esta Marca en el sistema?');
				$(".modal-body").html('Da click en <b>Aceptar</b> para realizar la actualización');
				$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				$(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_marca');
					var formData 	= new FormData(form);

					$.ajax({
						type:"POST",
						url:"vista/ajax/ajax_marcas.php?ac=2",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "actualizado") 
							{
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('marcas');
							}
							else
							{
								$(".modal-title").html('Ha ocurrido un error!');
								$(".modal-body").html(jsonResponse.data);
								$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								$(".modal-btn-accept").click(function () {
									$(".modal").modal('toggle');
								});
							}
						}
					});
				});
				break;
		}
	}
	else
	{
		$("#alert_registro").css("display","block");
		$("#alert_registro").html("Ingrese el nombre de la nueva marca a registrar");
		marca.focus();
	}
}

//	EDITAR MARCA
function editar_marca(id_marca)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/marcas/editar_marca.php",
		data:{
			id_marca: id_marca
		},
		success:function (response) {
			$("#panel_animado").css("display","block");
			$("#contenido_animado").html(response);
		}
	});
}

//	ACTUALIZAR ESTADO DE MARCA
function estado_marca(estado,id_marca)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_marcas.php?ac=3",
		data:{
			estado: 	estado,
			id_marca: 	id_marca
		},
		success:function (response) {
			console.log(response);
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "ok") 
			{
				loadPage('marcas');
			}
			else
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
}