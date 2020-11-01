<?php
	require_once "conexion.php";
	/**
	 * MODELO DE PROMOCIONES
	 */
	class PromocionesMod extends Conexion
	{
		
		#	CONSULTAR LISTADO DE PROMOCIONES DE PRODUCTOS ACTIVAS
		public static function listaPromocionesMod()
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														producto.id_producto,
														producto.id_categoria,
														producto.id_clasificacion,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.imagen,
														producto.estado,
														promociones.id_promocion,
														promociones.venta,
														promociones.dcto descuento,
														promociones.precio_promo promocion,
														promociones.fecha,
														promociones.estado estado_promocion
														FROM promociones
														INNER JOIN producto ON producto.id_producto = promociones.id_producto
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														ORDER BY promociones.id_promocion DESC");

			$consulta -> execute();
			$promociones = $consulta -> fetchAll(PDO::FETCH_ASSOC);
			return $promociones;

		}

		#	CAMBIAR ESTADO DE PROMOCION
		public static function estadoPromocionMod($datosPromocion)
		{
			$estado 		= $datosPromocion['estado'];
			$id_promocion 	= $datosPromocion['id_promocion'];

			$update = Conexion::conectar()->prepare("	UPDATE 	promociones
														SET 	estado 			= :estado
														WHERE 	id_promocion	= :id_promocion");

			$update -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);
			$update -> bindParam(":id_promocion",	$id_promocion, 	PDO::PARAM_INT);

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