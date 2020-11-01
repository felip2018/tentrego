//	VALIDACION DE INICIO DE SESION
$(document).ready(function () {
	if (localStorage.acceso == '1') 
	{
		//	VALIDAR PERFIL DE USUARIO
		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_inicio.php",
			data:
			{
				modulo: 	"sesion",
				action: 	"validar_perfil",
				usuario: 	localStorage.email,
				id_perfil:  localStorage.id_perfil
			},
			success:function (reponse) {
				//console.log(reponse);
				var jsonResponse = JSON.parse(reponse);
				if (jsonResponse.estado == "success") 
				{
					// 	ACCESO PERMITIDO
					console.log("Acceso Valido");
				}
				else if (jsonResponse.estado == "denied")
				{
					$.ajax({
						type:"POST",
						url:"vista/ajax/ajax_inicio.php",
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

								location.href = "../index.php";
								
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
		location.href = "../index.php";
	}
})

function mostrar_menu(evento)
{
	switch(evento)
	{
		case 'ver':
			
			$(".menu-movil").removeClass("ocultar");
			$(".menu-movil").addClass("ver");
			break;

		case 'ocultar':

			$(".menu-movil").addClass("ocultar");
			$(".menu-movil").removeClass("ver");
			
			break;
	}
}

function verOpcionesMenu(opciones) {
	$("#"+opciones).toggle('fast');
}

function cerrar_sesion()
{
	$(".modal").modal('toggle');
	$(".modal-title").html("Cerrar Sesión");
	$(".modal-body").html("Desea salir del sistema en este momento?");

	$(".modal-footer").html('<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button><button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

	$(".modal-btn-accept").on('click',function () {		
		$.ajax({
			type:"POST",
			url:"vista/ajax/ajax_inicio.php",
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

					$(".modal-title").html("Has finalizado la sesión");
					$(".modal-body").html("Tu sesión se ha finalizado correctamente!");

					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');

					$(".modal-btn-accept").click(function() {
						location.href = "../index.php";
					});
				}
				else
				{
					$(".modal-title").html("¡Ha ocurrido un error!");
					$(".modal-body").html(res["data"]);

					$(".modal-footer").html('<button type="button" class="btn btn-primary modal-btn-accept">Aceptar</button>');


					$(".modal-btn-accept").click(function() {
						$(".modal").modal('toggle');
					});
				}
			}
		});	
	});
}

/*CARGAR PAGINA SOLICITADA*/
function loadPage(page) 
{
	$("#vista").load("vista/modulos/"+page+"/"+page+".php");
}

//	INFORMACION DE PERFIL DE USUARIO
function info_usuario()
{
	$(".modal").modal("toggle");
	$(".modal-title").html('Información de Usuario');
	$(".modal-body").html('');
	$(".modal-footer").html('');
}