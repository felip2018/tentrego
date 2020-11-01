// 	AGREGAR NUEVA MARCA
function nueva_marca()
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/marcas/nueva_marca.php",
		success:function (response) {
			jQuery("#panel_animado").css("display","block");
			jQuery("#contenido_animado").html(response);
		}
	});
}

//	VALIDACION DE FORMULARIO DE MARCA
function salvar_marca(ac)
{
	jQuery("#alert_registro").css("display","none");
	jQuery("#alert_registro").html("");

	var marca = jQuery("#nombre");
	if (marca.val() != "") 
	{
		switch(ac)
		{
			case '1':
				// 	REGISTRO
				jQuery(".modal").modal('toggle');
				jQuery(".modal-title").html('¿Desea registrar esta Marca en el sistema?');
				jQuery(".modal-body").html('Da click en <b>Aceptar</b> para realizar el registro');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_marca');
					var formData 	= new FormData(form);

					jQuery.ajax({
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
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('marcas');
							}
							else if (jsonResponse.estado == "ya_existe") 
							{
								jQuery(".modal-title").html('No se puede realizar el registro');
								jQuery(".modal-body").html("La marca ingresada ya se encuentra registrada en el sistema.");
								jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
								});
							}
							else
							{
								jQuery(".modal-title").html('Ha ocurrido un error!');
								jQuery(".modal-body").html(jsonResponse.data);
								jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
								});
							}
						}
					});
				});

				break;

			case '2':
				// 	ACTUALIZACION
				jQuery(".modal").modal('toggle');
				jQuery(".modal-title").html('¿Desea actualizar esta Marca en el sistema?');
				jQuery(".modal-body").html('Da click en <b>Aceptar</b> para realizar la actualización');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_marca');
					var formData 	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/ajax_marcas.php?ac=2",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "actualizado") 
							{
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('marcas');
							}
							else
							{
								jQuery(".modal-title").html('Ha ocurrido un error!');
								jQuery(".modal-body").html(jsonResponse.data);
								jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

								jQuery(".modal-btn-accept").click(function () {
									jQuery(".modal").modal('toggle');
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
		jQuery("#alert_registro").css("display","block");
		jQuery("#alert_registro").html("Ingrese el nombre de la nueva marca a registrar");
		marca.focus();
	}
}

//	EDITAR MARCA
function editar_marca(id_marca)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/marcas/editar_marca.php",
		data:{
			id_marca: id_marca
		},
		success:function (response) {
			jQuery("#panel_animado").css("display","block");
			jQuery("#contenido_animado").html(response);
		}
	});
}

//	ACTUALIZAR ESTADO DE MARCA
function estado_marca(estado,id_marca)
{
	jQuery.ajax({
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
				jQuery(".modal-title").html('Ha ocurrido un error!');
				jQuery(".modal-body").html(jsonResponse.data);
				jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {
					jQuery(".modal").modal('toggle');
				});
			}
		}
	})
}