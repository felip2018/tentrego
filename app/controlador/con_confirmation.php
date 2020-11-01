<?php
	/**
	* CONTROLADOR DE CONFIRMACION DE LA TRANSACCION
	*/
	class ConfirmationCon
	{
		
		#	SOLICITAR CONFIRMACION DE TRANSACCION
		public function confirmacionPedidoCon($datosConfirmacion)
		{
			$respuesta = ConfirmationMod::confirmacionPedidoMod($datosConfirmacion);
		}
	}
?>