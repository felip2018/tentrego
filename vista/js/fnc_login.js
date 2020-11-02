function validar_login() 
{
	//var razon_social 	= jQuery("#razon_social");
	var login 			= jQuery("#login");	
	var clave			= jQuery("#clave");

	var errores 		= 0;
	jQuery("#alerta").css("display","none");
	jQuery("#alerta").html("");
	
	/*VALIDACION DE CAMPOS DE LOGIN*/

	if (login.val() != "") 
	{
		if (clave.val() != "") 
		{

			var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

			if (! expresion.test(login.val())) 
			{
				jQuery("#alerta").css("display","block");
				jQuery("#alerta").html("ERROR: EL usuario ingresado es invalido.<br>");
			}
			else
			{
				var expresion = /[a-zA-Z0-9]/;

				if (! expresion.test(clave.val())) 
				{
					jQuery("#alerta").css("display","block");
					jQuery("#alerta").html("ERROR: La clave ingresada es invalida.<br>");
					
					bool_clave = false;
				}
				else
				{
					var form 		= document.querySelector("#form_ingreso");
					var formData	= new FormData(form);

					jQuery.ajax({
						type:"POST",
						url:"vista/ajax/ajax_login.php",
						data:formData,
						contentType:false,
						processData:false,
						success:function(respuesta)
						{
							console.log(respuesta);
							var jsonResponse = JSON.parse(respuesta);
							if (jsonResponse['estado'] == "success") 
							{
								//console.log("Ingresa");
								localStorage.acceso 		= 1;
								localStorage.id_tipo_identi = jsonResponse.data['id_tipo_identi'];
								localStorage.num_identi 	= jsonResponse.data['num_identi'];
								localStorage.nombre 		= jsonResponse.data['nombre'];
								localStorage.email 			= jsonResponse.data['email'];
								localStorage.telefono 		= jsonResponse.data['telefono'];
								localStorage.id_perfil 		= jsonResponse.data['id_perfil'];
								localStorage.clave 			= jsonResponse.data['clave'];
								localStorage.foto 			= jsonResponse.data['foto'];
								localStorage.fecha_usuario 	= jsonResponse.data['fecha_usuario'];
								localStorage.estado 		= jsonResponse.data['estado'];
								localStorage.perfil 		= jsonResponse.data['perfil'];
								localStorage.sesion 		= "Conectado";

								if (localStorage.id_perfil == 1) 
								{
									location.href = "panel_administrador.php";
								}
								else if(localStorage.id_perfil == 2)
								{
									location.href = "panel_usuario.php";
								}

							}
							else if(jsonResponse['estado'] == "sin_registro")
							{
								jQuery("#alerta").css("display","block");
								jQuery("#alerta").html("[Error_1]: El usuario ingresado no se encuentra registrado en el sistema.");
							}
							else if(jsonResponse['estado'] == "error_validacion")
							{
								jQuery("#alerta").css("display","block");
								jQuery("#alerta").html("[Error_2]: El usuario y/o la clave ingresados no coinciden.");
							}
							else if(jsonResponse['estado'] == "error_cuenta")
							{
								jQuery("#alerta").css("display","block");
								jQuery("#alerta").html("[Error_3]: Has llegado al limite de intentos para iniciar sesion.");
							}
						}
					});
				}
			}


		}
		else
		{
			jQuery("#alerta").css("display","block");
			jQuery("#alerta").html("Ingrese la clave de usuario");
			clave.focus();
		}
	}
	else
	{
		jQuery("#alerta").css("display","block");
		jQuery("#alerta").html("Ingrese el usuario");	
		login.focus();
	}
	
}