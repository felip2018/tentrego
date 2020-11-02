<?php
	require_once "conexion.php";
	require_once "mod_emails.php";
	/**
	* MODELO DE MIS PEDIDOS
	*/
	class MisPedidosMod extends Conexion
	{
		#	BUSCAR LISTA DE PEDIDOS DEL USUARIO EN SESION
		public static function listaPedidosMod($email)
		{
			$consulta = Conexion::conectar()->prepare("SELECT 	
																id_pedido,
																email,
																total,
																codigo_pedido,
																observaciones,
																fecha,
																estado
														FROM 	pedido 
														WHERE 	email = :email 
														ORDER BY fecha DESC");

			$consulta -> bindParam(":email", $email, PDO::PARAM_STR);

			$consulta -> execute();

			$pedidos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

			//$resultado = json_encode(array("estado" => (!empty($pedidos)?"success":"vacio"), "data" => $pedidos));

			return $pedidos;

		}

		#	CONSULTAR MAESTRO DEL PEDIDO
		public static function maestroPedidoMod($id_pedido)
		{
			$consulta = Conexion::conectar()->prepare("SELECT * FROM pedido WHERE id_pedido = :id_pedido");
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

		#	ACTUALIZAR PEDIDO COMO PAGO CONTRA ENTREGA
		public static function pagoContraEntregaMod($id_pedido)
		{
			$update = Conexion::conectar()->prepare("	UPDATE 	pedido 
														SET 	estado 		= 'contra entrega'
														WHERE 	id_pedido	= :id_pedido");

			$update -> bindParam(":id_pedido", $id_pedido, PDO::PARAM_INT);

			if ($update -> execute()) 
			{
				# SE HA DEFINIDO EL PAGO DEL PEDIDO CONTRA ENTREGA
				#	CONSULTAMOS EL CORREO DEL CLIENTE Y DEL ADMIN PARA ENVIAR LA NOTIFICACION AL ADMINISTRADOR
				$consulta = Conexion::conectar()->prepare("	SELECT 
															(SELECT 
															 usuarios.email 
															 FROM pedido 
															 INNER JOIN usuarios ON usuarios.email = pedido.email WHERE pedido.id_pedido = :id_pedido) envia,
															 (SELECT 
															 usuarios.email 
															 FROM usuarios 
															 WHERE usuarios.id_perfil = 1) recibe
															 FROM DUAL");

				$consulta -> bindParam(":id_pedido", $id_pedido, PDO::PARAM_INT);
				$consulta -> execute();
				$emails = $consulta -> fetch(PDO::FETCH_ASSOC);

				$envia 	= $emails['envia'];
				$recibe = $emails['recibe'];
				$asunto = "Pedido Contra Entrega";
				$mensaje = "Se ha definido el pedido #".$id_pedido." como pago contra entrega.";
				$fecha 	= date('Y-m-d');
				$estado = "sin leer";

				$notificacion = Conexion::conectar()->prepare("INSERT INTO notificaciones(id_notificacion, envia, recibe, asunto, notificacion, fecha, estado) VALUES (null, :envia, :recibe, :asunto, :notificacion, :fecha, :estado)");

				$notificacion -> bindParam(":envia", 		$envia, 		PDO::PARAM_STR);
				$notificacion -> bindParam(":recibe", 		$recibe, 		PDO::PARAM_STR);
				$notificacion -> bindParam(":asunto", 		$asunto, 		PDO::PARAM_STR);
				$notificacion -> bindParam(":notificacion", $mensaje, 		PDO::PARAM_STR);
				$notificacion -> bindParam(":fecha", 		$fecha, 		PDO::PARAM_STR);
				$notificacion -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);

				$notificacion -> execute();

				$resultado = json_encode(array("estado" => "success"));
				return $resultado;

			}
			else
			{
				# HA OCURRIDO UN ERROR
				$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
				return $resultado;
			}

		}

		#	CREAR CASO DE PRODUCTO ENTREGADO
		public static function crearCasoMod($datosCaso)
		{
			$id_pedido 		= $datosCaso['id_pedido'];
			$id_producto 	= $datosCaso['id_producto'];
			$motivo 		= $datosCaso['motivo'];
			$descripcion 	= $datosCaso['descripcion'];
			$fecha 			= date('Y-m-d');

			$consulta = Conexion::conectar()->prepare("SELECT 
				(SELECT MAX(id_caso) FROM producto_casos) id_caso,
				(SELECT codigo_pedido FROM pedido WHERE id_pedido = :id_pedido) codigo_pedido
				FROM DUAL");
			$consulta -> bindParam(":id_pedido", $id_pedido, PDO::PARAM_INT);
			$consulta -> execute();
			$consecutivo = $consulta -> fetch(PDO::FETCH_ASSOC);

			$id_caso = ($consecutivo['id_caso'] == null)? 1 : $consecutivo['id_caso'] + 1;
			$codigo_pedido = $consecutivo['codigo_pedido'];

			$estado = "Activo";

			$insert = Conexion::conectar()->prepare("INSERT INTO producto_casos(id_caso, id_pedido, id_producto, motivo, descripcion, fecha, estado) VALUES (:id_caso, :id_pedido, :id_producto, :motivo, :descripcion, :fecha, :estado)");

			$insert -> bindParam(":id_caso", 		$id_caso, 		PDO::PARAM_INT);
			$insert -> bindParam(":id_pedido", 		$id_pedido, 	PDO::PARAM_INT);
			$insert -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);
			$insert -> bindParam(":motivo",			$motivo, 		PDO::PARAM_STR);
			$insert -> bindParam(":descripcion", 	$descripcion, 	PDO::PARAM_STR);
			$insert -> bindParam(":fecha", 			$fecha,			PDO::PARAM_STR);
			$insert -> bindParam(":estado", 		$estado, 		PDO::PARAM_STR);

			if ($insert -> execute()) 
			{
				#	SE HA CREADO EL CASO CORRECTAMENTE
				$update = Conexion::conectar()->prepare("	UPDATE 	pedido_detalle 
															SET 	estado 		= :estado
															WHERE 	id_pedido 	= :id_pedido
															AND 	id_producto = :id_producto");

				$update -> bindParam(":estado", 		$motivo, 		PDO::PARAM_STR);
				$update -> bindParam(":id_pedido", 		$id_pedido, 	PDO::PARAM_INT);
				$update -> bindParam(":id_producto", 	$id_producto, 	PDO::PARAM_INT);

				if ($update -> execute()) 
				{
					#	SE HA ACTUALIZADO EL REGISTRO DEL PRODUCTO EN EL DETALLE DEL PEDIDO
					#	CONSULTAMOS LA INFORMACION DEL CLIENTE PARA NOTIFICAR AL ADMIN SOBRE EL CASO
					$consulta_notificacion = Conexion::conectar()->prepare("SELECT 
										(SELECT CONCAT(usuarios.nombre,' ',usuarios.apellido) AS nombre
										FROM usuarios
										INNER JOIN pedido ON pedido.email = usuarios.email
										WHERE pedido.id_pedido = :id_pedido) nombre_usuario,
										(SELECT usuarios.email
										FROM usuarios
										INNER JOIN pedido ON pedido.email = usuarios.email
										WHERE pedido.id_pedido = :id_pedido) email_usuario,
										(SELECT usuarios.telefono
										FROM usuarios
										INNER JOIN pedido ON pedido.email = usuarios.email
										WHERE pedido.id_pedido = :id_pedido) telefono_usuario,
										(SELECT CONCAT(usuarios.nombre,' ',usuarios.apellido) AS nombre
										FROM usuarios
										WHERE id_perfil = 1) nombre_admin,
										(SELECT usuarios.email
										FROM usuarios
										WHERE id_perfil = 1) email_admin
										FROM DUAL");

					$consulta_notificacion -> bindParam(":id_pedido", $id_pedido, PDO::PARAM_INT);
					$consulta_notificacion -> execute();
					$info = $consulta_notificacion -> fetch(PDO::FETCH_ASSOC);


					$parametros = json_encode(array("nombre_admin" 		=> $info['nombre_admin'],
													"nombre_usuario" 	=> $info['nombre_usuario'],
													"telefono_usuario" 	=> $info['telefono_usuario'],
													"caso"				=> $motivo,
													"email_usuario"		=> $info['email_usuario'],
													"id_pedido" 		=> $id_pedido,
													"codigo_pedido" 	=> $codigo_pedido));

					$notificacion_admin = Email::programarCorreo($info['email_admin'],$info['nombre_admin'],"Nuevo Caso","creacionCaso",$parametros);

					$resultado = json_encode(array("estado" => "success"));
				}
				else
				{
					$resultado = json_encode(array("estado" => "error", "data" => $update -> errorInfo()));
				}
			}
			else
			{
				#	HA OCURRIDO UN ERROR
				$resultado = json_encode(array("estado" => "error", "data" => $insert -> errorInfo()));
			}
			return $resultado;
		}

		#	CANCELAR PEDIDO
		public static function cancelarPedidoMod($datosPedido)
		{
			$id_pedido 		= $datosPedido['id_pedido'];
			$codigo_pedido 	= $datosPedido['codigo_pedido'];

			#	CONSULTAMOS EL ESTADO DEL PEDIDO
			$consulta = Conexion::conectar()->prepare("	SELECT 	estado 
														FROM 	pedido
														WHERE 	id_pedido 		= :id_pedido
														AND 	codigo_pedido 	= :codigo_pedido");

			$consulta -> bindParam(":id_pedido", 		$id_pedido, 	PDO::PARAM_INT);
			$consulta -> bindParam(":codigo_pedido", 	$codigo_pedido, PDO::PARAM_STR);
			$consulta -> execute();

			$pedido = $consulta -> fetch(PDO::FETCH_ASSOC);

			if ($pedido['estado'] == 'por pagar' || 
				$pedido['estado'] == "contra entrega" ||
				$pedido['estado'] == "pendiente") 
			{
				#	SI SE PUEDE CANCELAR EL PEDIDO
				$update = Conexion::conectar()->prepare("	UPDATE 	pedido
															SET 	estado 			= 'cancelado'
															WHERE 	id_pedido 		= :id_pedido
															AND 	codigo_pedido 	= :codigo_pedido");	
				
				$update -> bindParam(":id_pedido", 		$id_pedido, 	PDO::PARAM_INT);
				$update -> bindParam(":codigo_pedido", 	$codigo_pedido, PDO::PARAM_STR);

				if ($update -> execute()) 
				{
					# SE HA CANCELADO EL PEDIDO CORRECTAMENTE
					#	ACTUALIZAMOS EL DETALLE DEL PEDIDO
					$update_detalle = Conexion::conectar()->prepare("	UPDATE 	pedido_detalle
																		SET 	estado 		= 'cancelado'
																		WHERE 	id_pedido 	= :id_pedido");

					$update_detalle -> bindParam(":id_pedido", 	$id_pedido, PDO::PARAM_INT);

					if ($update_detalle -> execute()) 
					{
						$resultado = json_encode(array("estado" => "success"));	
					}
					else
					{
						$resultado = json_encode(array("estado" => "error", "data" => $update_detalle->errorInfo()));
					}
				}
				else
				{
					# NO SE PUDO CANCELAR EL PEDIDO
					$resultado = json_encode(array("estado" => "error", "data" => $update->errorInfo()));
				}
			}
			else
			{
				#	EL ESTADO DEL PEDIDO NO PERMITE REALIZAR LA CANCELACION
				$resultado = json_encode(array("estado" => "error", "data" => "No es posible cancelar el pedido, se encuentra en estado: <b>".$pedido['estado']."</b>"));
			}

			return $resultado;
		}

	}