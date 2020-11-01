<?php
	/**
	 * CONTROLADOR PARA EL CAMBIO DE CLAVE
	 */
	class CambioClaveCon
	{
		
		#	SOLICITAR VALIDACION DE PERMISO PARA REALIZAR EL CAMBIO DE CLAVE
		public function validarPermisoCon($email,$codigo_validacion)
		{
			$respuesta = CambioClaveMod::validarPermisoMod($email,$codigo_validacion);
			return $respuesta;
		}

		#	SOLICITAR ACTUALIZACION DE CLAVE DE USUARIO
		public function actualizarClaveCon($datosCambio)
		{
			$respuesta = CambioClaveMod::actualizarClaveMod($datosCambio);
			print $respuesta;
		}

		#	SOLICITAR CAMBIO DE CLAVE
		public function solicitarCambioClaveCon($email)
		{
			$respuesta = CambioClaveMod::solicitarCambioClaveMod($email);
			print $respuesta;
		}
	}	
?>