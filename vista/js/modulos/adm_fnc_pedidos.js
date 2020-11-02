function verListaPedidos() 
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm/pedidos/lista_pedidos.php",
		data:{
			action: "listaPedidos",
			email: localStorage.email
 		},
 		success:function (response) {
 			jQuery(".listaPedidos").html(response);
 		}
	});
}

function ver_pedido(id_pedido)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/modulos/adm/pedidos/ver_pedido.php",
		data:{
			id_pedido: id_pedido
		},
		success:function (response) {
			jQuery("#vista").html(response);
		}
	})
}