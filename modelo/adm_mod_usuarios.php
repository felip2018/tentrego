<?php
	require_once "conexion.php";
	require_once "mod_emails.php";
	/**
	* MODELO DE USUARIOS
	*/
	class UsuariosMod extends Conexion
	{
		
		#	CONSULTAR LISTA DE USUARIOS DEL SISTEMA
		public static function listaUsuariosMod()
		{
			$select = Conexion::conectar()->prepare("SELECT 
													CONCAT(usuarios.id_tipo_identi,'-',usuarios.num_identi) AS pk_usuario,
													CONCAT(tipo_identi.nombre,' | ',usuarios.num_identi) AS identi,
													usuarios.apellido,
													usuarios.nombre, 
													usuarios.email,
													usuarios.telefono,
													usuarios.estado
													FROM usuarios 
													INNER JOIN tipo_identi ON tipo_identi.id_tipo_identi = usuarios.id_tipo_identi
													WHERE usuarios.id_perfil != 0
													ORDER BY usuarios.apellido ASC");
			$select -> execute();
			$resultado = $select -> fetchAll();
			return $resultado;
		}
		
		#	CONSULTAR LISTA DE TIPOS DE IDENTIFICACION
		public static function listaTipoIdentiMod()
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM tipo_identi ORDER BY id_tipo_identi ASC");
			$select -> execute();
			$resultado = $select -> fetchAll();
			return $resultado;
		}

		#	CONSULTAR LISTA DE PERFILES
		public static function listaPerfilesMod()
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM perfil WHERE id_perfil != 0 ORDER BY nombre ASC");
			$select -> execute();
			$resultado = $select -> fetchAll();
			return $resultado;
		}

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

		#	REGISTRAR USUARIO EN EL SISTEMA
		public static function registrarUsuarioMod($datosUsuario)
		{
			$id_tipo_identi = $datosUsuario['id_tipo_identi'];
			$num_identi 	= $datosUsuario['num_identi'];
			$nombre 		= $datosUsuario['nombre'];
			$apellido 		= $datosUsuario['apellido'];
			$email 			= $datosUsuario['email'];
			$telefono 		= $datosUsuario['telefono'];
			$direccion 		= "";
			$id_perfil 		= $datosUsuario['id_perfil'];
			$clave 			= "Admi123*";
			$salt 			= '$2a$10$softwarebynextytechnet$';
			$encrypt 		= crypt($clave,$salt);
			$foto 			= "";
			$intentos 		= 0;
			$sesion 		= "Desconectado";
			$fecha_usuario  = date('Y-m-d H:i:s');
			$estado 		= "Validar";

			$codigo 		= UsuariosMod::generateRandomString(16);
			$notificaciones = 1;
			$terminos_condiciones = 1;

			#	VALIDAR SI EL USUARIO YA SE ENCUENTRA REGISTRADO
			$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant FROM usuarios WHERE id_tipo_identi = :id_tipo_identi AND num_identi = :num_identi");

			$existe -> bindParam(":id_tipo_identi",	$id_tipo_identi,	PDO::PARAM_INT);
			$existe -> bindParam(":num_identi",		$num_identi,		PDO::PARAM_INT);

			$existe -> execute();

			$cantidad = $existe -> fetch();

			if ($cantidad['cant'] == 0) 
			{
				# REGISTRAR USUARIO
				$insert = Conexion::conectar()->prepare("INSERT INTO usuarios(id_tipo_identi, num_identi, nombre, apellido, email, telefono, direccion, id_perfil, clave, foto, intentos, sesion, codigo_validacion, notificaciones, terminos_condiciones, fecha_usuario, estado) VALUES (:id_tipo_identi, :num_identi, :nombre, :apellido, :email, :telefono, :direccion, :id_perfil, :clave, :foto, :intentos, :sesion, :codigo_validacion, :notificaciones, :terminos_condiciones, :fecha_usuario, :estado)");

				$insert -> bindParam(":id_tipo_identi", $id_tipo_identi, 	PDO::PARAM_INT);
				$insert -> bindParam(":num_identi", 	$num_identi, 		PDO::PARAM_INT);
				$insert -> bindParam(":nombre", 		$nombre, 			PDO::PARAM_STR);
				$insert -> bindParam(":apellido", 		$apellido, 			PDO::PARAM_STR);
				$insert -> bindParam(":email", 			$email, 			PDO::PARAM_STR);
				$insert -> bindParam(":telefono", 		$telefono, 			PDO::PARAM_STR);
				$insert -> bindParam(":direccion", 		$direccion, 		PDO::PARAM_STR);
				$insert -> bindParam(":id_perfil", 		$id_perfil, 		PDO::PARAM_INT);
				$insert -> bindParam(":clave", 			$encrypt, 			PDO::PARAM_STR);
				$insert -> bindParam(":foto", 			$foto, 				PDO::PARAM_STR);
				$insert -> bindParam(":intentos", 		$intentos, 			PDO::PARAM_STR);
				$insert -> bindParam(":sesion", 		$sesion, 			PDO::PARAM_STR);
				$insert -> bindParam(":codigo_validacion",$codigo,			PDO::PARAM_STR);
				$insert -> bindParam(":notificaciones",	$notificaciones,	PDO::PARAM_INT);
				$registrar -> bindParam(":terminos_condiciones", $terminos_condiciones, PDO::PARAM_INT);
				$insert -> bindParam(":fecha_usuario", 	$fecha_usuario, 	PDO::PARAM_STR);
				$insert -> bindParam(":estado", 		$estado, 			PDO::PARAM_STR);

				if ($insert -> execute()) 
				{
					# REGISTRO EXITOSO
					#	PROGRAMACION DE CORREO DE VALIDACION DE CUENTA
					$asunto 	= 'Registro Usuario';
					$plantilla 	= 'activacionCuenta';
					$link_validacion = "https://www.clickstore.co/app/index.php?email=" . $email . "&codigo_validacion=" . $codigo;

					$parametros = json_encode(array("nombre" 	=> $nombre, 
													"apellido" 	=> $apellido, 
													"email" 	=> $email, 
													"clave"		=> $clave,
													"link_validacion" => $link_validacion));		

					$programarCorreo = Email::programarCorreo($email,$nombre,$asunto,$plantilla,$parametros);

					$resultado = json_encode(array("estado" => "registrado"));
					
				}
				else
				{
					# ERROR
					$resultado = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));
					
				}

			}
			else
			{
				# EL USUARIO YA EXISTE
				$resultado = json_encode(array("estado" => "ya_existe"));
				
			}

			return $resultado;
		}

		#	CONSULTAR INFORMACION DE USUARIO
		public static function infoUsuarioMod($pk_usuario)
		{
			$rpk_usuario = explode('-',$pk_usuario);

			$select = Conexion::conectar()->prepare("SELECT * FROM usuarios WHERE id_tipo_identi = :id_tipo_identi AND num_identi = :num_identi");

			$select -> bindParam(":id_tipo_identi",	$rpk_usuario[0],PDO::PARAM_INT);
			$select -> bindParam(":num_identi",		$rpk_usuario[1],PDO::PARAM_INT);

			$select -> execute();

			$resultado = $select -> fetch();

			return $resultado;

		}

		#	ACTUALIZAR USUARIO
		public static function actualizarUsuarioMod($datosUsuario)
		{
			$pk_usuario = $datosUsuario['pk_usuario'];
			$rpk_usuario= explode('-',$pk_usuario);

			$nombre 	= $datosUsuario['nombre'];
			$apellido 	= $datosUsuario['apellido'];
			$email 		= $datosUsuario['email'];
			$telefono 	= $datosUsuario['telefono'];
			$id_perfil 	= $datosUsuario['id_perfil'];

			$update = Conexion::conectar()->prepare("UPDATE usuarios
														SET nombre		= :nombre,
															apellido 	= :apellido,
															email 		= :email,
															telefono 	= :telefono,
															id_perfil 	= :id_perfil
													  WHERE id_tipo_identi	= :id_tipo_identi
													  AND 	num_identi 		= :num_identi");

			$update -> bindParam(":nombre", 		$nombre, 		PDO::PARAM_STR);
			$update -> bindParam(":apellido", 		$apellido,		PDO::PARAM_STR);
			$update -> bindParam(":email", 			$email, 		PDO::PARAM_STR);
			$update -> bindParam(":telefono", 		$telefono, 		PDO::PARAM_STR);
			$update -> bindParam(":id_perfil", 		$id_perfil, 	PDO::PARAM_INT);
			$update -> bindParam(":id_tipo_identi", $rpk_usuario[0],PDO::PARAM_INT);
			$update -> bindParam(":num_identi", 	$rpk_usuario[1],PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				# ACTUALIZACION EXITOSA
				$resultado = json_encode(array("estado" => "actualizado"));
				return $resultado;
			}
			else
			{
				# ERROR
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
				return $resultado;
			}

		}

		#	CAMBIAR ESTADO DE USUARIO
		public static function estadoUsuarioMod($datosUsuario)
		{
			$estado 	= $datosUsuario['estado'];
			$pk_usuario = $datosUsuario['pk_usuario'];
			$rpk_usuario= explode('-', $pk_usuario);

			$update = Conexion::conectar()->prepare("UPDATE usuarios SET estado = :estado WHERE id_tipo_identi = :id_tipo_identi AND num_identi = :num_identi");

			$update -> bindParam(":estado",			$estado,			PDO::PARAM_STR);
			$update -> bindParam(":id_tipo_identi",	$rpk_usuario[0],	PDO::PARAM_INT);
			$update -> bindParam(":num_identi",		$rpk_usuario[1],	PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				$resultado = json_encode(array("estado" => "success"));
				return $resultado;
			}
			else
			{
				$resultado = json_encode(array("estado" => "error"));
				return $resultado;
			}

		}

	}