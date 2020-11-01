<?php
	/**
	* CLASE CONTROLADOR DEL LOGIN
	*/
	class LoginCon
	{
		
		#	CARGAR LA VISTA PRINCIPAL
		public function vistaPrincipal()
		{
			include "vista/plantilla.php";
		}

		#	SOLICITAR VALIDACION DE USUARIO
		public function validacionCon($datosUsuario)
		{

			$respuesta = LoginMod::validacionMod($datosUsuario,"usuarios");
			
			if ($respuesta == "sin_registro") 
			{
				# EL USUARIO INGRESADO NO ESTA EN EL SISTEMA
				print json_encode(array("estado" => "sin_registro"));
			}
			else
			{	
				if ($datosUsuario['login'] == $respuesta['email'] && $datosUsuario['clave'] == $respuesta['clave'])
				{
					//RESETEAMOS EL NUMERO DE INTENTOS
					$actualizar = LoginMod::actualizarIntentosMod(2,$datosUsuario['login']);
					//RETORNAMOS LOS DATOS DEL USUARIO EN FORMATO JSON
					print json_encode(array("estado" => "success", "data" => $respuesta));
				}
				else
				{
					//--------------------------CONTROL DE INTENTOS
					//ACTUALIZAR NUMERO DE INTENTOS
					$actualizar = LoginMod::actualizarIntentosMod(1,$datosUsuario['login']);
					//---------------------------------------------
					if ($actualizar == "Actualizado") 
					{
						# SE HA ACTUALIZADO EL NUMERO DE INTENTOS
						print json_encode(array("estado" => "error_validacion"));
					}
					else if ($actualizar == "Bloqueado") 
					{
						#	NOTIFICAR BLOQUEO DE CUENTA
						$bloqueo = LoginMod::notificarBloqueoMod($datosUsuario['login']);
						if ($bloqueo) 
						{
							print json_encode(array("estado" => "error_cuenta"));
						}
					}
					
				}

			}
		}
	}