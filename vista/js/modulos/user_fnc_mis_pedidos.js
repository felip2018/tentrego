function verListaPedidos() 
{
	jQuery.ajax({
		type:"POST",
		//url:"vista/ajax/ajax_mis_pedidos.php",
		url:"vista/modulos/mis_pedidos/lista_pedidos.php",
		data:{
			action: "listaPedidos",
			email: localStorage.email
 		},
 		success:function (response) {
 			//console.log(response);
 			jQuery(".listaPedidos").html(response);
 			/*var jsonResponse = JSON.parse(response);
 			if (jsonResponse.estado == "success") 
 			{
 				jQuery.each(jsonResponse.data,function (index,value) {

 					var colorEstado;

 					if (value['estado'] == "por pagar" || value['estado'] == "pendiente" || value['estado'] == "contra entrega") {
 						colorEstado = "#f1c40f";
 					}else if (value['estado'] == "cancelado") {
 						colorEstado = "#c0392b";
 					}else if (value['estado'] == "pagado") {
 						colorEstado = "#2980b9";
 					}else if (value['estado'] == "entregado") {
 						colorEstado = "#27ae60";
 					}

 					var fecha = new Date(value['fecha']);

 					jQuery(".listaPedidos").append('<tr>'+
 												'<td>'+value['id_pedido']+'</td>'+
 												'<td>'+value['codigo_pedido']+'</td>'+
 												'<td>'+fecha+'</td>'+
 												'<td> $ '+new Intl.NumberFormat().format(value['total'])+'</td>'+
 												'<td style="background:'+colorEstado+';color:#FFF;">'+value['estado']+'</td>'+
 												'<td>'+
 												'<button type="button" class="btn btn-secondary" onclick="ver_pedido('+value['id_pedido']+')"><i class="fa fa-search"></i> Ver pedido</button>'+
 												'<button title="Cancelar pedido" type="button" class="btn btn-danger" onclick=cancelar_pedido("'+value['id_pedido']+'","'+value['codigo_pedido']+'")><i class="fa fa-ban"></i> Cancelar</button>'+
 												'</td>'+
 											   '</tr>');
 				});
 			}
 			else if(jsonResponse.estado == "vacio")
 			{
 				jQuery(".listaPedidos").html('<tr><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td></tr>');
 			}
 			else
 			{
 				console.log(jsonResponse);
 			}*/

 		}
	});
}

function ver_pedido(id_pedido)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/mis_pedidos/ver_pedido.php",
		data:{
			id_pedido: id_pedido
		},
		success:function (response) {
			jQuery("#vista").html(response);
		}
	})
}

//	CANCELAR PEDIDO
function cancelar_pedido(id_pedido,codigo_pedido)
{
	jQuery(".modal").modal('toggle');
	jQuery(".modal-title").html('Cancelar pedido.');
	jQuery(".modal-body").html('¿Desea cancelar la solicitud del pedido actual?');
	jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	jQuery(".modal-btn-accept").click(function () {
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_pedidos.php",
			data:{
				action: 		"cancelarPedido",
				id_pedido: 		id_pedido,
				codigo_pedido: 	codigo_pedido
			},
			success:function (response) {
				console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "success") 
				{
					jQuery(".modal-title").html('Cancelación exitosa');
					jQuery(".modal-body").html('Se ha realizado la cancelación del pedido correctamente.');
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal('toggle');
						loadPage('mis_pedidos');
					});
				}
				else if (jsonResponse.estado == "error") 
				{
					jQuery(".modal-title").html('Ha ocurrido un error');
					jQuery(".modal-body").html(jsonResponse.data);
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal('toggle');
					});
				}
			}
		})
	})

}

//	DEFINIR PAGO CONTRA ENTREGA
function pago_contraentrega(id_pedido)
{
	//console.log("Pago contra entrega Id Pedido -> "+id_pedido);
	jQuery(".modal").modal("toggle");
	jQuery(".modal-title").html('Confirmación del pago.');
	jQuery(".modal-body").html('¿Desea confirmar el pago de este pedido contra entrega?');
	jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	jQuery(".modal-btn-accept").click(function () {
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_pedidos.php",
			data:{
				action: 	"pagoContraEntrega",
				id_pedido: 	id_pedido
 			},
 			success:function (response) {
 				console.log(response);
 				var jsonResponse = JSON.parse(response);
 				if (jsonResponse.estado == 'success') 
 				{
 					jQuery(".modal-title").html('Se ha solicitado el pedido correctamente.');
					jQuery(".modal-body").html('Se ha deifinido el medio de pago del pedido como <b>pago contra entrega</b>. Un agente se pondra en contacto contigo para validar el pedido y detallar tu compra.<br>Muchas gracias');
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal('toggle');
						ver_pedido(id_pedido);
					});
 				}
 				else if (jsonResponse.estado == 'error') 
 				{
 					jQuery(".modal-title").html('Ha ocurrido un error');
					jQuery(".modal-body").html(jsonResponse.data);
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal('toggle');
						ver_pedido(id_pedido);
					});

 				}
 			}
		})
	});

}

// 	GENERAR CASO DE UN PRODUCTO
function producto_caso(caso,id_pedido,id_producto)
{
	//console.log("Caso -> "+caso+", Id Pedido -> "+id_pedido+", Id Producto -> "+id_producto);
	switch(caso)
	{
		case 'devolucion':

			var modal_title = "Generar devolución";
			var modal_body_message = "Para continuar indica a continuación el motivo para generar la devolución";
			var modal_button = "Crear devolución";

			break;

		case 'garantia':
			var modal_title = "Solicitud de garantía";
			var modal_body_message = "Para continuar indica a continuación el motivo para realizar la solicitud de garantía del producto";
			var modal_button = "Solicitar garantía";
			break;
	}

	jQuery(".modal").modal('toggle');
	jQuery(".modal-title").html(modal_title);
	jQuery(".modal-body").html('<p>'+modal_body_message+'</p>'+
							'<form id="form_caso">'+
								'<input type="hidden" name="caso" value="'+caso+'">'+
								'<input type="hidden" name="id_pedido" value="'+id_pedido+'">'+
								'<input type="hidden" name="id_producto" value="'+id_producto+'">'+
								'<b>Motivo</b>'+
								'<textarea class="form-control" rows="5" name="motivo" id="motivo"></textarea>'+
							'</form><br>'+
							'<button class="btn btn-primary btn-block modal-btn-accept">'+modal_button+'</button>');

	jQuery(".modal-footer").html('');

	jQuery(".modal-btn-accept").click(function () {
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/ajax_mis_pedidos.php",
			data:{
				action: 	"crearCaso",
				caso: 		caso,
				id_pedido: 	id_pedido,
				id_producto:id_producto,
				motivo: 	jQuery("#motivo").val()
			},
			success:function (response) 
			{
				//console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "success") 
				{
					jQuery(".modal_title").html("Caso creado");
					jQuery(".modal-body").html('Se ha creado el caso correctamente.');
					jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal('toggle');
						ver_pedido(id_pedido);
					});
				}
				else if (jsonResponse.estado == "error") 
				{
					jQuery(".modal_title").html("Ha ocurrido un error");
					jQuery(".modal-body").html(jsonResponse.data);
					jQuery(".modal-footer").html('<button class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal('toggle');
						ver_pedido(id_pedido);
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