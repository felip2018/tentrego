<?php
	require_once "conexion.php";
	/**
	* MODELO DE CATEGORIAS DE PRODUCTOS
	*/
	class CategoriasMod extends Conexion
	{
		#	CONSULTAR LISTA DE CATEGORIAS DE PRODUCTOS
		public static function listaCategoriasMod()
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM categorias");
			$select -> execute();
			$resultado = $select -> fetchAll();
			return $resultado;
		}

		#	CONSULTAR LISTA DE CLASIFICACIONES POR CATEGORIA SELECCIONADA
		public static function listaClasificacionMod($id_categoria)
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM clasificacion WHERE id_categoria = :id_categoria ORDER BY id_clasificacion ASC");
			$select -> bindParam(":id_categoria",	$id_categoria,	PDO::PARAM_INT);
			$select -> execute();
			$resultado = $select -> fetchAll();
			return $resultado;	
		}

		#	REGISTRAR CATEGORIA EN EL SISTEMA
		public static function registrarCategoriaMod($datosCategoria)
		{
			$nombre 		= $datosCategoria['nombre'];
			$descripcion 	= $datosCategoria['descripcion'];

			#	VALIDAR SI LA CATEGORIA YA SE ENCUENTRA REGISTRADA
			$existe = Conexion::conectar()->prepare("SELECT COUNT(*) cant FROM categorias WHERE nombre LIKE ':nombre'");

			$existe -> bindParam(":nombre",	$nombre, PDO::PARAM_STR);

			$existe -> execute();

			$cantidad = $existe -> fetch();

			if ($cantidad['cant'] == 0) 
			{
				# CONSULTAMOS EL CONSECUTIVO DE LA TABLA: categorias
				$consulta = Conexion::conectar()->prepare("SELECT MAX(id_categoria) id_categoria FROM categorias");
				$consulta -> execute();
				$maximo = $consulta -> fetch();

				$id_categoria = ($maximo['id_categoria'] == null) ? 1 : $maximo['id_categoria'] + 1;
				$fecha = date('Y-m-d');
				$estado = "Activo";

				# REGISTRAR CATEGORIA
				$insert = Conexion::conectar()->prepare("INSERT INTO categorias(id_categoria, nombre, descripcion, fecha, estado) VALUES (:id_categoria, :nombre, :descripcion, :fecha, :estado)");

				$insert -> bindParam(":id_categoria", 	$id_categoria, 	PDO::PARAM_INT);
				$insert -> bindParam(":nombre", 		$nombre, 		PDO::PARAM_STR);
				$insert -> bindParam(":descripcion", 	$descripcion, 	PDO::PARAM_STR);
				$insert -> bindParam(":fecha", 			$fecha, 		PDO::PARAM_STR);
				$insert -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);

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
				# LA CATEGORIA YA EXISTE
				$resultado = json_encode(array("estado" => "ya_existe"));
				return $resultado;
			}

		}

		#	CONSULTAR INFORMACION DE CATEGORIA
		public static function infoCategoriaMod($id_categoria)
		{
			$select = Conexion::conectar()->prepare("SELECT * FROM categorias WHERE id_categoria = :id_categoria");

			$select -> bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
			$select -> execute();

			$resultado = $select -> fetch();

			return $resultado;

		}

		#	ACTUALIZAR CATEGORIA
		public static function actualizarCategoriaMod($datosCategoria)
		{
			$id_categoria 	= $datosCategoria['id_categoria'];
			$nombre 		= $datosCategoria['nombre'];
			$descripcion 	= $datosCategoria['descripcion'];

			$update = Conexion::conectar()->prepare("UPDATE categorias
														SET nombre		= :nombre,
															descripcion = :descripcion
													  WHERE id_categoria= :id_categoria");

			$update -> bindParam(":nombre", 		$nombre, 		PDO::PARAM_STR);
			$update -> bindParam(":descripcion", 	$descripcion,	PDO::PARAM_STR);
			$update -> bindParam(":id_categoria", 	$id_categoria, 	PDO::PARAM_INT);

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

		#	CAMBIAR ESTADO DE CATEGORIA
		public static function estadoCategoriaMod($datosCategoria)
		{
			$estado 		= $datosCategoria['estado'];
			$id_categoria 	= $datosCategoria['id_categoria'];

			$update = Conexion::conectar()->prepare("UPDATE categorias SET estado = :estado WHERE id_categoria = :id_categoria");

			$update -> bindParam(":estado",			$estado,		PDO::PARAM_STR);
			$update -> bindParam(":id_categoria",	$id_categoria,	PDO::PARAM_INT);

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

		#	REGISTRAR UNA NUEVA CLASIFICACION DE CATEGORIA
		public static function registrarClasificacionMod($datosClasificacion)
		{
			$id_categoria 	= $datosClasificacion['id_categoria'];
			$nombre 		= $datosClasificacion['nombre'];
			$estado 		= $datosClasificacion['estado'];

			#	CONSULTAMOS EL CONSECUTIVO DE LA TABLA
			$consulta = Conexion::conectar()->prepare("SELECT MAX(id_clasificacion) id_clasificacion FROM clasificacion");
			$consulta -> execute();
			$maximo = $consulta -> fetch();

			$id_clasificacion = ($maximo['id_clasificacion'] == null)? 1 : $maximo['id_clasificacion'] + 1;

			#	REGISTRAMOS LA CLASIFICACION
			$insert = Conexion::conectar()->prepare("INSERT INTO clasificacion(id_clasificacion, id_categoria, nombre, estado) VALUES (:id_clasificacion, :id_categoria, :nombre, :estado)");

			$insert -> bindParam(":id_clasificacion", 	$id_clasificacion, 	PDO::PARAM_INT);
			$insert -> bindParam(":id_categoria", 		$id_categoria, 		PDO::PARAM_INT);
			$insert -> bindParam(":nombre", 			$nombre, 			PDO::PARAM_STR);
			$insert -> bindParam(":estado", 			$estado, 			PDO::PARAM_STR);

			if ($insert -> execute()) {
				$resultado = json_encode(array("estado" => "registrado"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));
			}
			return $resultado;
		}

		#	ACTUALIZAR CLASIFICACION
		public static function actualizarClasificacionMod($datosClasificacion)
		{
			$id_clasificacion 	= $datosClasificacion['id_clasificacion'];
			$nombre 			= $datosClasificacion['nombre'];

			$update = Conexion::conectar()->prepare("UPDATE clasificacion
													SET 	nombre 			= :nombre
													WHERE 	id_clasificacion= :id_clasificacion");
			$update -> bindParam(":nombre",				$nombre,			PDO::PARAM_STR);
			$update -> bindParam(":id_clasificacion", 	$id_clasificacion,	PDO::PARAM_INT);

			if ($update -> execute()) {
				$resultado = json_encode(array("estado" => "actualizado"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
			}
			return $resultado;

		}

		#	ACTUALIZAR ESTADO DE CLASIFICACION
		public static function estadoClasificacionMod($datosClasificacion)
		{
			$id_clasificacion	= $datosClasificacion['id_clasificacion'];
			$estado 			= $datosClasificacion['estado'];

			$update = Conexion::conectar()->prepare("UPDATE clasificacion 
													SET 	estado 				= :estado 
													WHERE 	id_clasificacion 	= :id_clasificacion");

			$update -> bindParam(":estado",				$estado,		PDO::PARAM_STR);
			$update -> bindParam(":id_clasificacion",	$id_clasificacion,	PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				$resultado = json_encode(array("estado" => "ok"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error","data" => $update->errorInfo()));
			}

			return $resultado;
		}

	}