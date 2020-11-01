<?php
	require_once "conexion.php";
	/**
	* MODELO DE VALIDACION
	*/
	class ValidacionMod extends Conexion
	{
		
		#	VALIDAR CUENTA
		public static function validarCuentaMod($datosValidacion)
		{
			$email 	= $datosValidacion['email'];
			$codigo = $datosValidacion['codigo'];
			

			#	CONSULTAMOS EL ESTADO DE LA CUENTA
			$consulta = Conexion::conectar()->prepare("SELECT estado FROM usuarios WHERE email = :email");

			$consulta -> bindParam(":email", $email, PDO::PARAM_STR);
			
			if($consulta -> execute())
			{
				$estado = $consulta->fetch();

				if ($estado['estado'] == "Validar") 
				{
					# ACTIVAMOS LA CUENTA DEL USUARIO
					$update = Conexion::conectar()->prepare("UPDATE usuarios
															SET 	estado 	= 'Activo'
															WHERE	email 	= :email
															AND 	codigo_validacion = :codigo");
					$update -> bindParam(":email",	$email,	PDO::PARAM_STR);
					$update -> bindParam(":codigo",	$codigo,PDO::PARAM_STR);

					if ($update -> execute()) 
					{
						$resultado = json_encode(array("estado" => "cuenta_validada"));
					}
					else
					{
						$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));	
					}
					return $resultado;
				}
				else
				{
					$resultado = json_encode(array("estado" => $estado['estado']));
					return $resultado;
				}
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $consulta->errorInfo()));	
				return $resultado;
			}
		}
	}