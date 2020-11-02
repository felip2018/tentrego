<?php
	require_once "conexion.php";
	require_once "../mod_emails.php";
	/**
	 * MODELO DE DEVOLUCIONES Y GARANTIAS
	 */
	class CasosMod extends Conexion
	{
		
		#	CONSULTAR LISTADO DE CASOS DE PRODUCTOS REGISTRADOS
		public static function casosProductosMod()
		{
			$consulta = Conexion::conectar()->prepare("	SELECT 
														producto.id_producto,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.imagen,
														producto_casos.id_caso,
														producto_casos.id_pedido,
														producto_casos.motivo,
														producto_casos.descripcion,
														producto_casos.fecha,
														producto_casos.estado,
														pedido.codigo_pedido
														FROM producto_casos
														INNER JOIN producto ON producto.id_producto = producto_casos.id_producto
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														INNER JOIN pedido ON pedido.id_pedido = producto_casos.id_pedido
														ORDER BY producto_casos.id_caso DESC");

			$consulta -> execute();
			$casos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
			return $casos;

		}

		#	CONSULTAR INFORMACION DEL CASO
		public static function infoCasoMod($id_caso)
		{
			$consulta = Conexion::conectar()->prepare("SELECT
														producto_casos.id_pedido,
														producto_casos.id_producto,
														producto_casos.motivo,
														producto_casos.descripcion,
														producto_casos.fecha,
														producto_casos.estado,
														pedido.codigo_pedido,
														CONCAT(usuarios.nombre,' ',usuarios.apellido) AS cliente,
														usuarios.email,
														usuarios.telefono,
														usuarios.direccion,
														usuarios.foto,
														CONCAT(marcas.nombre,' ',producto.nombre) AS producto,
														producto.imagen
														FROM producto_casos
														INNER JOIN pedido ON pedido.id_pedido = producto_casos.id_pedido
														INNER JOIN usuarios ON usuarios.email = pedido.email
														INNER JOIN producto ON producto.id_producto = producto_casos.id_producto
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														WHERE producto_casos.id_caso = :id_caso");

			$consulta -> bindParam(":id_caso",	$id_caso,	PDO::PARAM_INT);

			$consulta -> execute();

			$info = $consulta -> fetch(PDO::FETCH_ASSOC);

			return $info;

		}

		#	ACTUALIZAR PROCESO DEL CASO
		public static function actualizarProcesoMod($datosProceso)
		{
			$id_caso 		= $datosProceso['id_caso'];
			$cliente 		= $datosProceso['cliente'];
			$email 			= $datosProceso['email'];
			$estado 		= $datosProceso['estado'];
			$descripcion 	= $datosProceso['descripcion'];
			$fecha 			= date('Y-m-d H:i:s');

			$consulta = Conexion::conectar()->prepare("	SELECT 	MAX(id_proceso) id_proceso
														FROM 	producto_casos_proceso
														WHERE 	id_caso 	= :id_caso");
			$consulta -> bindParam(":id_caso",	$id_caso, 	PDO::PARAM_INT);
			$consulta -> execute();
			$con = $consulta -> fetch(PDO::FETCH_ASSOC);

			$id_proceso = ($con['id_proceso'] == null) ? 1 : $con['id_proceso'] + 1;

			$insert = Conexion::conectar()->prepare("INSERT INTO producto_casos_proceso(id_proceso, id_caso, estado, descripcion, email, fecha) VALUES (:id_proceso, :id_caso, :estado, :descripcion, :email, :fecha)");

			$insert -> bindParam(":id_proceso", 	$id_proceso, 	PDO::PARAM_INT);
			$insert -> bindParam(":id_caso", 		$id_caso, 		PDO::PARAM_INT);
			$insert -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);
			$insert -> bindParam(":descripcion", 	$descripcion,	PDO::PARAM_STR);
			$insert -> bindParam(":email", 			$email, 		PDO::PARAM_STR);
			$insert -> bindParam(":fecha", 			$fecha, 		PDO::PARAM_STR);

			if ($insert -> execute()) 
			{
				#	ACTUALIZAR MAESTRO DEL CASO
				$update = Conexion::conectar()->prepare("	UPDATE 	producto_casos
															SET 	estado 	= :estado
															WHERE 	id_caso	= :id_caso");

				$update -> bindParam(":estado", $estado, PDO::PARAM_STR);
				$update -> bindParam(":id_caso",$id_caso,PDO::PARAM_INT);

				$update -> execute();

				#	NOTIFICACION AL USUARIO VIA EMAIL

				$asunto 	= "Actualización caso";
				$plantilla 	= "actualizacionCaso";
				$parametros = json_encode(array("cliente" 		=> $cliente,
												"estado"  		=> $estado,
												"descripcion" 	=> $descripcion));

				$notificacion = Email::programarCorreo($email,$cliente,$asunto,$plantilla,$parametros);	
				
				if ($notificacion) 
				{
					$resultado = json_encode(array("estado" => "success"));
				}
				else
				{
					$resultado = json_encode(array("estado" => "success no email"));
				}
			}
			else
			{
				$resultado = json_encode(array("estado" => "error", "data" => $insert->errorInfo()));
			}
			return $resultado;
		}

		#	CONSULTAR TRAZABILIDAD DEL CASO
		public static function trazabilidadCasoMod($id_caso)
		{
			$consulta = Conexion::conectar()->prepare("	SELECT *
														FROM 	producto_casos_proceso
														WHERE 	id_caso = :id_caso
														ORDER BY id_proceso DESC");

			$consulta -> bindParam(":id_caso",	$id_caso,	PDO::PARAM_INT);
			$consulta -> execute();
			$trazabilidad = $consulta -> fetchAll(PDO::FETCH_ASSOC);
			return $trazabilidad;
		}

	}