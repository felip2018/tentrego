<?php
	/**
	* CONTROLADOR DE VALIDACION DE CUENTA
	*/
	class ValidacionCon
	{
		
		#	SOLICITAR VALIDACION DE CUENTA
		public function validarCuentaCon($datosValidacion)
		{
			$respuesta = ValidacionMod::validarCuentaMod($datosValidacion);
			print $respuesta;
		}
	}
?>