function verListaPedidos() 
{
	$.ajax({
		type:"POST",
		url:"vista/modulos/pedidos/lista_pedidos.php",
		data:{
			action: "listaPedidos",
			email: localStorage.email
 		},
 		success:function (response) {
 			$(".listaPedidos").html(response);
 			/*var jsonResponse = JSON.parse(response);
 			if (jsonResponse.estado == "success") 
 			{
 				$.each(jsonResponse.data,function (index,value) {

 					var colorEstado;

 					if (value['estado'] == "por pagar") {
 						colorEstado = "#f1c40f";
 					}else if (value['estado'] == "cancelado") {
 						colorEstado = "#c0392b";
 					}else if (value['estado'] == "pagado") {
 						colorEstado = "#2980b9";
 					}else if (value['estado'] == "entregado") {
 						colorEstado = "#27ae60";
 					}

 					$(".listaPedidos").append('<tr>'+
 												'<td>'+value['id_pedido']+'</td>'+
 												'<td>'+value['codigo_pedido']+'</td>'+
 												'<td>'+value['fecha']+'</td>'+
 												'<td> $ '+new Intl.NumberFormat().format(value['total'])+'</td>'+
 												'<td style="background:'+colorEstado+';color:#FFF;">'+value['estado']+'</td>'+
 												'<td>'+
 												'<button type="button" class="btn btn-secondary" onclick="ver_pedido('+value['id_pedido']+')"><i class="fa fa-search"></i> Ver pedido</button>'+
 												'</td>'+
 											   '</tr>');
 				});
 			}
 			else if(jsonResponse.estado == "vacio")
 			{
 				$(".listaPedidos").html('<tr><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td><td>--</td></tr>');
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
	$.ajax({
		type:"POST",
		url:"vista/modulos/pedidos/ver_pedido.php",
		data:{
			id_pedido: id_pedido
		},
		success:function (response) {
			$("#vista").html(response);
		}
	})
}