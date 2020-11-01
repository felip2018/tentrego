<?php
	require_once "conexion.php";
	/**
	* MODELO DE LOGIN CON FACEBOOK
	*/
	class LoginFacebookMod extends Conexion
	{
		
		#	REALIZAR LA VALIDACION DE USUARIO
		public static function validarUsuarioMod($datosUsuario)
		{
			$nombre 	= $datosUsuario['nombre'];
			$apellido 	= $datosUsuario['apellido'];
			$email 		= $datosUsuario['email'];

			$consulta = Conexion::conectar()->prepare("SELECT 
														estado,
														COUNT(*) cant
														FROM usuarios
														WHERE email = :email");
			
			$consulta -> bindParam(":email",	$email,	PDO::PARAM_STR);
			$consulta -> execute();

			$existe = $consulta -> fetch(PDO::FETCH_ASSOC);

			if ($existe['cant'] > 0) 
			{
				# 	EL USUARIO ESTA REGISTRADO, EVALUAMOS EL ESTADO DE SU CUENTA
				if ($existe['estado'] == "Activo") 
				{
					# 	CUENTA ACTIVA
					$resultado = json_encode(array("status" => "registrado", "email" => $email));
				}
				else
				{
					#	LA CUENTA NO ESTA ACTIVA
					$resultado = json_encode(array("status" => "estado_cuenta", "email" => $email, "estado_cuenta" => $existe['estado']));	
				}
			}
			else
			{
				#	EL USUARIO NO SE ENCUENTRA REGISTRADO EN LA BASE DE DATOS
				$resultado = json_encode(array("status" => "sin_registro"));
			}

			return $resultado;
		}

		#	VALIDACION DE USUARIO
		public static function validacionFacebookMod($email)
		{
			
			$consulta = Conexion::conectar()->prepare("SELECT  
														usuarios.id_tipo_identi,
														usuarios.num_identi,
														CONCAT(usuarios.nombre,' ',usuarios.apellido) AS nombre,
														usuarios.email,
														usuarios.telefono,
														usuarios.id_perfil,
														usuarios.clave,
														usuarios.foto,
														usuarios.intentos,
														usuarios.fecha_usuario,
														usuarios.estado,
														perfil.nombre perfil
														FROM usuarios 
														INNER JOIN perfil 	ON perfil.id_perfil = usuarios.id_perfil
														WHERE 	usuarios.email 		= :email
														AND 	usuarios.estado 	= 'Activo'");

			$consulta->bindParam(":email", $email,	PDO::PARAM_STR);
			
			if($consulta->execute())
			{
				$data = $consulta -> fetch(PDO::FETCH_ASSOC);
				$resultado = json_encode(array("estado" => "success", "data" => $data));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $consulta->errorInfo()));
			} 

			return $resultado;
		}

	}