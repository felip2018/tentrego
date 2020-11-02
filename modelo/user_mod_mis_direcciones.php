<?php
	require_once "conexion.php";
	/**
	* MODELO DE MIS DIRECCIONES
	*/
	class MisDireccionesMod extends Conexion
	{
		# 	CONSULTAR MIS DIRECCIONES
		public static function listadoDireccionesMod($email)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														usuarios_direcciones.id_direccion,
														usuarios_direcciones.email,
														usuarios_direcciones.telefono,
														usuarios_direcciones.direccion,
														usuarios_direcciones.barrio,
														usuarios_direcciones.id_pais,
														usuarios_direcciones.id_dpto,
														usuarios_direcciones.id_ciudad,
														usuarios_direcciones.indicaciones,
														usuarios_direcciones.fecha,
														usuarios_direcciones.estado,
														ciudad.nombre ciudad,
														departamento.nombre dpto
														FROM 	usuarios_direcciones
														INNER JOIN ciudad ON ciudad.id_ciudad = usuarios_direcciones.id_ciudad
														AND ciudad.id_dpto = usuarios_direcciones.id_dpto
														AND ciudad.id_pais = usuarios_direcciones.id_pais
														INNER JOIN departamento ON departamento.id_dpto = ciudad.id_dpto
														WHERE usuarios_direcciones.email = :email");

			$consulta -> bindParam(":email", $email, PDO::PARAM_STR);
			$consulta -> execute();
			$direcciones = $consulta -> fetchAll(PDO::FETCH_ASSOC);
			return $direcciones;
		}

		#	CONSULTAR LISTA DE DEPARTAMENTOS
		public static function listaDptosMod()
		{
			$consulta = Conexion::conectar()->prepare("SELECT * 
														FROM departamento
														ORDER BY nombre ASC");
			$consulta -> execute();
			$dptos = $consulta->fetchAll(PDO::FETCH_ASSOC);
			return $dptos;
		}

		#	CONSULTAR LISTA DE CIUDADES
		public static function listadoCiudadesMod($id_dpto)
		{
			$consulta = Conexion::conectar()->prepare("SELECT *
														FROM 	ciudad
														WHERE 	id_dpto 	= :id_dpto
														ORDER BY nombre ASC");

			$consulta -> bindParam(":id_dpto", $id_dpto, PDO::PARAM_INT);
			$consulta -> execute();
			$ciudades = $consulta -> fetchAll(PDO::FETCH_ASSOC);
			return $ciudades;
		}

		#	REGISTRAR DIRECCION
		public static function registrarDireccionMod($datosDireccion)
		{
			$email 		= $datosDireccion['email'];
			$direccion 	= $datosDireccion['direccion'];
			$barrio 	= $datosDireccion['barrio'];
			$indicaciones 	= $datosDireccion['indicaciones'];
			$id_dpto 	= $datosDireccion['id_dpto'];
			$id_ciudad 	= $datosDireccion['id_ciudad'];
			$telefono 	= $datosDireccion['telefono'];

			#	CONSULTA CONSECUTIVO
			$consulta = Conexion::conectar()->prepare("SELECT MAX(id_direccion) id_direccion
														FROM usuarios_direcciones");
			$consulta -> execute();
			$consecutivo = $consulta -> fetch(PDO::FETCH_ASSOC);

			$id_direccion = ($consecutivo['id_direccion'] == null) ? 1 : $consecutivo['id_direccion'] + 1;
			$id_pais = 169;
			$fecha 	= date("Y-m-d");
			$estado = "Activo";

			#	REGISTRAR DIRECCION
			$insert = Conexion::conectar()->prepare("INSERT INTO usuarios_direcciones(id_direccion, email, telefono, direccion, barrio, id_pais, id_dpto, id_ciudad, indicaciones, fecha, estado) VALUES (:id_direccion, :email, :telefono, :direccion, :barrio, :id_pais, :id_dpto, :id_ciudad, :indicaciones, :fecha, :estado)");

			$insert -> bindParam(":id_direccion", 	$id_direccion, 	PDO::PARAM_INT);
			$insert -> bindParam(":email", 			$email, 		PDO::PARAM_STR);
			$insert -> bindParam(":telefono", 		$telefono, 		PDO::PARAM_STR);
			$insert -> bindParam(":direccion", 		$direccion, 	PDO::PARAM_STR);
			$insert -> bindParam(":barrio", 		$barrio, 		PDO::PARAM_STR);
			$insert -> bindParam(":id_pais", 		$id_pais, 		PDO::PARAM_INT);
			$insert -> bindParam(":id_dpto", 		$id_dpto, 		PDO::PARAM_INT);
			$insert -> bindParam(":id_ciudad", 		$id_ciudad, 	PDO::PARAM_INT);
			$insert -> bindParam(":indicaciones", 	$indicaciones, 	PDO::PARAM_STR);
			$insert -> bindParam(":fecha", 			$fecha, 		PDO::PARAM_STR);
			$insert -> bindParam(":estado",			$estado, 		PDO::PARAM_STR);

			if ($insert->execute()) 
			{
				$resultado = json_encode(array("estado" => "registrado"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));	
			}
			return $resultado;
		}

		#	CONSULTAR INFORMACION DE DIRECCION
		public static function infoDireccionMod($id_direccion)
		{
			$consulta = Conexion::conectar()->prepare("SELECT *	
														FROM 	usuarios_direcciones
														WHERE 	id_direccion 	= :id_direccion");

			$consulta -> bindParam(":id_direccion", $id_direccion, PDO::PARAM_INT);
			$consulta -> execute();
			$direccion = $consulta->fetch(PDO::FETCH_ASSOC);
			return $direccion;
		}

		#	ACTUALIZAR DIRECCION
		public static function actualizarDireccionMod($datosDireccion)
		{
			$id_direccion 	= $datosDireccion['id_direccion'];
			$email 			= $datosDireccion['email'];
			$direccion 		= $datosDireccion['direccion'];
			$barrio 		= $datosDireccion['barrio'];
			$indicaciones 	= $datosDireccion['indicaciones'];
			$id_dpto 		= $datosDireccion['id_dpto'];
			$id_ciudad 		= $datosDireccion['id_ciudad'];
			$telefono 		= $datosDireccion['telefono'];

			$update = Conexion::conectar()->prepare("UPDATE 	usuarios_direcciones
														SET 	direccion 	= :direccion,
																barrio 		= :barrio,
																indicaciones= :indicaciones,
																id_dpto 	= :id_dpto,
																id_ciudad 	= :id_ciudad,
																telefono 	= :telefono
													WHERE 		id_direccion= :id_direccion");

			$update -> bindParam(":direccion", 		$direccion, 	PDO::PARAM_STR);
			$update -> bindParam(":barrio", 		$barrio, 		PDO::PARAM_STR);
			$update -> bindParam(":indicaciones", 	$indicaciones, 	PDO::PARAM_STR);
			$update -> bindParam(":id_dpto", 		$id_dpto, 		PDO::PARAM_INT);
			$update -> bindParam(":id_ciudad", 		$id_ciudad, 	PDO::PARAM_INT);
			$update -> bindParam(":telefono", 		$telefono, 		PDO::PARAM_STR);
			$update -> bindParam(":id_direccion", 	$id_direccion, 	PDO::PARAM_INT);

			if ($update->execute()) 
			{
				$resultado = json_encode(array("estado" => "actualizado"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));	
			}
			return $resultado;

		}

		#	CAMBIAR ESTADO DE DIRECCION
		public static function estadoDireccionMod($datosDireccion)
		{
			$estado 		= $datosDireccion['estado'];
			$id_direccion 	= $datosDireccion['id_direccion'];

			$update = Conexion::conectar()->prepare("UPDATE usuarios_direcciones
														SET	estado 			= :estado
													  WHERE id_direccion 	= :id_direccion");

			$update -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);
			$update -> bindParam(":id_direccion", 	$id_direccion, 	PDO::PARAM_INT);

			if ($update->execute()) 
			{
				$resultado = json_encode(array("estado" => "success"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
			}
			return $resultado;
		}

	}