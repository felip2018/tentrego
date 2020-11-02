// 	AGREGAR NUEVA ATRIBUTO
function nuevo_atributo()
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm_atributos/nuevo_atributo.php",
		success:function (response) {
			jQuery("#panel_animado").css("display","block");
			jQuery("#contenido_animado").html(response);
		}
	});
}

//	VALIDACION DE FORMULARIO DE ATRIBUTO
function salvar_atributo(ac)
{
	jQuery("#alert_registro").css("display","none");
	jQuery("#alert_registro").html("");

	var nombre = jQuery("#nombre");
	if (nombre.val() != "") 
	{
		switch(ac)
		{
			case '1':
				// 	REGISTRO
				jQuery(".modal").modal('toggle');
				jQuery(".modal-title").html('¿Desea registrar esta Atributo en el sistema?');
				jQuery(".modal-body").html('Da click en <b>Aceptar</b> para realizar el registro');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_atributo');
					var formData 	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/adm_ajax_atributos.php?ac=1",
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
								loadPage('atributos');
							}
							else if (jsonResponse.estado == "ya_existe") 
							{
								jQuery(".modal-title").html('No se puede realizar el registro');
								jQuery(".modal-body").html("El atributo ingresado ya se encuentra registrado en el sistema.");
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
				jQuery(".modal-title").html('¿Desea actualizar este Atributo en el sistema?');
				jQuery(".modal-body").html('Da click en <b>Aceptar</b> para realizar la actualización');
				jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				jQuery(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_atributo');
					var formData 	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/adm_ajax_atributos.php?ac=2",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							console.log(response);
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "actualizado") 
							{
								jQuery(".modal").modal('toggle');
								jQuery("#panel_animado").css("display","none");
								loadPage('atributos');
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
		jQuery("#alert_registro").html("Ingrese el nombre del atributo a registrar");
		nombre.focus();
	}
}

//	EDITAR ATRIBUTO
function editar_atributo(id_atributo)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm_atributos/editar_atributo.php",
		data:{
			id_atributo: id_atributo
		},
		success:function (response) {
			jQuery("#panel_animado").css("display","block");
			jQuery("#contenido_animado").html(response);
		}
	});
}

//	ACTUALIZAR ESTADO DE ATRIBUTO
function estado_atributo(estado,id_atributo)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/adm_ajax_atributos.php?ac=3",
		data:{
			estado: 	estado,
			id_atributo:id_atributo
		},
		success:function (response) {
			console.log(response);
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "ok") 
			{
				loadPage('atributos');
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