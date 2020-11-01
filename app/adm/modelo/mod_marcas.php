<?php
	require_once "conexion.php";
	/**
	* MODELO DE MARCAS DE PRODUCTOS
	*/
	class MarcasMod extends Conexion
	{
		#	CONSULTAR LISTA DE MARCAS DE PRODUCTOS
		public static function listaMarcasMod()
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM marcas");
			$select -> execute();
			$resultado = $select -> fetchAll();
			return $resultado;
		}

		#	REGISTRAR MARCA EN EL SISTEMA
		public static function registrarMarcaMod($datosMarca)
		{
			$nombre = $datosMarca['nombre'];

			#	VALIDAR SI LA MARCA YA SE ENCUENTRA REGISTRADA
			$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant FROM marcas WHERE nombre LIKE ':nombre'");

			$existe -> bindParam(":nombre",	$nombre, PDO::PARAM_STR);

			$existe -> execute();

			$cantidad = $existe -> fetch();

			if ($cantidad['cant'] == 0) 
			{
				# CONSULTAMOS EL CONSECUTIVO DE LA TABLA: marcas
				$consulta = Conexion::conectar()->prepare("SELECT MAX(id_marca) id_marca FROM marcas");
				$consulta -> execute();
				$maximo = $consulta -> fetch();

				$id_marca = ($maximo['id_marca'] == null) ? 1 : $maximo['id_marca'] + 1;
				$estado = "Activo";

				# CARGAR LOGO
				if ($_FILES['imagen']['name'] != "") 
				{
					if ($_FILES['imagen']['type'] == "image/png" ||
						$_FILES['imagen']['type'] == "image/jpg" ||
						$_FILES['imagen']['type'] == "image/jpeg") 
					{
						#	CARGAR IMAGEN AL SERVIDOR
						$ruta = "../modulos/marcas/logos/";
						opendir($ruta);
						$destino = $ruta.$_FILES['imagen']['name'];
						copy($_FILES['imagen']['tmp_name'],$destino);	
						$logo = $_FILES['imagen']['name'];				
					}
				}
				else
				{
					$logo = "";
				}

				# REGISTRAR MARCA
				$insert = Conexion::conectar()->prepare("INSERT INTO marcas(id_marca, nombre, logo, estado) VALUES (:id_marca, :nombre, :logo, :estado)");

				$insert -> bindParam(":id_marca", 	$id_marca, 	PDO::PARAM_INT);
				$insert -> bindParam(":nombre", 	$nombre, 	PDO::PARAM_STR);
				$insert -> bindParam(":logo", 		$logo, 		PDO::PARAM_STR);
				$insert -> bindParam(":estado", 	$estado, 	PDO::PARAM_STR);

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
				# LA MARCA YA EXISTE
				$resultado = json_encode(array("estado" => "ya_existe"));
				return $resultado;
			}

		}

		#	CONSULTAR INFORMACION DE MARCA
		public static function infoMarcaMod($id_marca)
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM marcas WHERE id_marca = :id_marca");

			$select -> bindParam(":id_marca", $id_marca, PDO::PARAM_INT);
			$select -> execute();

			$resultado = $select -> fetch();

			return $resultado;

		}

		#	ACTUALIZAR MARCA
		public static function actualizarMarcaMod($datosMarca)
		{
			$id_marca 	= $datosMarca['id_marca'];
			$nombre 	= $datosMarca['nombre'];

			if ($_FILES['imagen']['name'] != "") 
			{
				if ($_FILES['imagen']['type'] == "image/png" ||
					$_FILES['imagen']['type'] == "image/jpg" ||
					$_FILES['imagen']['type'] == "image/jpeg") 
				{
					#	CARGAR IMAGEN AL SERVIDOR
					$ruta = "../modulos/marcas/logos/";
					opendir($ruta);
					$destino = $ruta.$_FILES['imagen']['name'];
					copy($_FILES['imagen']['tmp_name'],$destino);	
					$logo = $_FILES['imagen']['name'];		

					$update = Conexion::conectar()->prepare("UPDATE marcas
															SET 	nombre		= :nombre,
																	logo 		= :logo
													  		WHERE 	id_marca	= :id_marca");

					$update -> bindParam(":nombre", 	$nombre, 	PDO::PARAM_STR);
					$update -> bindParam(":logo", 		$logo, 		PDO::PARAM_STR);
					$update -> bindParam(":id_marca", 	$id_marca, 	PDO::PARAM_INT);

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
			}
			else
			{
				$update = Conexion::conectar()->prepare("UPDATE marcas
														SET 	nombre		= :nombre
													  	WHERE 	id_marca	= :id_marca");

				$update -> bindParam(":nombre", 	$nombre, 	PDO::PARAM_STR);
				$update -> bindParam(":id_marca", 	$id_marca, 	PDO::PARAM_INT);

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

			

		}

		#	CAMBIAR ESTADO DE MARCA
		public static function estadoMarcaMod($datosMarca)
		{
			$estado 	= $datosMarca['estado'];
			$id_marca 	= $datosMarca['id_marca'];

			$update = Conexion::conectar()->prepare("UPDATE marcas 
													SET 	estado 		= :estado 
													WHERE 	id_marca 	= :id_marca");

			$update -> bindParam(":estado",		$estado,	PDO::PARAM_STR);
			$update -> bindParam(":id_marca",	$id_marca,	PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				$resultado = json_encode(array("estado" => "ok"));
				return $resultado;
			}
			else
			{
				$resultado = json_encode(array("estado" => "error"));
				return $resultado;
			}

		}

	}