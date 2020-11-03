//	VER CARRITO DE COMPRAS
function verCarritoCompras()
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/ajax_carrito.php?action=ver_carrito",
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
	jQuery.ajax({
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
	var confirmacion = confirm("Desea vaciar el carrito de compras?");
	if (confirmacion) 
	{

		jQuery.ajax({
			type:"POST",
			url:"accion.php?ac=6"
		}).done(function(respuesta){
			if (respuesta == 1) 
			{
				location.reload(true);
			}
		});
	}
}

//	VALIDAR SI EL USUARIO TIENE LA SESION INICIADA PARA GUIARLO AL PROCESO DE PAGO
function validar_sesion()
{
	if (localStorage.acceso === undefined) {
		location.href = "login.php";
	} else if(localStorage.acceso == '1') {
		if (localStorage.id_perfil == '2')  {
			location.href = "panel_usuario.php";
		}
	}
}