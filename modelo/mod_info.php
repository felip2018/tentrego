<?php
	require_once "conexion.php";
	/**
	* MODELO DE INFORMACION DE PRODUCTO
	*/
	class InfoMod extends Conexion
	{
		
		#	BUSCAR INFORMACION DEL PRODUCTO SELECCIONADO
		public static function infoProductoMod($productId)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														producto.id_producto,
														producto.id_categoria,
														producto.id_clasificacion,
														producto.id_marca,
														CONCAT(marcas.nombre,' ',producto.nombre) AS nombre,
														producto.cantidad,
														producto.id_unidad,
														producto.imagen,
														producto.descripcion,
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
														WHERE producto.id_producto = :id_producto");

			$consulta -> bindParam(":id_producto", 	$productId, 	PDO::PARAM_INT);

			$consulta -> execute();

			$info = $consulta -> fetch(PDO::FETCH_ASSOC);

			return $info;

		}

		#	CONSULTAMOS EL LISTADO DE ATRIBUTOS REGISTRADOS DEL PRODUCTO
		public static function listaAtributosMod($id_producto)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														producto_atributo.id_producto,
														producto_atributo.id_atributo,
														producto_atributo.valor,
														producto_atributo.estado,
														atributos.nombre
														FROM producto_atributo
														INNER JOIN atributos ON atributos.id_atributo = producto_atributo.id_atributo
														WHERE id_producto = :id_producto
														AND producto_atributo.estado = 'Activo'");

			$consulta -> bindParam(":id_producto",	$id_producto,	PDO::PARAM_INT);

			$consulta -> execute();

			$atributos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			return $atributos;

		}

		#	CONSULTAMOS LAS RESEÑAS DEL PRODUCTO
		public static function listaResenasMod($id_producto)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														producto_resena.id_resena,
                                                        producto_resena.id_producto,
                                                        producto_resena.email,
                                                        producto_resena.calificacion,
                                                        producto_resena.comentarios,
                                                        producto_resena.fecha,
                                                        producto_resena.estado,
														CONCAT(usuarios.nombre,' ',usuarios.apellido) AS usuario 
														FROM producto_resena 
														INNER JOIN usuarios ON usuarios.email = producto_resena.email
														WHERE 	producto_resena.id_producto = :id_producto
														AND 	producto_resena.estado 		= 'Activo'
                                                        ORDER BY producto_resena.fecha DESC");

			$consulta -> bindParam(":id_producto",	$id_producto,	PDO::PARAM_INT);

			$consulta -> execute();

			$resenas = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			return $resenas;

		}

		#	CONSULTAR IMAGENES DEL PRODUCTO
		public static function imagenesProductoMod($id_producto)
		{
			$consulta = Conexion::conectar()->prepare("SELECT * 
														FROM 	producto_imagenes
														WHERE 	id_producto 	= :id_producto
														AND 	estado 			= 'Activo'");

			$consulta -> bindParam(":id_producto",	$id_producto, 	PDO::PARAM_INT);

			$consulta -> execute();

			$imagenes = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			return $imagenes;

		}

	}