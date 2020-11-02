<?php
	require_once "../../../controlador/adm/con_pedidos.php";
	require_once "../../../modelo/adm/mod_pedidos.php";

	if (isset($_POST['action'])) 
	{
		switch ($_POST['action']) 
		{
			case 'listaPedidos':
				# LISTA DE PEDIDOS DEL USUARIO
				//$email = $_POST['email'];

				$mis_pedidos = new PedidosCon();
				$mis_pedidos -> listaPedidosCon();

				break;
			
			default:
				print json_encode(array("estado" => "No hay respuesta"));
				break;
		}
	}
?>