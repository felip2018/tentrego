<?php
	/**
	* CONTROLADOR DE RESPUESTA DE TRANSACCION
	*/
	class ResponseCon
	{
		
		#	SOLICITAR ACTUALIZACION DE PEDIDO CON LOS DATOS DE LA TRANSACCION
		public function actualizarPedidoCon($datosTransaccion)
		{
			$respuesta = ResponseMod::actualizarPedidoMod($datosTransaccion);
		}
	}
?>