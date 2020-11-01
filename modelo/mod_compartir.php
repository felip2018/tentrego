<?php
	require_once "conexion.php";
	/**
	* MODELO DE LA SECCION DE COMPARTIR
	*/
	class CompartirMod extends Conexion
	{
		
		#	CONTEO DE VISITA POR REFERENCIA DE ENLACE DESDE FACEBOOK
		public static function conteoVisitaMod($origen,$recomienda)
		{
			$fecha = date("Y-m-d");
			
			#	CONSULTAMOS SI YA HAY UN REGISTRO DE ESTA RECOMENDACION Y ESTA FECHA DE VISITA
			$consulta = Conexion::conectar()->prepare("SELECT 	COUNT(*) cant 
														FROM 	visitas_pagina
														WHERE 	origen 		= :origen
														AND 	email 		= :recomienda
														AND 	fecha 		= :fecha");

			$consulta -> bindParam(":origen", 		$origen, 		PDO::PARAM_STR);
			$consulta -> bindParam(":recomienda", 	$recomienda, 	PDO::PARAM_STR);
			$consulta -> bindParam(":fecha", 		$fecha,			PDO::PARAM_STR);

			$consulta -> execute();

			$resultado = $consulta->fetch(PDO::FETCH_ASSOC);

			if ($resultado['cant'] > 0) 
			{
				# ACTUALIZAMOS EL CONTADOR EN EL REGISTRO ENCONTRADO
				$update = Conexion::conectar()->prepare("UPDATE 	visitas_pagina
															SET 	cantidad 	= cantidad +1
															WHERE 	origen 		= :origen
															AND 	email 		= :recomienda
															AND 	fecha 		= :fecha");

				$update -> bindParam(":origen", 		$origen, 		PDO::PARAM_STR);
				$update -> bindParam(":recomienda", 	$recomienda, 	PDO::PARAM_STR);
				$update -> bindParam(":fecha", 			$fecha,			PDO::PARAM_STR);

				if($update -> execute())
				{
					$respuesta = true;
				}
				else
				{
					$respuesta = false;
				}
			}
			else
			{
				# REGISTRAMOS EL CONTADOR
				$cantidad = 1;

				$insert = Conexion::conectar()->prepare("INSERT INTO visitas_pagina(id_visita, origen, email, fecha, cantidad) VALUES (null, :origen, :email, :fecha, :cantidad)");

				$insert -> bindParam(":origen", 	$origen, 	PDO::PARAM_STR);
				$insert -> bindParam(":email", 		$recomienda,PDO::PARAM_STR);
				$insert -> bindParam(":fecha", 		$fecha, 	PDO::PARAM_STR);
				$insert -> bindParam(":cantidad", 	$cantidad, 	PDO::PARAM_INT);

				if($insert -> execute())
				{
					$respuesta = true;
				}
				else
				{
					$respuesta = false;
				}
			}

			return $respuesta;

		}
	}