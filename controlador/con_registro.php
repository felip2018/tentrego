<?php
	/**
	* CONTROLADOR DE REGISTRO
	*/
	class RegistroCon
	{
		
		#	REGISTRAR UN NUEVO USUARIO EN EL SISTEMA
		public function nuevoRegistroCon($datosUsuario)
		{
			$respuesta = RegistroMod::nuevoRegistroMod($datosUsuario);
			print $respuesta;
		}
	}
?>