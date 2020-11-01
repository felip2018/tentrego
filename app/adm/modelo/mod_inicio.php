<?php
	require_once "conexion.php";
	/**
	* MODELO DE INICIO
	*/
	class InicioMod extends Conexion
	{
		
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

		#	VALIDACION DE PERFIL DE USUARIO
		public static function validarPerfilMod($email,$id_perfil)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 	id_perfil
														FROM 	usuarios
														WHERE	email 		= :email");

			$consulta -> bindParam(":email", 	$email, 	PDO::PARAM_STR);

			$consulta -> execute();

			$user = $consulta -> fetch();

			if ($user['id_perfil'] == 1) 
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

	}
?>