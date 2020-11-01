<?php
	require_once "conexion.php";
	require_once "mod_emails.php";
	/**
	* MODELO DE REGISTRO
	*/
	class RegistroMod extends Conexion
	{
		
		#	REGISTRAR NUEVO USUARIO EN EL SISTEMA
		public static function nuevoRegistroMod($datosUsuario)
		{
			$id_tipo_identi 		= 1;
			$num_identi 			= "";
			$nombre 				= $datosUsuario['nombre'];
			$apellido 				= $datosUsuario['apellido'];
			$telefono 				= $datosUsuario['telefono'];
			$direccion 				= "";
			$id_perfil 				= 2;
			$email 					= $datosUsuario['email'];
			$contrasena 			= RegistroMod::encriptarContrasena($datosUsuario['contrasena']);
			$notificaciones 		= $datosUsuario['notificaciones'];
			$terminos_condiciones 	= $datosUsuario['terminos_condiciones'];
			$foto 					= "";
			$intentos 				= 0;
			$sesion 				= "Desconectado";
			$codigo_validacion 		= RegistroMod::generateRandomString(128);
			$fecha_usuario 			= date("Y-m-d H:i:s");
			$estado 				= "Pendiente";

			#	CONSULTAMOS SI EL CORREO INGRESADO YA SE ENCUENTRA REGISTRADO
			$consulta_email = Conexion::conectar()->prepare("SELECT COUNT(*) cant
															 FROM usuarios
															 WHERE email = :email");

			$consulta_email -> bindParam(":email", 	$email, PDO::PARAM_STR);
			$consulta_email -> execute();
			$cantidad = $consulta_email -> fetch();

			if ($cantidad['cant'] == 0) 
			{
				# PROCEDEMOS A REGISTRAR EL USUARIO EN EL SISTEMA
				$registrar = Conexion::conectar()->prepare("INSERT INTO usuarios(id_tipo_identi, num_identi, nombre, apellido, email, telefono, direccion, id_perfil, clave, foto, intentos, sesion, codigo_validacion, notificaciones, terminos_condiciones, fecha_usuario, estado) VALUES (:id_tipo_identi, :num_identi, :nombre, :apellido, :email, :telefono, :direccion, :id_perfil, :clave, :foto, :intentos, :sesion, :codigo_validacion, :notificaciones, :terminos_condiciones, :fecha_usuario, :estado)");

				$registrar -> bindParam(":id_tipo_identi", 	$id_tipo_identi, 	PDO::PARAM_INT);
				$registrar -> bindParam(":num_identi", 		$num_identi, 		PDO::PARAM_INT);
				$registrar -> bindParam(":nombre", 			$nombre, 			PDO::PARAM_STR);
				$registrar -> bindParam(":apellido", 		$apellido, 			PDO::PARAM_STR);
				$registrar -> bindParam(":email", 			$email, 			PDO::PARAM_STR);
				$registrar -> bindParam(":telefono", 		$telefono, 			PDO::PARAM_STR);
				$registrar -> bindParam(":direccion", 		$direccion, 		PDO::PARAM_STR);
				$registrar -> bindParam(":id_perfil", 		$id_perfil, 		PDO::PARAM_INT);
				$registrar -> bindParam(":clave", 			$contrasena, 		PDO::PARAM_STR);
				$registrar -> bindParam(":foto", 			$foto, 				PDO::PARAM_STR);
				$registrar -> bindParam(":intentos", 		$intentos, 			PDO::PARAM_INT);
				$registrar -> bindParam(":sesion", 			$sesion, 			PDO::PARAM_STR);
				$registrar -> bindParam(":codigo_validacion", $codigo_validacion, PDO::PARAM_STR);
				$registrar -> bindParam(":notificaciones", 	$notificaciones, 	PDO::PARAM_STR);
				$registrar -> bindParam(":terminos_condiciones", $terminos_condiciones, PDO::PARAM_STR);
				$registrar -> bindParam(":fecha_usuario", 	$fecha_usuario, 	PDO::PARAM_STR);
				$registrar -> bindParam(":estado", 			$estado, 			PDO::PARAM_STR);

				if ($registrar -> execute()) 
				{
					# SE HA REGISTRADO EL USUARIO CORRECTAMENTE
					#	PROGRAMACION DE CORREO DE VALIDACION DE CUENTA
					$asunto 	= 'Registro Usuario';
					$plantilla 	= 'activacionCuenta';
					$link_validacion = "https://www.clickstore.co/app/validacion.php?email=" . $email . "&codigo_validacion=" . $codigo_validacion;

					$parametros = json_encode(array("nombre" 	=> $nombre, 
													"apellido" 	=> $apellido, 
													"email" 	=> $email, 
													"clave"		=> $datosUsuario['contrasena'],
													"link_validacion" => $link_validacion));		

					$programarCorreo = Email::programarCorreo($email,$nombre,$asunto,$plantilla,$parametros);

					$resultado = json_encode(array("status" => "success"));
				}
				else
				{
					$resultado = json_encode($registrar -> errorInfo());
				}
			}
			else
			{
				# EL USUARIO YA SE ENCUENTRA REGISTRADO EN EL SISTEMA
				$resultado = json_encode(array("status"	=> "registrado"));
			}

			return $resultado;
		}


		#	ENCRIPTAR CONTRASEÑA DE USUARIO
		public static function encriptarContrasena($contrasena)
		{
			$salt = '$2a$10$softwarebynextytechnet$';
			$encrypt = crypt($contrasena,$salt);
			return $encrypt;
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