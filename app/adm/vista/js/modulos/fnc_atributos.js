// 	AGREGAR NUEVA ATRIBUTO
function nuevo_atributo()
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/atributos/nuevo_atributo.php",
		success:function (response) {
			$("#panel_animado").css("display","block");
			$("#contenido_animado").html(response);
		}
	});
}

//	VALIDACION DE FORMULARIO DE ATRIBUTO
function salvar_atributo(ac)
{
	$("#alert_registro").css("display","none");
	$("#alert_registro").html("");

	var nombre = $("#nombre");
	if (nombre.val() != "") 
	{
		switch(ac)
		{
			case '1':
				// 	REGISTRO
				$(".modal").modal('toggle');
				$(".modal-title").html('¿Desea registrar esta Atributo en el sistema?');
				$(".modal-body").html('Da click en <b>Aceptar</b> para realizar el registro');
				$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				$(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_atributo');
					var formData 	= new FormData(form);

					$.ajax({
						type:"POST",
						url:"vista/ajax/ajax_atributos.php?ac=1",
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
								loadPage('atributos');
							}
							else if (jsonResponse.estado == "ya_existe") 
							{
								$(".modal-title").html('No se puede realizar el registro');
								$(".modal-body").html("El atributo ingresado ya se encuentra registrado en el sistema.");
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
				$(".modal-title").html('¿Desea actualizar este Atributo en el sistema?');
				$(".modal-body").html('Da click en <b>Aceptar</b> para realizar la actualización');
				$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				$(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_atributo');
					var formData 	= new FormData(form);

					$.ajax({
						type:"POST",
						url:"vista/ajax/ajax_atributos.php?ac=2",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							console.log(response);
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "actualizado") 
							{
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('atributos');
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
		$("#alert_registro").html("Ingrese el nombre del atributo a registrar");
		nombre.focus();
	}
}

//	EDITAR ATRIBUTO
function editar_atributo(id_atributo)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/atributos/editar_atributo.php",
		data:{
			id_atributo: id_atributo
		},
		success:function (response) {
			$("#panel_animado").css("display","block");
			$("#contenido_animado").html(response);
		}
	});
}

//	ACTUALIZAR ESTADO DE ATRIBUTO
function estado_atributo(estado,id_atributo)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_atributos.php?ac=3",
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