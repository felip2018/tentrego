<?php
	require_once "../../controlador/user_con_mis_pedidos.php";
	require_once "../../modelo/user_mod_mis_pedidos.php";

	if (isset($_POST['action'])) 
	{
		switch ($_POST['action']) 
		{
			case 'listaPedidos':
				# LISTA DE PEDIDOS DEL USUARIO
				$email = $_POST['email'];

				$mis_pedidos = new MisPedidosCon();
				$mis_pedidos -> listaPedidosCon($email);

				break;

			case 'pagoContraEntrega':
				# DEFINIR PAGO DE PEDIDO COMO: PAGO CONTRA ENTREGA
				$id_pedido = $_POST['id_pedido'];

				$mis_pedidos = new MisPedidosCon();
				$mis_pedidos -> pagoContraEntregaCon($id_pedido);

				break;

			case 'crearCaso':
				# CREAR CASO DE PRODUCTO ENTREGADO (DEVOLUCION O GARANTIA)
				$motivo 		= $_POST['caso'];
				$id_pedido 		= $_POST['id_pedido'];
				$id_producto 	= $_POST['id_producto'];
				$descripcion	= $_POST['motivo'];

				$datosCaso = array(	"id_pedido"		=> $id_pedido,
									"id_producto"	=> $id_producto,
									"motivo" 		=> $motivo,
									"descripcion"	=> $descripcion);

				$mis_pedidos = new MisPedidosCon();
				$mis_pedidos -> crearCasoCon($datosCaso);

				break;

			case 'cancelarPedido':
				# CANCELAR PEDIDO
				$id_pedido 		= $_POST['id_pedido'];
				$codigo_pedido 	= $_POST['codigo_pedido'];

				$datosPedido 	= array("id_pedido"		=> $id_pedido,
										"codigo_pedido"	=> $codigo_pedido);

				$mis_pedidos = new MisPedidosCon();
				$mis_pedidos -> cancelarPedidoCon($datosPedido);

				break;
			
			default:
				print json_encode(array("estado" => "No hay respuesta"));
				break;
		}
	}
?>