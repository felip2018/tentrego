function crear_resena(id_pedido,id_producto,email)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_mis_resenas.php",
		data:{
			action: 	"validarResena",
			id_pedido: 	id_pedido,
			id_producto:id_producto,
			email: 		email
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "sin resena") 
			{
				$(".modal").modal("toggle");
				$(".modal-title").html("Escribir reseña");
				$(".modal-body").html('<form id="form_resena_producto">'+
										'<b>Calificación del producto</b>'+
										 ' <p class="clasificacion">'+
										 '   <input id="radio1" type="radio" name="estrellas" value="5"><label for="radio1">★</label>'+
										 '   <input id="radio2" type="radio" name="estrellas" value="4"><label for="radio2">★</label>'+
										 '   <input id="radio3" type="radio" name="estrellas" value="3"><label for="radio3">★</label>'+
										 '   <input id="radio4" type="radio" name="estrellas" value="2"><label for="radio4">★</label>'+
										 '   <input id="radio5" type="radio" name="estrellas" value="1"><label for="radio5">★</label>'+
										 ' </p>'+
										'<b>Escribir reseña</b>'+
										'<textarea class="form-control" rows="5" name="resena" id="resena"></textarea>'+
										'<div class="alert alert-danger alert_resena" style="display:none;"></div>'+
										'<button type="button" class="btn btn-primary btn-block" onclick=salvar_resena("'+id_pedido+'","'+id_producto+'","'+email+'")>'+
											'<i class="fa fa-save"></i> Salvar reseña'+
										'</button>'+
									  '</form>');
				$(".modal-footer").html('');
			}
			else if (jsonResponse.estado == "existe") 
			{
				$(".modal").modal("toggle");
				$(".modal-title").html("Reseña creada");
				$(".modal-body").html("Ya existe una reseña de este producto para este pedido.<br>¿Deseas editar la reseña creada?");
				$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

				$(".modal-btn-accept").click(function () {
					$(".modal").modal("toggle");
					loadPage("mis_resenas");
				});
			}

		}
	});
}

function salvar_resena(id_pedido,id_producto,email) 
{
	console.log("Salvar Reseña");
	var resena = $("#resena");

	$(".alert_resena").css("display","none");
	$(".alert_resena").html("");

	if (resena.val() != "") 
	{
		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_resenas.php",
			data:{
				action: 		"salvarResena",
				id_pedido: 		id_pedido,
				id_producto: 	id_producto,
				email: 			email,
				calificacion: 	$('input:radio[name=estrellas]:checked').val(),
				comentarios: 	resena.val()
			},
			success:function (response) {
				//console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "registrado") 
				{
					$(".modal-title").html("Reseña registrada");
					$(".modal-body").html("La reseña del producto ha sido registrada correctamente.")
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
						ver_pedido(id_pedido);
					});
				}
				else if (jsonResponse.estado == "error") 
				{
					$(".modal-title").html("Ha ocurrido un error");
					$(".modal-body").html(jsonResponse.data)
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
					});
				}
				else
				{
					console.log(jsonResponse);
				}
			}
		});
	}
	else
	{
		$(".alert_resena").css("display","block");
		$(".alert_resena").html("Ingrese la reseña del producto.");
	}
}

function verListaResenas()
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/mis_resenas/listaResenas.php",
		data:{
			action: "listaResenas",
			email: 	localStorage.email
		},
		success:function (response) {
			$(".listaResenas").html(response);
		}
	});
}

function verResena(id_resena)
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/mis_resenas/ver_resena.php",
		data:{
			id_resena: 	id_resena
		},
		success:function (response) {
			$(".modal").modal("toggle");
			$(".modal-title").html('Reseña');
			$(".modal-body").html(response);
			$(".modal-footer").html('');
		}
	})
}

function actualizar_resena(id_pedido,id_producto,email)
{
	var resena = $("#resena");

	$(".alert_resena").css("display","none");
	$(".alert_resena").html("");

	if (resena.val() != "") 
	{
		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_resenas.php",
			data:{
				action: 		"actualizarResena",
				id_resena: 		$("#id_resena").val(),
				calificacion: 	$('input:radio[name=estrellas]:checked').val(),
				comentarios: 	resena.val()
			},
			success:function (response) {
				//console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "actualizado") 
				{
					$(".modal-title").html("Reseña actualizada");
					$(".modal-body").html("La reseña del producto ha sido actualizada correctamente.")
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
						loadPage("mis_resenas");
					});
				}
				else if (jsonResponse.estado == "error") 
				{
					$(".modal-title").html("Ha ocurrido un error");
					$(".modal-body").html(jsonResponse.data)
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
					});
				}
				else
				{
					console.log(jsonResponse);
				}
			}
		});
	}
	else
	{
		$(".alert_resena").css("display","block");
		$(".alert_resena").html("Ingrese la reseña del producto.");
	}
}

function estado_resena(estado,id_resena)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_mis_resenas.php",
		data:{
			action: 	"estadoResena",
			estado: 	estado,
			id_resena: 	id_resena 
		},
		success:function (response) {
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "success") 
			{
				loadPage("mis_resenas");
			}
			else
			{
				console.log(response);
			}
		}
	})
}