<?php
	require_once "conexion.php";
	/**
	* MODELO DE INICIO
	*/
	class InicioMod extends Conexion
	{
		#	VALIDACION DE PERFIL DE USUARIO
		public static function validarPerfilMod($email,$id_perfil)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 	id_perfil
														FROM 	usuarios
														WHERE	email 		= :email");

			$consulta -> bindParam(":email", 	$email, 	PDO::PARAM_STR);

			$consulta -> execute();

			$user = $consulta -> fetch();

			if ($user['id_perfil'] == 2) 
			{
				# ACCESO PERMITIDO	
				$resultado = json_encode(array("estado" => "success"));
				
			}
			else
			{
				# EL PERFIL ES INVALIDO PARA ESTE USUARIO
				$resultado = json_encode(array("estado" => "denied"));
			}
			return $resultado;
		}
		
		#	CERRAR SESION DE USUARIO
		public static function cerrarSesionMod($email)
		{
			$estado = "Desconectado";
			$sql 	= "UPDATE usuarios SET sesion = 'Desconectado' WHERE email = '".$email."'";
			$update = Conexion::conectar()->prepare($sql);

			if ($update -> execute()) 
			{
				$resultado = json_encode(array("estado" => "success"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $update -> errorInfo()));
			}

			return $resultado;
		}

		#	CONSULTAR INFORMACION DE USUARIO EN SESION
		public static function infoUsuarioMod($email)
		{
			$consulta = Conexion::conectar()->prepare("SELECT *
														FROM 	usuarios
														WHERE 	email = :email");

			$consulta -> bindParam(":email",	$email,	PDO::PARAM_STR);

			if ($consulta -> execute()) 
			{
				$info = $consulta->fetch(PDO::FETCH_ASSOC);
				$resultado = json_encode(array("estado" => (empty($info)?"vacio":"ok"),"data" => $info ));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $consulta->errorInfo()));
			}
			return $resultado;
		}

		#	ACTUALIZAR INFORMACION DE USUARIO
		public static function actualizarInfoMod($datosUsuario)
		{
			$email 		= $datosUsuario['email'];
			$nombre 	= $datosUsuario['nombre'];
			$apellido 	= $datosUsuario['apellido'];
			$num_identi = $datosUsuario['num_identi'];
			$telefono 	= $datosUsuario['telefono'];
			$direccion 	= $datosUsuario['direccion'];

			//	CONSULTAMOS LA INFORMACION DEL USUARIO PARA VALIDAR CIERTOS DATOS
			/*$consulta = Conexion::conectar()->prepare("SELECT *
														FROM 	usuarios
														WHERE 	email = :email");

			$consulta -> bindParam(":email",$email,	PDO::PARAM_STR);
			$consulta -> execute();

			$info = $consulta -> fetch(PDO::FETCH_ASSOC);*/

			if ($_FILES['foto']['name'] != "") 
			{
				if ($_FILES['foto']['type'] == "image/png" ||
					$_FILES['foto']['type'] == "image/jpg" ||
					$_FILES['foto']['type'] == "image/jpeg") 
				{
					#	CARGAR IMAGEN AL SERVIDOR 
					$ruta = "../../../adm/vista/modulos/usuarios/fotos/";
					opendir($ruta);
					$destino = $ruta.$_FILES['foto']['name'];
					copy($_FILES['foto']['tmp_name'],$destino);	
					$foto = $_FILES['foto']['name'];				

					// 	ACTUALIZAMOS LA INFO CON FOTO
					$update = Conexion::conectar()->prepare("UPDATE usuarios
															 SET 	num_identi 	= :num_identi,
															 		nombre 		= :nombre,
															 		apellido 	= :apellido,
															 		telefono 	= :telefono,
															 		direccion 	= :direccion,
															 		foto 		= :foto
															 WHERE 	email 		= :email");

					$update -> bindParam(":num_identi", $num_identi, 	PDO::PARAM_INT);
					$update -> bindParam(":nombre", 	$nombre, 		PDO::PARAM_STR);
					$update -> bindParam(":apellido", 	$apellido, 		PDO::PARAM_STR);
					$update -> bindParam(":telefono", 	$telefono, 		PDO::PARAM_STR);
					$update -> bindParam(":direccion", 	$direccion, 	PDO::PARAM_STR);
					$update -> bindParam(":foto", 		$foto, 			PDO::PARAM_STR);
					$update -> bindParam(":email", 		$email, 		PDO::PARAM_STR);

					if ($update -> execute()) 
					{
						# SE ACTUALIZO LA INFORMACION DE USUARIO
						$resultado = json_encode(array("estado" => "actualizado"));
					}
					else
					{
					 	# HA OCURRIDO UN ERROR
					 	$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
					}
				}
				else
				{
					//	EL FORMATO DE LA FOTO ES INVALIDO
					$resultado = json_encode(array("estado" => "error", "data" => "El formato del archivo para la foto de perfil es inválido, solo se admiten archivos de imagen (png, jpg, jpeg)"));
				}
			}
			else
			{
				//	ACTUALIZAMOS LA INFO SIN FOTO
				$update = Conexion::conectar()->prepare("UPDATE usuarios
														 SET 	num_identi 	= :num_identi,
														 		nombre 		= :nombre,
														 		apellido 	= :apellido,
														 		telefono 	= :telefono,
														 		direccion 	= :direccion
														 WHERE 	email 		= :email");

				$update -> bindParam(":num_identi", $num_identi, 	PDO::PARAM_INT);
				$update -> bindParam(":nombre", 	$nombre, 		PDO::PARAM_STR);
				$update -> bindParam(":apellido", 	$apellido, 		PDO::PARAM_STR);
				$update -> bindParam(":telefono", 	$telefono, 		PDO::PARAM_STR);
				$update -> bindParam(":direccion", 	$direccion, 	PDO::PARAM_STR);
				$update -> bindParam(":email", 		$email, 		PDO::PARAM_STR);

				if ($update -> execute()) 
				{
					# SE ACTUALIZO LA INFORMACION DE USUARIO
					$resultado = json_encode(array("estado" => "actualizado"));
				}
				else
				{
				 	# HA OCURRIDO UN ERROR
				 	$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
				}
			}

			return $resultado;

		}

		#	CONSULTAR LISTA DE PEDIDOS DE USUARIO, CLASIFICADOS POR ESTADO
		public static function pedidosUsuarioMod($email)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														(SELECT COUNT(*) FROM pedido WHERE email = :email AND estado IN ('por pagar','contra entrega','pendiente')) por_pagar,
														(SELECT COUNT(*) FROM pedido WHERE email = :email AND estado = 'cancelado') cancelado,
														(SELECT COUNT(*) FROM pedido WHERE email = :email AND estado = 'pagado') pagado,
														(SELECT COUNT(*) FROM pedido WHERE email = :email AND estado = 'entregado') entregado
														FROM DUAL");

			$consulta -> bindParam(":email",$email,	PDO::PARAM_STR);
			$consulta -> execute();
			$pedidos = $consulta -> fetch(PDO::FETCH_ASSOC);
			$resultado = json_encode(array("estado" => (!empty($pedidos)?"success":"vacio"), "data" => $pedidos));
			return $resultado;
		}

	}
?>