/*REGISTRAR CATEGORIAS*/
function nueva_categoria()
{
	$("#panel_animado").css("display","block");
	$("#contenido_animado").load("vista/modulos/categorias/nueva_categoria.php");
}

/*VALIDACION Y REGISTRO DE CATEGORIA*/
function salvar_categoria(ac)
{
	var errores = [];

	var nombre			= $("#nombre");
	var descripcion 	= $("#descripcion");

	var campos = [nombre,descripcion];
	var j = 2;

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
		var exp3 = /[a-zA-Z0-9 a-zA-Z0-9]/;
		if (! exp3.test(nombre.val())) 
		{
			errores.push("Error #1: No ingrese caracteres especiales en el campo 'Nombre'");
		}

		if (! exp3.test(descripcion.val())) 
		{
			errores.push("Error #2: No ingrese caracteres especiales en el campo 'Descripcion'");
		}

		
		if (errores.length == 0) 
		{
			$(".modal").modal('toggle');
			$(".modal-title").html('¿Desea registrar esta Categoria en el sistema?');
			$(".modal-body").html('');
			$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			$(".modal-btn-accept").click(function () {
				
				var form 		= document.getElementById('form_registro_categoria');
				var formData 	= new FormData(form);

				$.ajax({
					type:"POST",
					url:"vista/ajax/ajax_categorias.php?ac="+ac,
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
							$(".modal-body").html('Se ha registrado la categoria correctamente en el sistema.')
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('categorias');
							});
						}
						else if(jsonResponse.estado == "ya_existe")
						{
							$(".modal-title").html('Registro invalido');
							$(".modal-body").html('La categoria ya se encuentra registrada en el sistema.')
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
							});
						}
						else if(jsonResponse.estado == "actualizado")
						{
							$(".modal-title").html('Actualizacion exitosa');
							$(".modal-body").html('Se ha actualizado la categoria de forma correcta en el sistema.')
							$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

							$(".modal-btn-accept").click(function () {
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('categorias');
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

/*EDITAR CATEGORIA*/
function editar_categoria(id_categoria)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/categorias/editar_categoria.php",
		data:('id_categoria='+id_categoria)
	}).done(function (respuesta) {
		$("#panel_animado").css("display","block");
		$("#contenido_animado").html(respuesta);
	})
}

/*ESTADO CATEGORIA*/
function estado_categoria(estado,id_categoria)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_categorias.php?ac=3",
		data:('estado='+estado+'&id_categoria='+id_categoria)
	}).done(function(respuesta) {
		var jsonResponse = JSON.parse(respuesta);
		if (jsonResponse.estado == "success") 
		{
			loadPage('categorias');
		}
		else if(jsonResponse.estado == "error")
		{
			$(".modal").modal('toggle');
			$(".modal-title").html('Ha ocurrido un error!');
			$(".modal-body").html(jsonResponse.data);
			$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

			$(".modal-btn-accept").click(function () {
				$(".modal").modal('toggle');
			});
		}
	});
}

// 	AGREGAR NUEVA CLASIFICACION DE CATEGORIA
function agregar_clasificacion(id_categoria,categoria)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/categorias/nueva_clasificacion.php",
		data:{
			id_categoria: 	id_categoria,
			categoria: 		categoria
		},
		success:function (response) {
			$("#panel_animado").css("display","block");
			$("#contenido_animado").html(response);
		}
	});
}

//	VALIDACION DE FORMULARIO DE CLASIFICACION
function salvar_clasificacion(ac)
{
	$("#alert_registro").css("display","none");
	$("#alert_registro").html("");

	var clasificacion = $("#nombre");
	if (clasificacion.val() != "") 
	{
		switch(ac)
		{
			case '4':
				// 	REGISTRO
				$(".modal").modal('toggle');
				$(".modal-title").html('¿Desea registrar esta Clasificación en el sistema?');
				$(".modal-body").html('Da click en <b>Aceptar</b> para realizar el registro');
				$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				$(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_clasificacion');
					var formData 	= new FormData(form);

					$.ajax({
						type:"POST",
						url:"vista/ajax/ajax_categorias.php?ac=4",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "registrado") 
							{
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('categorias');
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

			case '5':
				// 	ACTUALIZACION
				$(".modal").modal('toggle');
				$(".modal-title").html('¿Desea actualizar esta Clasificación en el sistema?');
				$(".modal-body").html('Da click en <b>Aceptar</b> para realizar la actualización');
				$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				$(".modal-btn-accept").click(function () {

					var form 		= document.getElementById('form_registro_clasificacion');
					var formData 	= new FormData(form);

					$.ajax({
						type:"POST",
						url:"vista/ajax/ajax_categorias.php?ac=5",
						data:formData,
						contentType:false,
						processData:false,
						success:function (response) {
							var jsonResponse = JSON.parse(response);
							if (jsonResponse.estado == "actualizado") 
							{
								$(".modal").modal('toggle');
								$("#panel_animado").css("display","none");
								loadPage('categorias');
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
		$("#alert_registro").html("Ingrese el nombre de la nueva clasificacion a registrar");
		clasificacion.focus();
	}
}

//	EDITAR CLASIFICACION
function editar_clasificacion(id_clasificacion,nombre_clasificacion)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/categorias/editar_clasificacion.php",
		data:{
			id_clasificacion: 	id_clasificacion,
			clasificacion: 		nombre_clasificacion
		},
		success:function (response) {
			$("#panel_animado").css("display","block");
			$("#contenido_animado").html(response);
		}
	});
}

//	ACTUALIZAR ESTADO DE CLASIFICACION
function estado_clasificacion(estado,id_clasificacion)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_categorias.php?ac=6",
		data:{
			estado: 			estado,
			id_clasificacion: 	id_clasificacion
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "ok") 
			{
				loadPage('categorias');
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