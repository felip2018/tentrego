<?php
	require_once "conexion.php";
	/**
	* MODELO DE MIS RESEÑAS
	*/
	class MisResenasMod extends Conexion
	{
		#	VALIDAR RESEÑA
		public static function validarResenaMod($datosConsulta)
		{
			$id_pedido 		= $datosConsulta['id_pedido'];
			$id_producto 	= $datosConsulta['id_producto'];
			$email 			= $datosConsulta['email'];

			$consulta = Conexion::conectar()->prepare("SELECT 	COUNT(*) cant
														FROM 	producto_resena
														WHERE 	id_pedido 		= :id_pedido
														AND 	id_producto 	= :id_producto
														AND 	email 			= :email");


			$consulta -> bindParam(":id_pedido", 	$id_pedido, 	PDO::PARAM_INT);
			$consulta -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);
			$consulta -> bindParam(":email", 		$email, 		PDO::PARAM_STR);

			$consulta -> execute();

			$existe = $consulta -> fetch(PDO::FETCH_ASSOC);

			$resultado = json_encode(array("estado" => ($existe['cant'] == 1)?"existe":"sin resena"));

			return $resultado;
		}

		#	REGISTRAR RESEÑA DE PRODUCTO
		public static function salvarResenaMod($datosResena)
		{
			$id_pedido 		= $datosResena['id_pedido'];
			$id_producto 	= $datosResena['id_producto'];
			$email 			= $datosResena['email'];
			$calificacion 	= $datosResena['calificacion'];
			$comentarios 	= $datosResena['comentarios'];

			#	CONSULTAMOS EL CONSECUTIVO DE RESEÑA
			$consulta = Conexion::conectar()->prepare("SELECT 	MAX(id_resena) id_resena
														FROM 	producto_resena");
			$consulta ->execute();
			$consecutivo = $consulta->fetch(PDO::FETCH_ASSOC);

			$id_resena = ($consecutivo['id_resena'] == null) ? 1 : $consecutivo['id_resena'] + 1;
			$fecha = date('Y-m-d H:i:s');
			$estado = "Activo";

			$insert  = Conexion::conectar()->prepare("INSERT INTO producto_resena(id_resena, id_pedido, id_producto, email, calificacion, comentarios, fecha, estado) VALUES (:id_resena, :id_pedido, :id_producto, :email, :calificacion, :comentarios, :fecha, :estado)");

			$insert -> bindParam(":id_resena", 		$id_resena, 	PDO::PARAM_INT);
			$insert -> bindParam(":id_pedido", 		$id_pedido, 	PDO::PARAM_INT);
			$insert -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);
			$insert -> bindParam(":email", 			$email, 		PDO::PARAM_STR);
			$insert -> bindParam(":calificacion", 	$calificacion, 	PDO::PARAM_INT);
			$insert -> bindParam(":comentarios", 	$comentarios, 	PDO::PARAM_STR);
			$insert -> bindParam(":fecha", 			$fecha, 		PDO::PARAM_STR);
			$insert -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);

			if ($insert -> execute()) 
			{
				$resultado = json_encode(array("estado" => "registrado"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));	
			}
			return $resultado;
		}

		#	CONSULTAR LISTA DE RESEÑAS CREADAS
		public static function listaResenasMod($email)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														producto_resena.id_resena,
														producto_resena.id_pedido,
														producto_resena.id_producto,
														producto_resena.email,
														producto_resena.calificacion,
														producto_resena.comentarios,
														producto_resena.fecha,
														producto_resena.estado,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre_producto
														FROM 	producto_resena
														INNER JOIN producto ON producto.id_producto = producto_resena.id_producto
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														WHERE 	producto_resena.email 	= :email
														ORDER BY producto_resena.fecha DESC");

			$consulta -> bindParam(":email", $email, PDO::PARAM_STR);
			$consulta -> execute();
			$resenas = $consulta -> fetchAll(PDO::FETCH_ASSOC);
			//$resultado = json_encode(array("estado" => (!empty($resenas))?"success":"vacio", "data" => $resenas));
			return $resenas;
		}

		#	CONSULTAR INFORMACION DE RESEÑA SELECCIONADA
		public static function infoResenaMod($id_resena)
		{
			$consulta = Conexion::conectar()->prepare("SELECT * 
														FROM 	producto_resena
														WHERE 	id_resena 	= :id_resena");

			$consulta -> bindParam(":id_resena", $id_resena, PDO::PARAM_INT);
			$consulta -> execute();
			$info = $consulta -> fetch(PDO::FETCH_ASSOC);
			return $info;
		}

		#	ACTUALIZAR RESEÑA
		public static function actualizarResenaMod($datosResena)
		{
			$id_resena 		= $datosResena['id_resena'];
			$calificacion 	= $datosResena['calificacion'];
			$comentarios 	= $datosResena['comentarios'];

			$update = Conexion::conectar()->prepare("UPDATE producto_resena
														SET	calificacion 	= :calificacion,
															comentarios 	= :comentarios
													WHERE 	id_resena 		= :id_resena");

			$update -> bindParam(":calificacion", 	$calificacion, 	PDO::PARAM_STR);
			$update -> bindParam(":comentarios", 	$comentarios, 	PDO::PARAM_STR);
			$update -> bindParam(":id_resena", 		$id_resena, 	PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				$resultado = json_encode(array("estado" => "actualizado"));
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
			}
			return $resultado;
		}

		#	CAMBIAR ESTADO DE LA RESEÑA
		public static function estadoResenaMod($datosResena)
		{
			$estado 	= $datosResena['estado'];
			$id_resena 	= $datosResena['id_resena'];

			$update = Conexion::conectar()->prepare("UPDATE 	producto_resena
														SET 	estado 		= :estado
													  WHERE		id_resena 	= :id_resena");

			$update -> bindParam(":estado", 	$estado, 	PDO::PARAM_STR);
			$update -> bindParam(":id_resena", 	$id_resena, PDO::PARAM_INT);

			if ($update -> execute()) 
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