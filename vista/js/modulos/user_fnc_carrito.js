//	VER CARRITO DE COMPRAS
function verCarritoCompras()
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_carrito.php?action=ver_carrito",
		success:function (response) {
			jQuery(".cart-view").html(response);
		}
	});
}

//	FUNCION PARA ELIMINAR PRODUCTO DEL CARRITO DE COMPRAS
function eliminar_producto(indice)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_carrito.php?action=eliminar_producto",
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
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_carrito.php?action=cambiar_cantidad",
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
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_carrito.php?action=vaciar_carrito"
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
	jQuery(".modal").modal("toggle");
	jQuery(".modal-title").html("Confirmar pedido.");
	jQuery(".modal-body").html("¿Esta seguro de realizar el pedido?");
	jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary modal-btn-cancel" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	jQuery(".modal-btn-accept").click(function () {
		var observaciones = jQuery("#observaciones");
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/user_ajax_carrito.php?action=realizar_pedido",
			data:{
				email: 			localStorage.email,
				observaciones: 	observaciones.val()
			},
			success:function (response) {
				console.log(response);
				var jsonResponse = JSON.parse(response);
				if (jsonResponse.estado == "success") 
				{
					jQuery(".modal-title").html("Pedido exitoso");
					jQuery(".modal-body").html("Se ha realizado el pedido correctamente, dirijase a la sección 'Mis pedidos' para realizar el pago.");
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal("toggle");
						vaciar_carrito_compra();
						loadPage('mis_pedidos');
					});

				}
				else
				{
					jQuery(".modal-title").html(jsonResponse.estado);
					jQuery(".modal-body").html(jsonResponse.data);
					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function () {
						jQuery(".modal").modal("toggle");
					});
				}
			}
		})
	})
}