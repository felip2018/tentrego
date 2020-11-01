<?php
	/**
	 * CONTROLADOR DE PROMOCIONES
	 */
	class PromocionesCon
	{
		
		#	SOLICITAR LISTADO DE PROMOCIONES DE PRODUCTOS ACTIVAS
		public function listaPromocionesCon()
		{
			$respuesta = PromocionesMod::listaPromocionesMod();
			return $respuesta;
		}

		#	CAMBIAR ESTADO DE LA PROMOCION
		public function estadoPromocionCon($datosPromocion)
		{
			$respuesta = PromocionesMod::estadoPromocionMod($datosPromocion);
			print $respuesta;
		}
	}
?>