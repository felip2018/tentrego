<?php
	require_once "conexion.php";
	/**
	* MODELO DE ATRIBUTOS DE PRODUCTOS
	*/
	class AtributosMod extends Conexion
	{
		#	CONSULTAR LISTA DE ATRIBUTOS DE PRODUCTOS
		public static function listaAtributosMod()
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM atributos");
			$select -> execute();
			$resultado = $select -> fetchAll();
			return $resultado;
		}

		#	REGISTRAR ATRIBUTO EN EL SISTEMA
		public static function registrarAtributoMod($datosAtributo)
		{
			$nombre 		= $datosAtributo['nombre'];
			$descripcion 	= $datosAtributo['descripcion'];

			#	VALIDAR SI EL ATRIBUTO YA SE ENCUENTRA REGISTRADO
			$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant FROM atributos WHERE nombre LIKE ':nombre'");

			$existe -> bindParam(":nombre",	$nombre, PDO::PARAM_STR);

			$existe -> execute();

			$cantidad = $existe -> fetch();

			if ($cantidad['cant'] == 0) 
			{
				# CONSULTAMOS EL CONSECUTIVO DE LA TABLA: atributos
				$consulta = Conexion::conectar()->prepare("SELECT MAX(id_atributo) id_atributo FROM atributos");
				$consulta -> execute();
				$maximo = $consulta -> fetch();

				$id_atributo = ($maximo['id_atributo'] == null) ? 1 : $maximo['id_atributo'] + 1;
				$estado = "Activo";

				# REGISTRAR ATRIBUTO
				$insert = Conexion::conectar()->prepare("INSERT INTO atributos(id_atributo, nombre, descripcion, estado) VALUES (:id_atributo, :nombre, :descripcion, :estado)");

				$insert -> bindParam(":id_atributo",$id_atributo, 	PDO::PARAM_INT);
				$insert -> bindParam(":nombre", 	$nombre, 		PDO::PARAM_STR);
				$insert -> bindParam(":descripcion",$descripcion, 	PDO::PARAM_STR);
				$insert -> bindParam(":estado", 	$estado, 		PDO::PARAM_STR);

				if ($insert -> execute()) 
				{
					# REGISTRO EXITOSO
					$resultado = json_encode(array("estado" => "registrado"));
					return $resultado;
				}
				else
				{
					# ERROR
					$resultado = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));
					return $resultado;
				}

			}
			else
			{
				# EL ATRIBUTO YA EXISTE
				$resultado = json_encode(array("estado" => "ya_existe"));
				return $resultado;
			}

		}

		#	CONSULTAR INFORMACION DE ATRIBUTO
		public static function infoAtributoMod($id_atributo)
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM atributos WHERE id_atributo = :id_atributo");

			$select -> bindParam(":id_atributo", $id_atributo, PDO::PARAM_INT);
			$select -> execute();

			$resultado = $select -> fetch();

			return $resultado;

		}

		#	ACTUALIZAR MARCA
		public static function actualizarAtributoMod($datosAtributo)
		{
			$id_atributo 	= $datosAtributo['id_atributo'];
			$nombre 		= $datosAtributo['nombre'];
			$descripcion 	= $datosAtributo['descripcion'];

			
			$update = Conexion::conectar()->prepare("UPDATE atributos
													 SET 	nombre		= :nombre,
													 		descripcion = :descripcion
												  	 WHERE 	id_atributo	= :id_atributo");

			$update -> bindParam(":nombre", 	$nombre, 	  PDO::PARAM_STR);
			$update -> bindParam(":descripcion",$descripcion, PDO::PARAM_STR);
			$update -> bindParam(":id_atributo",$id_atributo, PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				# ACTUALIZACION EXITOSA
				$resultado = json_encode(array("estado" => "actualizado"));
			}
			else
			{
				# ERROR
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
			}
					
			return $resultado;
		}

		#	CAMBIAR ESTADO DE ATRIBUTO
		public static function estadoAtributoMod($datosAtributo)
		{
			$estado 		= $datosAtributo['estado'];
			$id_atributo 	= $datosAtributo['id_atributo'];

			$update = Conexion::conectar()->prepare("UPDATE atributos 
													SET 	estado 		= :estado 
													WHERE 	id_atributo = :id_atributo");

			$update -> bindParam(":estado",		$estado,	 PDO::PARAM_STR);
			$update -> bindParam(":id_atributo",$id_atributo,PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				$resultado = json_encode(array("estado" => "ok"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error"));
			}

			return $resultado;
		}

	}