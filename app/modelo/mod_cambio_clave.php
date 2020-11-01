<?php
	require_once "conexion.php";
	require_once "mod_emails.php";
	/**
	 * MODELO PARA EL CAMBIO DE CLAVE
	 */
	class CambioClaveMod extends Conexion
	{
		
		#	VALIDAR PERMISO PARA REALIZAR EL CAMBIO DE CLAVE
		public static function validarPermisoMod($email,$codigo_validacion)
		{
			$consulta = Conexion::conectar()->prepare("	SELECT 	estado
														FROM 	cambio_clave
														WHERE 	email 	= :email
														AND 	codigo	= :codigo_validacion");

			$consulta -> bindParam(":email", $email, PDO::PARAM_STR);
			$consulta -> bindParam(":codigo_validacion", $codigo_validacion, PDO::PARAM_STR);

			$consulta -> execute();

			$resultado = $consulta -> fetch(PDO::FETCH_ASSOC);

			return $resultado['estado'];
		}

		#	ENCRIPTAR CONTRASEÑA DE USUARIO
		public static function encriptarContrasena($contrasena)
		{
			$salt = '$2a$10$softwarebynextytechnet$';
			$encrypt = crypt($contrasena,$salt);
			return $encrypt;
		}

		#	ACTUALIZAR CONTRASEÑA DE ACCESO DE USUARIO
		public static function actualizarClaveMod($datosCambio)
		{
			$email 			= $datosCambio['email'];
			$codigo 		= $datosCambio['codigo'];
			$nueva_clave 	= CambioClaveMod::encriptarContrasena($datosCambio['clave']);

			$update = Conexion::conectar()->prepare("	UPDATE 	usuarios
														SET 	clave 	= :nueva_clave
														WHERE 	email 	= :email");

			$update -> bindParam(":nueva_clave", 	$nueva_clave, 	PDO::PARAM_STR);
			$update -> bindParam(":email", 			$email, 		PDO::PARAM_STR);

			if ($update -> execute()) 
			{
				# SE HA ACTUALIZADO LA CONTRASEÑA CORRECTAMENTE, ACTUALIZAMOS EL REGISTRO DE LA TABLA: cambio_clave

				$update_cambio = Conexion::conectar()->prepare("UPDATE 	cambio_clave
																SET 	estado 	= 'Actualizado'
																WHERE 	email 	= :email
																AND 	codigo 	= :codigo");

				$update_cambio -> bindParam(":email", 	$email, 	PDO::PARAM_STR);
				$update_cambio -> bindParam(":codigo", 	$codigo,	PDO::PARAM_STR);

				if ($update_cambio -> execute()) 
				{
					$resultado = json_encode(array("estado" => "success"));
				}
				else
				{
					$resultado = json_encode(array("estado" => "error", "data" => $update_cambio->errorInfo()));
				}
			}
			else
			{
				# HA OCURRIDO UN ERROR
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
			}

			return $resultado;

		}

		#	SOLICITAR CAMBIO DE CLAVE 
		public static function solicitarCambioClaveMod($email)
		{
			#	CONSULTAMOS SI EL EMAIL INGRESADO CORRESPONDE A ALGUNA CUENTA REGISTRADA Y ACTIVA
			$consulta = Conexion::conectar()->prepare("	SELECT 
														CONCAT(nombre,' ',apellido) AS nombre,
														email,
														COUNT(*) cant 
														FROM usuarios 
														WHERE email = :email
														AND estado = 'Activo'");

			$consulta -> bindParam(":email", $email, PDO::PARAM_STR);
			$consulta -> execute();
			$usuario = $consulta -> fetch(PDO::FETCH_ASSOC);

			if ($usuario['cant'] != 0) 
			{
				# 	CONSULTAMOS SI HAY ALGUN REGISTRO DE CAMBIO DE CLAVE ACTIVO
				$existe = Conexion::conectar()->prepare("	SELECT 	COUNT(*) cant
															FROM 	cambio_clave
															WHERE 	email = :email
															AND 	estado = 'Activo'");

				$existe -> bindParam(":email", $email, PDO::PARAM_STR);
				$existe -> execute();
				$cantidad = $existe -> fetch(PDO::FETCH_ASSOC);

				if ($cantidad['cant'] == 0) 
				{
					# 	REGISTRAR NUEVO CASO PARA CAMBIO DE CLAVE
					$codigo 	= CambioClaveMod::crearCaso($email);
					$nombre 	= $usuario['nombre']; 
					$asunto 	= "Cambio de Clave";
					$plantilla 	= "cambioClave";
					$link_cambio_clave = "https://www.clickstore.co/app/cambio_clave.php?email=" . $email . "&codigo_validacion=" . $codigo;

					$parametros = json_encode(array("nombre" 			=> $nombre,
													"link_cambio_clave" => $link_cambio_clave));

					$bloqueo = Email::programarCorreo($email,$nombre,$asunto,$plantilla,$parametros);

					if($bloqueo)
					{
						$resultado = json_encode(array("estado" => "success"));
					}
					else
					{
						$resultado = json_encode(array("estado" => "error", "data" => "No se ha podido registrar el correo electrónico para el cambio de clave."));	
					}
				}
				else
				{
					#	YA HAY UN CASO ACTIVO PARA CAMBIO DE CLAVE 
					$resultado = json_encode(array("estado" => "error", "data" => "Ya hay una solicitud activa para cambio de clave registrada en el sistema, por favor revise su correo electrónico."));	
				}
			}
			else
			{
				#	EL EMAIL NO CORRESPONDE A NINGUNA CUENTA REGISTRADA
				$resultado = json_encode(array("estado" => "error", "data" => "El email ingresado no corresponde a ninguna cuenta registrada en el sistema."));
			}
			return $resultado;
		}

		#	GENERAR EL CASO PARA EL CAMBIO DE CLAVE
		public static function crearCaso($email)
		{
			$codigo = CambioClaveMod::generateRandomString(10);
			
			$desde = date('Y-m-j');
			$nuevaFecha = strtotime ( '+2 day' , strtotime ( $desde ) ) ;
			$hasta = date ( 'Y-m-j' , $nuevaFecha );

			$estado = "Activo";
			

			$insert = Conexion::conectar()->prepare("INSERT INTO cambio_clave(id_cambio, email, codigo, desde, hasta, estado) VALUES (null, :email, :codigo, :desde, :hasta, :estado)");

			$insert -> bindParam(":email", 	$email, 	PDO::PARAM_STR);
			$insert -> bindParam(":codigo", $codigo, 	PDO::PARAM_STR);
			$insert -> bindParam(":desde", 	$desde, 	PDO::PARAM_STR);
			$insert -> bindParam(":hasta", 	$hasta, 	PDO::PARAM_STR);
			$insert -> bindParam(":estado", $estado, 	PDO::PARAM_STR);

			$insert -> execute();

			return $codigo;

		}

		#	GENERAR CODIGO DE VALIDACION DE CUENTA
		public static function generateRandomString($length) 
		{
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    
		    for ($i = 0; $i < $length; $i++) 
		    {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }

		    return $randomString;
		}
	}