//	ESTADO DE PROMOCION
function estado_promocion(estado,id_promocion)
{
	jQuery.ajax({
		type:"POST",
		url:"vista/ajax/adm_ajax_promociones.php?action=estadoPromocion",
		data:{
			estado: 		estado,
			id_promocion: 	id_promocion
		},
		success:function (response) {
			console.log(response);
			var jsonResponse = JSON.parse(response);
			if (jsonResponse.estado == "success") 
			{
				loadPage("promociones");
			}
			else
			{
				console.log(response);
			}
		}
	})
}