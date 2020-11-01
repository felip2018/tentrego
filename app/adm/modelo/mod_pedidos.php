<?php
	require_once "conexion.php";
	/**
	* MODELO DE MIS PEDIDOS
	*/
	class PedidosMod extends Conexion
	{
		#	BUSCAR LISTA DE PEDIDOS DEL USUARIO EN SESION
		public static function listaPedidosMod()
		{
			$consulta = Conexion::conectar()->prepare("SELECT * 
														FROM pedido 
														ORDER BY fecha DESC");

			$consulta -> execute();

			$pedidos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			$resultado = json_encode(array("estado" => (!empty($pedidos)?"success":"vacio"), "data" => $pedidos));

			return $pedidos;

		}

		#	CONSULTAR MAESTRO DEL PEDIDO
		public static function maestroPedidoMod($id_pedido)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														pedido.id_pedido,
														pedido.email,
														pedido.total,
														pedido.codigo_pedido,
														pedido.fecha,
														pedido.estado,
														CONCAT(tipo_identi.nombre,' ',usuarios.num_identi) AS identificacion_usuario,
														CONCAT(usuarios.nombre,' ',usuarios.apellido) AS nombre_usuario,
														usuarios.telefono telefono_usuario,
														usuarios.direccion direccion_usuario,
														usuarios.estado estado_usuario 
														FROM pedido
														INNER JOIN usuarios ON usuarios.email = pedido.email 
														INNER JOIN tipo_identi ON tipo_identi.id_tipo_identi = usuarios.id_tipo_identi
														WHERE pedido.id_pedido = :id_pedido");
			$consulta -> bindParam(":id_pedido",$id_pedido,PDO::PARAM_INT);
			$consulta -> execute();
			$pedido = $consulta->fetch(PDO::FETCH_ASSOC);
			return $pedido;
		}

		#	CONSULTAR DETALLE DE PEDIDO
		public static function detallePedidoMod($id_pedido)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 
														pedido_detalle.id_pdetalle,
														pedido_detalle.id_pedido,
														pedido_detalle.id_producto,
														pedido_detalle.valor_unitario,
														pedido_detalle.cantidad,
														pedido_detalle.valor_total,
														pedido_detalle.origen,
														pedido_detalle.recomienda,
														pedido_detalle.fecha,
														pedido_detalle.estado,
														producto.nombre,
														producto.imagen,
														producto.descripcion,
														categorias.nombre categoria,
														clasificacion.nombre clasificacion,
														marcas.nombre marca
														FROM pedido_detalle
														INNER JOIN producto ON producto.id_producto = pedido_detalle.id_producto
														INNER JOIN categorias ON categorias.id_categoria = producto.id_categoria
														INNER JOIN clasificacion ON clasificacion.id_clasificacion = producto.id_clasificacion
														INNER JOIN marcas ON marcas.id_marca = producto.id_marca
														WHERE pedido_detalle.id_pedido = :id_pedido
														ORDER BY pedido_detalle.id_pdetalle ASC");

			$consulta -> bindParam(":id_pedido", $id_pedido, PDO::PARAM_INT);
			$consulta -> execute();
			$detalle = $consulta->fetchAll(PDO::FETCH_ASSOC);
			return $detalle;
		}
	}