<?php
	/**
	* CONTROLADOR DE MIS PEDIDOS
	*/
	class MisPedidosCon
	{
		#	SOLICITAR LISTADO DE PEDIDOS DEL USUARIO EN SESION
		public function listaPedidosCon($email)
		{
			$respuesta = MisPedidosMod::listaPedidosMod($email);
			//print $respuesta;
			return $respuesta;
		}

		#	SOLICITAR MAESTRO DEL PEDIDO
		public function maestroPedidoCon($id_pedido)
		{
			$respuesta = MisPedidosMod::maestroPedidoMod($id_pedido);
			return $respuesta;	
		}

		#	SOLICITAR DETALLE DE PEDIDO
		public function detallePedidoCon($id_pedido)
		{
			$respuesta = MisPedidosMod::detallePedidoMod($id_pedido);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE PEDIDO COMO PAGO CONTRA ENTREGA
		public function pagoContraEntregaCon($id_pedido)
		{
			$respuesta = MisPedidosMod::pagoContraEntregaMod($id_pedido);
			print $respuesta;
		}

		#	SOLICITAR CREACION DE CASO PARA PRODUCTO ENTREGADO
		public function crearCasoCon($datosCaso)
		{
			$respuesta = MisPedidosMod::crearCasoMod($datosCaso);
			print $respuesta;
		}

		#	SOLICITAR CANCELACION DE PEDIDO
		public function cancelarPedidoCon($datosPedido)
		{
			$respuesta = MisPedidosMod::cancelarPedidoMod($datosPedido);
			print $respuesta;
		}

	}
?>