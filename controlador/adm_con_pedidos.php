<?php
	/**
	* CONTROLADOR DE MIS PEDIDOS
	*/
	class PedidosCon
	{
		#	SOLICITAR LISTADO DE PEDIDOS DEL USUARIO EN SESION
		public function listaPedidosCon()
		{
			$respuesta = PedidosMod::listaPedidosMod();
			//print $respuesta;
			return $respuesta;
		}

		#	SOLICITAR MAESTRO DEL PEDIDO
		public function maestroPedidoCon($id_pedido)
		{
			$respuesta = PedidosMod::maestroPedidoMod($id_pedido);
			return $respuesta;	
		}

		#	SOLICITAR DETALLE DE PEDIDO
		public function detallePedidoCon($id_pedido)
		{
			$respuesta = PedidosMod::detallePedidoMod($id_pedido);
			return $respuesta;
		}
	}
?>