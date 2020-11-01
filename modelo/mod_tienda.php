<?php
	require_once "conexion.php";
	/**
	* MODELO DE TIENDA
	*/
	class TiendaMod extends Conexion
	{
		#	CONSULTAR EL LISTADO DE CATEGORIAS
		public static function listaCategoriasMod()
		{
			$categorias = Conexion::conectar()->prepare("	SELECT * 
															FROM categorias 
															WHERE estado = 'Activo' 
															ORDER BY nombre ASC");
			$categorias -> execute();
			$listado 	=  $categorias -> fetchAll();
			return $listado;
		}

		#	CONSULTAR LISTA DE CLASIFICACION POR CATEGORIA SELECCIONADA
		public static function listaClasificacionMod($id_categoria)
		{
			$consulta = Conexion::conectar()->prepare(" SELECT * 
														FROM 	clasificacion 
														WHERE 	id_categoria 	= :id_categoria
														AND 	estado 			= 'Activo'
														ORDER BY nombre ASC");
			$consulta -> bindParam(":id_categoria", $id_categoria,	PDO::PARAM_INT);
			$consulta -> execute();
			$clasificaciones = $consulta -> fetchAll();
			if (sizeof($clasificaciones) > 0) 
			{
				$resultado = json_encode(array("estado" => "ok", "data" => $clasificaciones));
			}
			else
			{
				$resultado = json_encode(array("estado" => "vacio"));
			}
			return $resultado;
		}

		#	CONSULTAR LISTA DE CLASIFICACION POR CATEGORIA SELECCIONADA
		public static function listadoClasificacionMod($id_categoria)
		{
			$consulta = Conexion::conectar()->prepare(" SELECT * 
														FROM 	clasificacion 
														WHERE 	id_categoria 	= :id_categoria
														AND 	estado 			= 'Activo'
														ORDER BY nombre ASC");
			$consulta -> bindParam(":id_categoria", $id_categoria,	PDO::PARAM_INT);
			$consulta -> execute();
			$clasificaciones = $consulta -> fetchAll();
			
			return $clasificaciones;
		}

		#	CONSULTAR EL LISTADO DE MARCAS
		public static function listaMarcasMod()
		{
			$marcas = Conexion::conectar()->prepare("SELECT * 
													FROM marcas 
													WHERE estado = 'Activo' 
													ORDER BY nombre ASC");
			$marcas -> execute();
			$listado 	=  $marcas -> fetchAll();
			return $listado;
		}

		#	CONSULTAR EL LISTADO DE UNIDADES DE MEDIDA
		public static function listaUnidadesMod()
		{
			$unidades = Conexion::conectar()->prepare(" SELECT * 
														FROM unidades 
														WHERE estado = 'Activo' 
														ORDER BY id_unidad ASC");
			$unidades -> execute();
			$listado 	=  $unidades -> fetchAll();
			return $listado;
		}

		#	CONSULTAR LISTADO DE PRODUCTOS REGISTRADOS
		public static function listaProductosMod()
		{
			$consulta = Conexion::conectar()->prepare("	SELECT 
														producto.id_producto,
														producto.id_categoria,
														producto.id_clasificacion,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.cantidad,
														producto.id_unidad,
														producto.imagen,
														producto.costo,
														producto.utilidad,
														producto.venta,
														producto.fecha,
														producto.estado,
														categorias.nombre categoria,
														clasificacion.nombre clasificacion,
														unidades.nombre unidad,
														promociones.dcto descuento,
														promociones.precio_promo promocion,
														promociones.estado estado_promocion
														FROM producto 
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														INNER JOIN categorias ON categorias.id_categoria = producto.id_categoria
														INNER JOIN clasificacion ON clasificacion.id_clasificacion = producto.id_clasificacion
														INNER JOIN unidades ON unidades.id_unidad = unidades.id_unidad
														LEFT JOIN promociones ON promociones.id_producto = producto.id_producto
														AND promociones.estado = 'Activo'
														WHERE producto.estado = 'Activo'
														GROUP BY producto.id_producto
														ORDER BY nombre");
			$consulta -> execute();
			$listado = $consulta ->fetchAll();
			return $listado;
		}

		#	CONSULTAR INFORMACION REGISTRADA DE UN PRODUCTO SELECCIONADO
		public static function infoProductoMod($id_producto)
		{
			$consulta = Conexion::conectar()->prepare("SELECT * FROM producto WHERE id_producto = :id_producto");
			$consulta -> bindParam(":id_producto",	$id_producto, 	PDO::PARAM_INT);
			$consulta -> execute();
			$info = $consulta -> fetch();
			return $info; 
		}

		#	SELECCIONAR PRODUCTOS POR CATEGORIA SELECCIONADA
		public static function filtroTiendaMod($id_categoria)
		{
			$consulta = Conexion::conectar()->prepare("	SELECT 
														producto.id_producto,
														producto.id_categoria,
														producto.id_clasificacion,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.cantidad,
														producto.id_unidad,
														producto.imagen,
														producto.costo,
														producto.utilidad,
														producto.venta,
														producto.fecha,
														producto.estado,
														categorias.nombre categoria,
														clasificacion.nombre clasificacion,
														unidades.nombre unidad,
														promociones.dcto descuento,
														promociones.precio_promo promocion,
														promociones.estado estado_promocion
														FROM producto 
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														INNER JOIN categorias ON categorias.id_categoria = producto.id_categoria
														INNER JOIN clasificacion ON clasificacion.id_clasificacion = producto.id_clasificacion
														INNER JOIN unidades ON unidades.id_unidad = unidades.id_unidad
														LEFT JOIN promociones ON promociones.id_producto = producto.id_producto
														AND promociones.estado = 'Activo'
														WHERE producto.id_categoria = :id_categoria
														AND producto.estado = 'Activo'
														GROUP BY producto.id_producto
														ORDER BY nombre");
			$consulta -> bindParam(":id_categoria",	$id_categoria, PDO::PARAM_INT);
			$consulta -> execute();
			$resultado = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			$respuesta = json_encode(array("estado" => (empty($resultado)?"vacio":"ok"), "data" => $resultado));

			return $respuesta;
		}

		#	SELECCIONAR PRODUCTOS POR CATEGORIA Y CLASIFICACION SELECCIONADA
		public static function filtroProductosClasificacionMod($id_categoria,$id_clasificacion)
		{
			$consulta = Conexion::conectar()->prepare("	SELECT 
														producto.id_producto,
														producto.id_categoria,
														producto.id_clasificacion,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.cantidad,
														producto.id_unidad,
														producto.imagen,
														producto.costo,
														producto.utilidad,
														producto.venta,
														producto.fecha,
														producto.estado,
														categorias.nombre categoria,
														clasificacion.nombre clasificacion,
														unidades.nombre unidad,
														promociones.dcto descuento,
														promociones.precio_promo promocion,
														promociones.estado estado_promocion
														FROM producto 
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														INNER JOIN categorias ON categorias.id_categoria = producto.id_categoria
														INNER JOIN clasificacion ON clasificacion.id_clasificacion = producto.id_clasificacion
														INNER JOIN unidades ON unidades.id_unidad = unidades.id_unidad
														LEFT JOIN promociones ON promociones.id_producto = producto.id_producto
														AND promociones.estado = 'Activo'
														WHERE producto.id_categoria = :id_categoria
														AND producto.id_clasificacion = :id_clasificacion
														AND producto.estado = 'Activo'
														GROUP BY producto.id_producto
														ORDER BY nombre");

			$consulta -> bindParam(":id_categoria",		$id_categoria, 		PDO::PARAM_INT);
			$consulta -> bindParam(":id_clasificacion",	$id_clasificacion, 	PDO::PARAM_INT);

			$consulta -> execute();
			$resultado = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			$respuesta = json_encode(array("estado" => (empty($resultado)?"vacio":"ok"), "data" => $resultado));

			return $respuesta;
		}

	}