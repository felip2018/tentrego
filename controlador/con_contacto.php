<?php
	/**
	* CONTROLADOR DE CONTACTO
	*/
	class ContactoCon
	{
		
		#	SOLICITAR ENVIO DE MENSAJE
		public function enviarMensajeCon($parametros)
		{
			$respuesta = ContactoMod::enviarMensajeMod($parametros);
			print $respuesta;
		}
	}
?>