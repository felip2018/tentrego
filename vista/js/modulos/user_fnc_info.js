//	AGREGAR PRODUCTO AL CARRITO DE COMPRAS
function info_agregar_al_carrito(id_producto,nombre_producto,precio_venta,imagen,origen,recomienda) 
{
	//console.log("Id Producto -> "+id_producto+"/ Nombre Producto -> "+nombre_producto+"/ $"+precio_venta);
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/user_ajax_carrito.php?action=agregar_producto",
		data:{
			id_producto: 	id_producto,
			nombre: 		nombre_producto,
			venta: 			precio_venta,
			imagen: 		imagen,
			origen: 		origen,
			recomienda: 	recomienda
		},
		success:function (response) {
			console.log(response);
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "agregado") 
			{
				//NOTIFICACION PUSH
				Push.create("Click Store", {
			    body: "Se ha agregado el producto al carrito de compras.",
			    icon: 'vista/img/productos/'+imagen,
			    timeout: 4000,
			    onClick: function () {
			        window.focus();
			        this.close();
			    	}
				}); 
			}
		}
	});
}

//	VER IMAGEN MINIATURA GRANDE
function ver_imagen(imagen)
{
	jQuery(".view_img").attr("src","vista/img/productos/"+imagen)
}