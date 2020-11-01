//	VER CARRITO DE COMPRAS
function verCarritoCompras()
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_carrito.php?action=ver_carrito",
		success:function (response) {
			$(".cart-view").html(response);
		}
	});
}

//	FUNCION PARA ELIMINAR PRODUCTO DEL CARRITO DE COMPRAS
function eliminar_producto(indice)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_carrito.php?action=eliminar_producto",
		data:('indice='+indice)
	}).done(function(response){

		var jsonResponse = JSON.parse(response);

		if (jsonResponse.estado == "eliminado") 
		{
			verCarritoCompras();
		}
		else
		{
			console.log(jsonResponse);
		}
	});
}

//	FUNCION PARA ACTUALIZAR LA CANTIDAD DE PRODUCTO
function cambiar_valor(indice,cantidad)
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_carrito.php?action=cambiar_cantidad",
		data:('indice='+indice+'&cantidad='+cantidad)
	}).done(function(response){
		var jsonResponse = JSON.parse(response);

		if (jsonResponse.estado == "actualizado") 
		{
			verCarritoCompras();
		}
		else
		{
			console.log(jsonResponse);
		}
	})
}
/*************************************************/
/*FUNCION PARA INVOCAR EL BORRADO DE LOS DATOS DEL CARRITO DE COMPRA*/
function vaciar_carrito_compra()
{
	$.ajax({
		type:"POST",
		url:"vista/ajax/ajax_carrito.php?action=vaciar_carrito"
	}).done(function(respuesta){
		if (respuesta == 1) 
		{
			location.reload(true);
		}
	});	
}

//	REALIZAR PEDIDO
function realizar_pedido()
{
	$(".modal").modal("toggle");
	$(".modal-title").html("Confirmar pedido.");
	$(".modal-body").html("¿Esta seguro de realizar el pedido?");
	$(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	$(".modal-btn-accept").click(function () {
		var observaciones = $("#observaciones");
		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_carrito.php?action=realizar_pedido",
			data:{
				email: 			localStorage.email,
				observaciones: 	observaciones.val()
			},
			success:function (response) {
				console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "success") 
				{
					$(".modal-title").html("Pedido exitoso");
					$(".modal-body").html("Se ha realizado el pedido correctamente, dirijase a la sección 'Mis pedidos' para realizar el pago.");
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
						vaciar_carrito_compra();
						loadPage('mis_pedidos');
					});

				}
				else
				{
					$(".modal-title").html(jsonResponse.estado);
					$(".modal-body").html(jsonResponse.data);
					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function () {
						$(".modal").modal("toggle");
					});
				}
			}
		})
	})
}