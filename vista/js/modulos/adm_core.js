//	VALIDACION DE INICIO DE SESION
jQuery(document).ready(function () {
	if (localStorage.acceso == '1') 
	{
		//	VALIDAR PERFIL DE USUARIO
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/adm_ajax_inicio.php",
			data:
			{
				modulo: 	"sesion",
				action: 	"validar_perfil",
				usuario: 	localStorage.email,
				id_perfil:  localStorage.id_perfil
			},
			success:function (reponse) {
				console.log(reponse);
				var jsonResponse = JSON.parse(reponse);
				if (jsonResponse.estado == "success") 
				{
					// 	ACCESO PERMITIDO
					console.log("Acceso Valido");
				}
				else if (jsonResponse.estado == "denied")
				{
					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/adm_ajax_inicio.php",
						data:
						{
							modulo: 	"sesion",
							action: 	"cerrar_sesion",
							usuario: 	localStorage.email 
						},
						success:function (respuesta) 
						{
							var jsonResponse = JSON.parse(respuesta);
							if (jsonResponse.estado == "success") 
							{
								localStorage.removeItem("acceso");
								localStorage.removeItem("id_tipo_identi");
								localStorage.removeItem("num_identi");
								localStorage.removeItem("nombre");
								localStorage.removeItem("email");
								localStorage.removeItem("telefono");
								localStorage.removeItem("id_perfil");
								localStorage.removeItem("clave");
								localStorage.removeItem("foto");
								localStorage.removeItem("fecha_usuario");
								localStorage.removeItem("estado");
								localStorage.removeItem("perfil");
								localStorage.removeItem("sesion");

								location.href = "index.php";
								
							}
						}
					});	
				}
			}
		})

	}
	else
	{
		// 	NO HA INICIADO SESION
		location.href = "index.php";
	}
})

function mostrar_menu(evento)
{
	switch(evento)
	{
		case 'ver':
			
			jQuery(".menu-movil").removeClass("ocultar");
			jQuery(".menu-movil").addClass("ver");
			break;

		case 'ocultar':

			jQuery(".menu-movil").addClass("ocultar");
			jQuery(".menu-movil").removeClass("ver");
			
			break;
	}
}

function verOpcionesMenu(opciones) {
	jQuery("#"+opciones).toggle('fast');
}

function cerrar_sesion()
{
	jQuery(".modal").modal('toggle');
	jQuery(".modal-title").html("Cerrar Sesión");
	jQuery(".modal-body").html("Desea salir del sistema en este momento?");

	jQuery(".modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	jQuery(".modal-btn-accept").on('click',function () {		
		jQuery.ajax({
			type:"POST",
			url:"vista/ajax/adm_ajax_inicio.php",
			data:
			{
				modulo: 	"sesion",
				action: 	"cerrar_sesion",
				usuario: 	localStorage.email 
			},
			success:function (respuesta) 
			{
				//console.log(respuesta);
				var jsonResponse = JSON.parse(respuesta);
				if (jsonResponse.estado == "success") 
				{
					localStorage.removeItem("acceso");
					localStorage.removeItem("id_tipo_identi");
					localStorage.removeItem("num_identi");
					localStorage.removeItem("nombre");
					localStorage.removeItem("email");
					localStorage.removeItem("telefono");
					localStorage.removeItem("id_perfil");
					localStorage.removeItem("clave");
					localStorage.removeItem("foto");
					localStorage.removeItem("fecha_usuario");
					localStorage.removeItem("estado");
					localStorage.removeItem("perfil");
					localStorage.removeItem("sesion");

					jQuery(".modal-title").html("Has finalizado la sesión");
					jQuery(".modal-body").html("Tu sesión se ha finalizado correctamente!");

					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					jQuery(".modal-btn-accept").click(function() {
						location.href = "index.php";
					});
				}
				else
				{
					jQuery(".modal-title").html("¡Ha ocurrido un error!");
					jQuery(".modal-body").html(res["data"]);

					jQuery(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');


					jQuery(".modal-btn-accept").click(function() {
						jQuery(".modal").modal('toggle');
					});
				}
			}
		});	
	});
}

/*CARGAR PAGINA SOLICITADA*/
function loadPage(page) 
{
	jQuery("#vista").load("vista/modulos/adm_"+page+"/"+page+".php");
}

//	INFORMACION DE PERFIL DE USUARIO
function info_usuario()
{
	jQuery(".modal").modal("toggle");
	jQuery(".modal-title").html('Información de Usuario');
	jQuery(".modal-body").html('');
	jQuery(".modal-footer").html('');
}